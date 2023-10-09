<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 17.8.2018.
 * Time: 12:25
 */

namespace App\ShoppingCart;


use App\Mail\MyNinetAccessParameters;
use App\Mail\PreInvoice;
use App\Mail\SslOrdered;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Origin;
use App\Models\SslServerPlatform;
use App\OrderDetailParameters;
use App\Password;
use App\Services\Eracuni\EracuniException;
use App\Services\Eracuni\Facade\Eracuni;
use App\Shoppingcart\Facades\Cart;

class CartToOrder
{
    public static function makeOrder($phone_notification = false)
    {

        try {
            \DB::beginTransaction();

            $customer = self::getCustomerOrMakeNew($phone_notification);

            $currency_id = \App::getLocale() == 'sr-Latn' ? 1 : 2;

            $orderStatus = OrderStatus::where('code', 'new')->first();
            $orderOrigin = Origin::where('code', 'public')->first();

            $order = new Order([
                'customer_id' => $customer->id,
                'status_id'   => $orderStatus->id,
                'origin_id'   => $orderOrigin->id,
                'currency_id' => $currency_id,
            ]);
            $order->setOrderNumber();
            $order->save();

            $itemNumbersArray = self::getItemNumbersArray();

            foreach (\App\Shoppingcart\Facades\Cart::content() as $cartItem) {

                $detailName = $cartItem->name;
                $period = $cartItem->period;
                $modelType = empty($cartItem->parentRowId) ? 'App\Models\Product' : 'App\Models\Subproduct';
                $Model = (new $modelType)->where('id', $cartItem->id)->with('productLine.productCategory')->first();

                if ($modelType == 'App\Models\Product') {
                    if ($Model->productLine->productCategory->code == 'vps') {
                        $Parameters = new OrderDetailParameters();
                        $Parameters->hostname = $cartItem->options->hostname ?? 'localhost';
                        $Parameters->template = $cartItem->options->template ?? 'centos-7-x86_64-minimal';
                        $Parameters->ip_number = $cartItem->options->ip_number !== null ? ($cartItem->options->ip_number + 1) : 1;
                    }

                    if ($Model->productLine->productCategory->code === 'hosting') {
                        $Parameters = new OrderDetailParameters();
                        $Parameters->domain = $cartItem->options->domain ?? null;
                        $Parameters->existingDomain = $cartItem->options->existingDomain ?? null;
                        if($Model->productLine->code === 'mail-servers') {
                            $Parameters->add_quota = $cartItem->options->add_quota ?? null;
                        }
                    }

                    if ($Model->productLine->productCategory->code === 'domains') {
                        $Parameters = new OrderDetailParameters();
                        $Parameters->whois = $cartItem->options->whois ?? false;
                        $Parameters->nameservers = ['ns1.hostingweb.rs', 'ns2.hostingweb.rs', 'ns3.hostingweb.rs'];
                    }

                    if (in_array($Model->productLine->productCategory->code, ['dedicated-servers', 'server-housing'])) {
                        $Parameters = new OrderDetailParameters();
                        $Parameters->operating_system_id = $cartItem->options->operating_system_id ?? null;
                        $Parameters->hostname = $cartItem->options->hostname;
                    }

                    if ($Model->productLine->productCategory->code === 'ssl') {
                        if(isset($cartItem->options['domain'])) {
                            $detailName .= ' - ';
                            $detailName .= $cartItem->options['domain'];
                        }
                        $sslServerPlatform = null;
                        if(isset($cartItem->options['server_platform_type'])) {
                            $sslServerPlatform = SslServerPlatform::find($cartItem->options['server_platform_type'])->name;
                        }

                        $Parameters = new OrderDetailParameters();
                        $Parameters->csr_code = $cartItem->options->csr_code ?? null;
                        $Parameters->domain = $cartItem->options->domain ?? null;
                        $Parameters->confirmation_email = $cartItem->options->confirmation_email ?? null;
                        $Parameters->server_platform_type = $sslServerPlatform ?? null;
                    }
                }

                if (in_array($Model->productLine->productCategory->code, ['domains', 'hosting', 'ssl']) && $Model->productLine->code !== 'mail-servers') {
                    $period *= 12;
                }

                $orderDetail = new OrderDetail([
                    'item_number'         => empty($cartItem->parentRowId) ? $itemNumbersArray[$cartItem->rowId] : $itemNumbersArray[$cartItem->parentRowId],
                    'description'         => $detailName,
                    'price'               => $cartItem->total,
                    'quantity'            => $cartItem->qty,
                    'period_months'       => $period,
                    'discount_percentage' => $cartItem->discountPercentage ? round($cartItem->discountPercentage, 2) : null,
                    'model_type'          => $modelType,
                    'model_id'            => $cartItem->id,
                    'parameters'          => !empty($Parameters) ? $Parameters->toJson() : null,
                ]);
                if ($order->orderDetails()->save($orderDetail)) {
                    if ($Model->productLine->productCategory->code === 'ssl') {
                        \Mail::to('ninetnotif@webglobe.rs')->send(new SslOrdered([
                            'csrCode'            => $Parameters->csr_code ?? null,
                            'orderNumber'        => $order->order_number,
                            'ssl'                => $orderDetail->description,
                            'domain'             => $Parameters->domain ?? null,
                            'confirmation_email' => $Parameters->confirmation_email ?? null,
                            'serverPlatformType' => $sslServerPlatform ?? null,
                        ]));
                    }
                }
                $Parameters = null;
            }

            $emailsForOrder = [];

            foreach ($order->orderDetails as $item) {
                if($item->model_type === 'App\Models\Product') {
                    $category = $item->getBoundModel()->productLine->productCategory->code ?? null;
                    switch($category) {
                        case 'domains': $emailsForOrder[] = 'ninetnotif@webglobe.rs'; break;
                        case 'hosting': $emailsForOrder[] = 'ninetnotif@webglobe.rs'; break;
                        case 'vps':
                        case 'dedicated-servers':
                        case 'server-housing':
                            $emailsForOrder[] = 'ninetnotif@webglobe.rs'; break;
                        case 'ssl': $emailsForOrder[] = 'ninetnotif@webglobe.rs'; break;
                    }
                }
            }

            $emailsForOrder = array_unique($emailsForOrder);

            \Mail::to($emailsForOrder)->send(new PreInvoice($order));

            $mainContact = $order->customer->contacts->where('contact_type_id', 1)->first();
            \Mail::to($mainContact->email)->send(new PreInvoice($order));

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::channel('order')->error('Order error', ['exception' => $e]);
            return false;
        }

            Cart::backup();
            Cart::destroy();
            \Session::remove('cart_contact_data');


        return $order;
    }

    /**
     * Creates new customer or gets an existing one
     *
     * @return Customer|\Illuminate\Database\Eloquent\Model|null|object
     */
    protected static function getCustomerOrMakeNew($phone_notification = false)
    {
        $cartContact = \App\ShoppingCart\Facades\CartContact::get();

        if (!empty($cartContact->customerId)) {
            $customer = Customer::find($cartContact->customerId);
            $customer->phone_notification = $phone_notification;
            $customer->save();
        } else {
            $customer = new Customer();
            $password = Password::generateStrongPassword(9, false, 'luds');
            $customer->email = $cartContact->email;
            $customer->password = bcrypt($password);
            $customer->customer_status_id = 1;
            $customer->phone_notification = $phone_notification;
//            $customer->setCustomerCode();
            $customer->save();

            $contactData = [
                'contact_type_id' => 1,
                'first_name'      => $cartContact->firstName,
                'last_name'       => $cartContact->lastName,
                'is_legal_entity' => !empty($cartContact->companyName) ? 1 : 0,
                'address'         => $cartContact->address,
                'postal_code'     => $cartContact->postalCode,
                'city'            => $cartContact->city,
                'country_id'      => $cartContact->countryId,
                'phone'           => $cartContact->phone,
                'email'           => $cartContact->email,
            ];
            if (isset($cartContact->companyName)) {
                $contactData['company_name'] = $cartContact->companyName;
                $contactData['company_registration_number'] = $cartContact->companyRegistrationNumber;
                $contactData['company_tax_number'] = $cartContact->companyTaxNumber;
            }
            $contact = new Contact($contactData);

            $customer->contacts()->save($contact);

            \Mail::to($customer->email)->send(new MyNinetAccessParameters($customer, $password));

//            try {
//                $partner = Eracuni::PartnerCreate([
//                    'partnerCode' => $customer->customer_code,
//                    'companyType' => $contact->is_legal_entity ? 'Organization' : 'Unknown',
//                    'eMail' => $contact->email,
//                    'firstName' => $contact->first_name,
//                    'lastName' => $contact->last_name,
//                    'mobilePhone' => $contact->phone,
//                    'city' => $contact->city,
//                    'country' => $contact->country->code,
//                    'postalCode' => $contact->postalCode,
//                    'street' => $contact->address,
//                    'type' => 'Primary',
//                    'dateOfBirth' => '',
//                    'vatRegistration' => 'None',
//                    'telephone' => '',
//                    'maritalStatus' => '',
//                    'gender' => 'unknown',
//                    'ID' => '',
//                ]);
//
//                \Log::channel('eracuni')->info('Partner Created', ['data' => $partner]);
//
//            } catch (EracuniException $e) {
//                \Log::channel('eracuni')->error('Partner Create error', ['exception' => $e]);
//                $customer->customer_code = null;
//                $customer->save();
//            }
        }

        return $customer;
    }

    /**
     * @return array
     */
    protected static function getItemNumbersArray()
    {
        $array = [];
        $counter = 1;
        foreach (\App\Shoppingcart\Facades\Cart::mainItems() as $cartItem) {
            $array[$cartItem->rowId] = $counter;
            $counter++;
        }

        return $array;
    }
}