<?php


namespace App\Services\RealTime;


use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RealTime
{
    public $conn_handle;
    private $errors = [];

    /**
     * @return array
     */
    private static function getRealtimeInstance()
    {
        $api_url = config('services.realtime.url');
        $api_key = config('services.realtime.api_key');
        $api_customer = config('services.realtime.customer');

        return ['api_url' => $api_url, 'api_key' => $api_key, 'api_customer' => $api_customer];
    }

    /**
     * @param      $method
     * @param      $uri
     * @param null $json
     *
     * @return mixed
     */
    private function do_request($method, $uri, $json = NULL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::getRealtimeInstance()['api_url'] . $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: ApiKey ' . self::getRealtimeInstance()['api_key'],
            'Content-Length: ' . strlen($json),
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $response = curl_exec($ch);

        $result = json_decode($response);
        return $result;
    }

    /**
     * Domain availability check
     *
     * @param $domainName
     * @return mixed
     */
    public function isAvailable($domainName)
    {
        try {
            $check = $this->do_request("GET", 'domains/' . $domainName . '/check');
            return $check->available;
        } catch (RealTimeException $exception) {
            $this->errors[] = $exception->getMessage();
            $this->logError('Error checking domain availability', [
                'domain' => $domainName,
                'exception' => (array)$exception
            ]);
        }
    }

    /**
     * Register domain
     *
     * @param       $domainName
     * @param       $contactData
     * @param int   $period
     * @param array $nameservers
     * @param false $whois
     *
     * @return false|mixed
     */
    public function registerDomain($domainName, $contactData, $period = 12, $nameservers = [], $whois = false)
    {
        $available = $this->isAvailable($domainName);
        if (!$available && $available !== null) {
            $this->errors[] = 'Domen nije dostupan';
            \Log::channel('realtime')->info('Domain Registration', $this->errors);
            return false;
        }
        if($available === null) {
            return false;
        }

        $registrantHandle = Str::random(20);
        $adminHandle = Str::random(20);
        $techHandle = Str::random(20);

        try {
            $this->createContact($contactData['registrant'], $registrantHandle);
            $this->createContact($contactData['admin'], $adminHandle);
            $this->createContact($contactData['tech'], $techHandle);

            $body = [
                'customer' => 'domains@ninet.rs',
                'period' => $period,
                'registrant' => $registrantHandle,
                'privacyProtect' => $whois,
                'contacts' => [
                    ['handle' => $adminHandle, 'role' => 'ADMIN'],
                    ['handle' => $techHandle, 'role' => 'BILLING'],
                    ['handle' => $techHandle, 'role' => 'TECH'],
                ],
                'ns' => $nameservers,
            ];

            $response = $this->do_request("POST", "domains/" . $domainName, json_encode($body));

            \Log::channel('realtime')->info('Domain Registration', ['response' => (array)$response]);

            return $response;

        } catch (RealTimeException $e) {
            $this->errors[] = 'Greška prilikom registracije domena: ' . $e->getMessage();
            $this->logError('Error registering domain', [
                'domain' => $domainName,
                'interval' => $period,
                'customer_data' => (array)$contactData,
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * Renew domain
     *
     * @param $domainName
     * @param $period
     * @return mixed
     */
    public function renewDomain($domainName, $period)
    {
        if ($period > 0 && is_int($period)) {
            $body = [
                'period' => $period,
            ];
            $response = $this->do_request("POST", "domains/" . $domainName . '/renew', json_encode($body));
        }
        if (isset($response->expiryDate)){
            \Log::channel('realtime')->info('Domain renew', ['response' => (array)$response]);

            return [
                'response'        => true,
                'expiration_date' => $response->expiryDate,
            ];
        }
        else{
            $this->logError('Error renewing domain', [
                'domain' => $domainName,
                'interval' => $period,
                'exception' => (array)$response
            ]);
            return false;
        }
    }

    /**
     * Transfer domain
     *
     * @param $domainName
     * @param $customer
     * @param $authCode
     * @param bool $privacy
     * @param null $period
     * @return mixed
     */
    public function transferIn($domainName, $customer, $authCode, $privacy = false, $period = null)
    {
        $mainContact = $customer->getMainContact();

        $fullName = $mainContact->first_name . ' ' . $mainContact->last_name;

        $name = str_replace(" ", '.', $fullName);
        $handle =  strtolower($name);

        $body = [
            'customer' => 'domains@ninet.rs',
            'registrant' => $handle,
            'authcode' => $authCode,
            'period' => $period,
            'privacyProtect' => $privacy,
            'contacts' => [
                ['handle' => $handle, 'role' => 'ADMIN'],
                ['handle' => $handle, 'role' => 'BILLING'],
                ['handle' => $handle, 'role' => 'TECH'],
            ],
        ];

        $response = $this->do_request("POST", "domains/" . $domainName . '/transfer', json_encode($body));

        \Log::channel('realtime')->info('Domain renew', ['response' => (array)$response]);

        return $response;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $message
     * @param array $data
     */
    private function logError($message, $data = [])
    {
        \Log::channel('realtime')->error($message, $data);
    }

    /**
     * @param $message
     * @param array $data
     */
    private function logResponse($message, $data = [])
    {
        \Log::channel('realtime')->info($message, $data);
    }


    /**
     * Create contact
     *
     * @param $data
     * @return bool
     */
    public function createContact($contactData, $handle)
    {
        try {
            $body = [
                $contactData
            ];

            $createContact = $this->do_request("POST", "customers/" . self::getRealtimeInstance()['api_customer'] . "/contacts/" . $handle, json_encode($body[0]));

            return $createContact;

        } catch (RealTimeException $e) {
            $this->errors[] = 'Greška prilikom kreiranja contact-a na Realtime: ' . $e->getMessage();
            $this->logError('Error creating customer', [
                'customer_data' => (array)$contactData,
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * Domain info
     *
     * @param $domain_name
     *
     * @return Collection
     */
    public function info($domain_name) : Collection
    {
        $infoDomainResponse = $this->do_request("GET", "domains/" . $domain_name);

        $nameservers = [];

        foreach ($infoDomainResponse->ns as $nameserver) {

            $nameservers[] = [
                'host' => $nameserver,
                'ip_addresses' => null
            ];
        }

        foreach ($infoDomainResponse->contacts as $contact) {
            $contactResponse = $this->getContact($infoDomainResponse->customer, $contact->handle);

            $contacts[$contact->role] = [
                'full_name'       => $contactResponse->name,
                'first_name'      => null,
                'last_name'       => null,
                'company_name'    => $contactResponse->organization,
                'address'         => $contactResponse->addressLine[0],
                'city'            => $contactResponse->city,
                'zip'             => $contactResponse->postalCode,
                'province'        => null,
                'country'         => Country::where('code', $contactResponse->country)->first(),
                'phone'           => $contactResponse->voice,
                'fax'             => isset($contactResponse->fax) ? $contactResponse->fax : null,
                'mail'            => $contactResponse->email,
                'is_legal_entity' => $contactResponse->organization !== '' ? true : false,
                'vat_number'      => isset($contactResponse->vat) ? $contactResponse->vat : null
            ];
        }

        $infoRegistrantResponse = $this->getContact($infoDomainResponse->customer, $infoDomainResponse->registrant);

        return \Illuminate\Support\Collection::make([
            'success'              => true,
            'domain_name'          => $infoDomainResponse->domainName,
            'status'               => $infoDomainResponse->status[0],
            'created_at'           => str_replace('T', ' ', $infoDomainResponse->createdDate),
            'updated_at'           => str_replace('T', ' ', $infoDomainResponse->updatedDate),
            'expires_at'           => str_replace('T', ' ', $infoDomainResponse->expiryDate),
            'is_whois_privacy_on'  => $infoDomainResponse->privacyProtect,
            'is_locked'            => null,
            'is_auto_renew_on'     => $infoDomainResponse->autoRenew,
            'operation_mode'       => null,
            'is_notify_admin_on'   => null,
            'remark'               => null,
            'registrant'  => [
                'full_name'       => $infoRegistrantResponse->name,
                'first_name'      => null,
                'last_name'       => null,
                'company_name'    => $infoRegistrantResponse->organization,
                'address'         => $infoRegistrantResponse->addressLine[0],
                'city'            => $infoRegistrantResponse->city,
                'zip'             => $infoRegistrantResponse->postalCode,
                'province'        => null,
                'country'         => Country::where('code', $infoRegistrantResponse->country)->first(),
                'phone'           => $infoRegistrantResponse->voice,
                'fax'             => isset($infoRegistrantResponse->fax) ? $infoRegistrantResponse->fax : null,
                'mail'            => $infoRegistrantResponse->email,
                'is_legal_entity' => $infoRegistrantResponse->organization !== '' ? true : false,
                'vat_number'      => isset($infoRegistrantResponse->vat) ? $infoRegistrantResponse->vat : null],
            'admin' => $contacts['ADMIN'],
            'tech' => $contacts['TECH'],
            'billing'  => [
                'available'       => false,
                'full_name'       => null,
                'first_name'      => null,
                'last_name'       => null,
                'company_name'    => null,
                'address'         => null,
                'city'            => null,
                'zip'             => null,
                'province'        => null,
                'country'         => null,
                'phone'           => null,
                'fax'             => null,
                'mail'            => null,
                'is_legal_entity' => null,
                'vat_number'      => null],
            'nameservers' => $nameservers,
        ]);
    }

    /**
     * Get contact
     *
     * @param $customer
     * @param $handle
     *
     * @return mixed
     */
    public function getContact($customer, $handle)
    {
        $contact = $this->do_request("GET", "customers/" . $customer . '/contacts/' . $handle);

        return $contact;
    }

    /**
     * Update domain
     *
     * @param      $domain
     * @param null $registrant
     * @param null $nameservers
     *
     * @return mixed
     */
    public function updateDomain($domain, $registrant = null, $nameservers = null)
    {
        $body = [
            'ns' => $nameservers,
        ];

        $response = $this->do_request("POST", "domains/" . $domain . '/update', json_encode($body));

        \Log::channel('realtime')->info('Domain Registration', ['response' => (array)$response]);

        return $response;
    }

    /**
     * Get nameservers
     *
     * @param $domain
     *
     * @return array[]
     */
    public function getNameservers($domain)
    {
        $infoDomainResponse = $this->do_request("GET", "domains/" . $domain);

        $nameservers = [];

        foreach ($infoDomainResponse->ns as $nameserver) {
            $nameservers[] =
                $nameserver;
        }

        return [
            'nameservers' => $nameservers,
        ];
    }

    /**
     * Update nameservers
     *
     * @param $domain
     * @param $nameservers
     *
     * @return array
     */
    public function setNameservers($domain, $nameservers)
    {
        $result = $this->updateDomain($domain, null, $nameservers);

        return [
            'success' => $result,
        ];
    }
}