<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 22.10.2018.
 * Time: 10:02
 */

namespace App\Services\Domains;


use App\Models\Country;
use App\Models\DomainExtension;
use App\Models\OrderDetail;
use App\OrderDetailParameters;
use App\Password;
use App\Services\GoDaddy\Facades\GoDaddyDomain;
use App\Services\GoDaddy\GoDaddyException;
use App\Services\GoDaddy\Resource\Contact;
use App\Services\GoDaddy\Resource\Domain;
use App\Services\RealTime\RealTime;
use App\Services\Resello\Facades\Resello;
use App\Services\Rnids\Facades\Rnids;

class Domains
{

    public function isAvailable(DomainExtension $domainExtension, $domainName)
    {
        return $this->callFunction($domainExtension, 'isAvailable', [$domainName]);
    }

    protected function callFunction($domainExtension, $method, $params)
    {
        return call_user_func_array($domainExtension->registrationVendor->service_model . '::' . $method, $params);
    }

    public function registerDomain(OrderDetail $orderDetail)
    {
        switch ($orderDetail->getBoundModel()->domainExtension->registrationVendor->code) {
            case 'rnids':
                return $this->registerRnidsDomain($orderDetail);
                break;
            case 'godaddy':
                return $this->registerGoDaddyDomain($orderDetail);
                break;
            case 'realtime':
                return $this->registerRealtimeDomain($orderDetail);
                break;

            default:
                return null;
        }
    }

    protected function registerRnidsDomain(OrderDetail $orderDetail)
    {
        if(!Rnids::isAvailable(trim($orderDetail->description))) {
            return false;
        }

        $interval = (int)($orderDetail->period_months / 12);

        $mainContact = $orderDetail->order->customer->contacts->where('contact_type_id', 1)->first();
        $Parameters = new OrderDetailParameters();
        $Parameters->createFromJson($orderDetail->parameters);

        $contactsData = [
            'registrant' => [
                'email'           => $mainContact->email,
                'telephone'       => $mainContact->phone,
                'first_name'      => $mainContact->first_name,
                'last_name'       => $mainContact->last_name,
                'organization'    => $mainContact->company_name,
                'address'         => $mainContact->address,
                'postcode'        => $mainContact->postal_code,
                'city'            => $mainContact->city,
                'country'         => $mainContact->country->code,
                'province'        => $mainContact->state,
                'company_id'      => $mainContact->company_registration_number,
                'is_legal_entity' => (bool)$mainContact->is_legal_entity,
                'vat'             => $mainContact->company_tax_number,
            ],
            'admin'      => [
                'email'           => $mainContact->email,
                'telephone'       => $mainContact->phone,
                'first_name'      => $mainContact->first_name,
                'last_name'       => $mainContact->last_name,
                'organization'    => $mainContact->company_name,
                'address'         => $mainContact->address,
                'postcode'        => $mainContact->postal_code,
                'city'            => $mainContact->city,
                'country'         => $mainContact->country->code,
                'province'        => $mainContact->state,
                'company_id'      => $mainContact->company_registration_number,
                'is_legal_entity' => (bool)$mainContact->is_legal_entity,
                'vat'             => $mainContact->company_tax_number,
            ],
            'tech'       => [
                'email'           => $mainContact->email,
                'telephone'       => $mainContact->phone,
                'first_name'      => $mainContact->first_name,
                'last_name'       => $mainContact->last_name,
                'organization'    => $mainContact->company_name,
                'address'         => $mainContact->address,
                'postcode'        => $mainContact->postal_code,
                'city'            => $mainContact->city,
                'country'         => $mainContact->country->code,
                'province'        => $mainContact->state,
                'company_id'      => $mainContact->company_registration_number,
                'is_legal_entity' => (bool)$mainContact->is_legal_entity,
                'vat'             => $mainContact->company_tax_number,
            ],
        ];

        $domainRegistered = Rnids::registerDomain($orderDetail->description, $interval, $contactsData, $Parameters->nameservers, $Parameters->whois);

        if($domainRegistered) {
            return Rnids::updateDomain($orderDetail->description, null, null, null, null, 'lock', 'secure');
        } else {
            return false;
        }
    }

    /**
     * @param OrderDetail $orderDetail
     * @return mixed
     */
    protected function registerGoDaddyDomain(OrderDetail $orderDetail)
    {
        if(!GoDaddyDomain::isAvailable(trim($orderDetail->description))) {
            return false;
        }

        try {
            $period = (int)($orderDetail->period_months / 12);
            $mainContact = $orderDetail->order->customer->contacts->where('contact_type_id', 1)->first();
            $Parameters = new OrderDetailParameters();
            $Parameters->createFromJson($orderDetail->parameters);

            $Domain = new Domain();
            $Domain->domain = trim($orderDetail->description);
            $Domain->nameServers = $Parameters->nameservers;
            $Domain->period = (int)$period;
            $Domain->privacy = (bool)$Parameters->whois;

            $Consent = GoDaddyDomain::getConsent($orderDetail->getBoundModel()->domainExtension->name, $Parameters->whois ?? false);

            /**
             * Registrant contact
             */
            $registrant = new Contact(Contact::REGISTRANT);
            $registrant->nameFirst = $mainContact->first_name;
            $registrant->nameLast = $mainContact->last_name;
            if ($mainContact->is_legal_entity) {
                $registrant->organization = $mainContact->company_name;
            }
            $registrant->email = $mainContact->email;
            $registrant->address1 = $mainContact->address;
            $registrant->city = $mainContact->city;
            $registrant->state = $mainContact->state;
            $registrant->postalCode = $mainContact->postal_code;
            $registrant->country = $mainContact->country->code;
            $registrant->phone = $mainContact->phone;
            $registrant->fax = null;

            /**
             * Admin contact
             */
            $admin = clone $registrant;
            $admin->setContactType(Contact::ADMIN);

            /**
             * Tech contact
             */
            $tech = clone $registrant;
            $tech->setContactType(Contact::TECH);

            /**
             * Billing contact
             */
            $billing = clone $tech;
            $billing->setContactType(Contact::BILLING);

            $contacts = [$registrant, $admin, $tech, $billing];

            return (bool)GoDaddyDomain::registerDomain($Domain, $Consent, $contacts);
        } catch (GoDaddyException $e) {
            \Log::channel('godaddy')->error('Domain Registration Error', ['exception' => $e]);
            return false;
        }
    }

    public function registerRealtimeDomain(OrderDetail $orderDetail)
    {
        $mainContact = $orderDetail->order->customer->contacts->where('contact_type_id', 1)->first();
        $Parameters = $orderDetail->parameters;

        $owner_country_id = isset($Parameters->owner) ? $Parameters->owner->country_id : $mainContact->country->id;
        $admin_country_id = isset($Parameters->admin) ? $Parameters->admin->country_id : $mainContact->country->id;
        $tech_country_id = isset($Parameters->tech) ? $Parameters->tech->country_id : $mainContact->country->id;
        $ownerCountry = Country::find($owner_country_id);
        $adminCountry = Country::find($admin_country_id);
        $techCountry = Country::find($tech_country_id);

        $contactsData = [
            'registrant' => [
                'organization'    => isset($Parameters->owner) ? $Parameters->owner->company_name : $mainContact->company_name,
                'name'    => (isset($Parameters->owner) ? $Parameters->owner->first_name : $mainContact->first_name) . ' ' . (isset($Parameters->owner) ? $Parameters->owner->last_name : $mainContact->last_name),
                'addressLine'    => [isset($Parameters->owner) ? $Parameters->owner->address : $mainContact->address],
                'postalCode'    => isset($Parameters->owner) ? $Parameters->owner->postal_code : $mainContact->postal_code,
                'city'    => isset($Parameters->owner) ? $Parameters->owner->city : $mainContact->city,
                'state'    => $mainContact->state,
                'country' => $ownerCountry->code,
                'email'    => isset($Parameters->owner) ? $Parameters->owner->email : $mainContact->email,
                'voice'    => isset($Parameters->owner) ? $ownerCountry->dial_code . '.' . $Parameters->owner->phone : $mainContact->phone,
                'fax' => null,
            ],
            'admin' => [
                'organization'    => isset($Parameters->admin) ? $Parameters->admin->company_name : $mainContact->company_name,
                'name'    => (isset($Parameters->admin) ? $Parameters->admin->first_name : $mainContact->first_name) . ' ' . (isset($Parameters->admin) ? $Parameters->admin->last_name : $mainContact->last_name),
                'addressLine'    => [isset($Parameters->admin) ? $Parameters->admin->address : $mainContact->address],
                'postalCode'    => isset($Parameters->admin) ? $Parameters->admin->postal_code : $mainContact->postal_code,
                'city'    => isset($Parameters->admin) ? $Parameters->admin->city : $mainContact->city,
                'state'    => $mainContact->state,
                'country' => $adminCountry->code,
                'email'    => isset($Parameters->admin) ? $Parameters->admin->email : $mainContact->email,
                'voice'    => isset($Parameters->admin) ? $adminCountry->dial_code . '.' . $Parameters->admin->phone : $mainContact->phone,
                'fax' => null,
            ],
            'tech' => [
                'organization'    => isset($Parameters->tech) ? $Parameters->tech->company_name : $mainContact->company_name,
                'name'    => (isset($Parameters->tech) ? $Parameters->tech->first_name : $mainContact->first_name) . ' ' . (isset($Parameters->tech) ? $Parameters->tech->last_name : $mainContact->last_name),
                'addressLine'    => [isset($Parameters->tech) ? $Parameters->tech->address : $mainContact->address],
                'postalCode'    => isset($Parameters->tech) ? $Parameters->tech->postal_code : $mainContact->postal_code,
                'city'    => isset($Parameters->tech) ? $Parameters->tech->city : $mainContact->city,
                'state'    => $mainContact->state,
                'country' => $techCountry->code,
                'email'    => isset($Parameters->tech) ? $Parameters->tech->email : $mainContact->email,
                'voice'    => isset($Parameters->tech) ? $techCountry->dial_code . '.' . $Parameters->tech->phone : $mainContact->phone,
                'fax' => null,
            ],
        ];

        return \App\Services\RealTime\Facades\RealTime::registerDomain($orderDetail->description, $contactsData, $orderDetail->period_months, $Parameters->nameservers, $Parameters->whois);
    }

}