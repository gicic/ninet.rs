<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 8.8.2018.
 * Time: 15:57
 */

namespace App;


use App\Mail\DomainRegistration;
use App\Mail\HostingAccessParameters;
use App\Mail\VpsAccessParameters;
use App\Models\DomainResource;
use App\Models\DomainStatus;
use App\Models\HostingResource;
use App\Models\HostingStatus;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\SolusNode;
use App\Models\SolusNodeType;
use App\Models\VpsResource;
use App\Models\VpsStatus;
use App\Repositories\WhmRepository;
use App\Services\Domains\Facades\Domains;
use App\Services\OneTimeSecret\Facade\OTS;
use App\Services\RouterOS\RouterOS;
use App\Solus\Facade\Solus;
use App\WHM\WHM;
use Carbon\Carbon;

class ExternalResource
{

    public static function createOrderResource(Order $order)
    {
        return \App\Services\CoreAPI\Facades\ExternalResource::createOrderExternalResource($order->id);

//        foreach ($order->orderDetails as $detail) {
//            $category = $detail->getCategory();
//
//            if (!$detail->hasResource() && $detail->model_type === 'App\Models\Product') {
//                switch ($category->code) {
//                    case 'vps':
//                        self::createSolusVserver($detail);
//                        break;
//                    case 'hosting':
//                        self::createHostingAccount($detail);
//                        break;
//                    case 'domains':
//                        self::registerDomain($detail);
//                        break;
//                    case 'ssl':
//                        self::createSsl($detail);
//                        break;
//                }
//            }
//        }
//        return null;
    }

    /**
     * @param OrderDetail $orderDetail
     * @return array|bool
     */
    public static function createSolusVserver(OrderDetail $orderDetail)
    {
        date_default_timezone_set('Europe/Belgrade');
        if ($orderDetail->hasResource()) {
            return false;
        }

        try {
            $mainContact = $orderDetail->order->customer->contacts->where('contact_type_id', 1)->first();
            $existingClient = Solus::getClientByEmail($mainContact->email);

            $productLine = $orderDetail->getBoundModel()->productLine;
            $nodeType = SolusNodeType::where('code', $productLine->code)->first();
            $node = SolusNode::where('solus_node_type_id', $nodeType->id)->first();

//            $clientIsNew = false;
//            if (empty($existingClient)) {
//                $clientPassword = Password::generateStrongPassword();
//                $client = Solus::createClient([
//                    'email'     => $mainContact->email,
//                    'firstname' => $mainContact->first_name,
//                    'lastname'  => $mainContact->last_name,
//                    'password'  => $clientPassword,
//                    'company'   => $mainContact->company_name,
//                ]);
//                $clientIsNew = true;
//            } else {
//                $client = $existingClient;
//            }

            $Parameters = new OrderDetailParameters();
            $Parameters->createFromJson($orderDetail->parameters);

//            $vserverPassword = Password::generateStrongPassword();
//            $solusPlan = $orderDetail->boundModel->solusPlan;
//            $vserverData = [
//                'nodegroup' => $node->solusNodeGroup->nodegroup_id,
//                'node'      => $node->name,
//                'hostname'  => $Parameters->hostname,
//                'username'  => $client->username,
//                'plan'      => $solusPlan->name,
//                'template'  => $Parameters->template,
//                'password'  => $vserverPassword,
//                'ips'       => 1,
//            ];
//            $vserver = Solus::createVserver($vserverData);
            $now = Carbon::now();
//            \Log::channel('solus')->info('VPS Created', ['vserver' => (array)$vserver]);

            $vpsStatus = VpsStatus::where('code', 'active')->first();

            $resource = new VpsResource();
            $resource->customer_id = $orderDetail->order->customer->id;
            $resource->product_id = $orderDetail->getBoundModel()->id;
            $resource->solus_node_id = null;
            $resource->vps_id = null;
            $resource->vps_status_id = $vpsStatus->id ?? null;
            $resource->expires_at = $now->addMonths($orderDetail->period_months)->toDateTimeString();
            $resource->save();

            $orderDetail->resource_model = 'App\Models\VpsResource';
            $orderDetail->resource_model_id = $resource->id;
            $orderDetail->save();

            self::bindAdditionalToMainResource($orderDetail, 'App\Models\VpsResource', $resource->id);

//            RouterOS::setServerPortSpeed($vserver->nodeid . '-' . $vserver->vserverid, $vserver->mainipaddress, $solusPlan->port_speed);

//            if ($clientIsNew) {
//                $clientPasswordUrl = OTS::getSecretLink($clientPassword);
//            }
//
//            $vserverPasswordUrl = OTS::getSecretLink($vserverPassword);

//            \Mail::to($mainContact->email)->send(new VpsAccessParameters([
//                'clientIsNew'        => $clientIsNew,
//                'clientUserName'     => $client->username,
//                'clientPasswordUrl'  => $clientPassword ?? null,
//                'vserverUserName'    => 'root',
//                'vserverPasswordUrl' => $vserverPassword ?? null,
//                'vserverIp'          => $vserver->mainipaddress,
//                'mainContact'        => $mainContact,
//            ]));

//            return $vserver;
            return true;
        } catch (\Exception $e) {
            \Log::channel('solus')->error('Solus error', ['exception' => $e, 'order' => (array)$orderDetail]);
            return false;
        }
    }

    /**
     * @param OrderDetail $orderDetail
     * @return bool|mixed
     */
    public static function createHostingAccount(OrderDetail $orderDetail)
    {
        date_default_timezone_set('Europe/Belgrade');
        if ($orderDetail->hasResource()) {
            return false;
        }

        try {
            $mainContact = $orderDetail->order->customer->contacts->where('contact_type_id', 1)->first();

            \Log::info('main contact', [$mainContact]);

            $Parameters = new OrderDetailParameters();
            $Parameters->createFromJson($orderDetail->parameters);

            $package = $orderDetail->getBoundModel()->whmPackage;
            $packageName = $package->name;
            $whmServer = WhmRepository::getPreferredServer($package);

            $password = Password::generateStrongPassword(9, false, 'luds');
            $username = WHM::generateUsername($whmServer, $mainContact->first_name, $mainContact->last_name);

            $hostingAccount = WHM::createAccount($whmServer, $Parameters->domain, $username, $password, $mainContact->email, $packageName);

            $now = Carbon::now();

            \Log::channel('whm')->info('Hosting Created:', ['hosting' => (array)$hostingAccount]);

            $hostingStatus = HostingStatus::where('code', 'active')->first();

            $resource = new HostingResource();
            $resource->customer_id = $orderDetail->order->customer->id;
            $resource->product_id = $orderDetail->getBoundModel()->id;
            $resource->whm_server_id = $whmServer->id;
            $resource->whm_user = $username;
            $resource->hosting_status_id = $hostingStatus->id ?? null;
            $resource->domain_name = $Parameters->domain ?? null;
            $resource->expires_at = $now->addMonths($orderDetail->period_months)->toDateTimeString();
            $resource->save();

            $orderDetail->resource_model = 'App\Models\HostingResource';
            $orderDetail->resource_model_id = $resource->id;
            $orderDetail->save();
            self::bindAdditionalToMainResource($orderDetail, 'App\Models\HostingResource', $resource->id);

//            $passwordUrl = OTS::getSecretLink($password);

            \Mail::to($mainContact->email)->send(new HostingAccessParameters([
                'username'       => $username,
                'passwordUrl'    => $password ?? null,
                'ip'             => $hostingAccount->options->ip,
                'domain'         => $Parameters->domain,
                'package'        => $orderDetail->description,
                'existingDomain' => $Parameters->existingDomain,
                'serverName'     => $whmServer->name,
                'mainContact'    => $mainContact,
            ]));

            return $hostingAccount;

        } catch (\Exception $e) {
            \Log::channel('whm')->error('WHM Error', ['exception' => $e, 'order' => (array)$orderDetail]);
            return false;
        }
    }

    public static function registerDomain(OrderDetail $detail)
    {
        date_default_timezone_set('Europe/Belgrade');
        $now = Carbon::now();
        if ($detail->hasResource()) {
            return false;
        }

        $result = Domains::registerDomain($detail);

        \Log::info('Domain registration', [$result]);

        $mainContact = $detail->order->customer->contacts->where('contact_type_id', 1)->first();
        $domainType = $detail->getBoundModel()->productLine->code;

        if (!empty($result) && $result !== false) {

            $status = DomainStatus::where('code', 'active')->first();

            $resource = new DomainResource();
            $resource->customer_id = $detail->order->customer->id;
            $resource->product_id = $detail->getBoundModel()->id;
            $resource->domain_vendor_id = $detail->getBoundModel()->domainExtension->registrationVendor->id ?? null;
            $resource->domain_name = $detail->description;
            $resource->domain_status_id = $status->id ?? null;
            $resource->expires_at = $now->addMonths($detail->period_months)->toDateTimeString();
            $resource->save();

            $detail->resource_model = 'App\Models\DomainResource';
            $detail->resource_model_id = $resource->id;
            $detail->save();
            self::bindAdditionalToMainResource($detail, 'App\Models\DomainResource', $resource->id);

            \Mail::to($mainContact->email)->send(new DomainRegistration([
                'domain'      => $detail->description,
                'domainType'  => $domainType,
                'mainContact' => $mainContact,
            ]));
            return true;
        }
        return false;
    }

    public static function createSsl(OrderDetail $detail)
    {
        date_default_timezone_set('Europe/Belgrade');
        if (!empty($detail->resource_id)) {
            return false;
        }

        return null;
    }

    protected static function bindAdditionalToMainResource(OrderDetail $orderDetail, $resourceModel, $resourceModelId)
    {
        try {
            $details = $orderDetail->order->orderDetails()->where('item_number', $orderDetail->item_number)->get();

            foreach ($details as $detail) {
                $detail->resource_model = $resourceModel;
                $detail->resource_model_id = $resourceModelId;
                $detail->save();
            }
            return true;
        } catch (\Exception $e) {
            \Log::error('Binding additional services to main resource error', ['exception' => $e]);
            return false;
        }
    }

    public static function renewOrderResource(Order $order)
    {
        return \App\Services\CoreAPI\Facades\ExternalResource::renewOrderExternalResource($order->id);
    }

}