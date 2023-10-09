<?php

namespace App\Services\Resello;


class Resello
{

    private $hc_api_client;
    private $errors = [];

    /**
     * Resello constructor.
     * @param $apiUrl
     * @param $apiKey
     */
    public function __construct($apiUrl, $apiKey)
    {
        try {
            $this->hc_api_client = new HostControlAPIClient($apiUrl, $apiKey);
            return true;
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom povezivanja sa Resello servisom.';
            $this->logError('Error connecting to API', [
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * @return array
     * @throws HostControlAPIClientError
     */
    public function getAllDomains()
    {
        $response = $this->hc_api_client->domain->all();

        $domains = [];
        foreach ($response as $domain) {
            $domains[] = [
                'domain' => $domain->name,
            ];
        }

        return $domains;
    }

    /**
     * @param $domain
     * @param int $interval_months
     * @param array $customer_data
     * @return bool
     */
    public function registerDomain($domain, $interval_months = 12, $customer_data = [])
    {
        $available = $this->isAvailable($domain);
        if (!$available && $available !== null) {
            $this->errors[] = 'Domen nije dostupan';
            return false;
        }

        if($available === null) {
            return false;
        }

        $customer = $this->getCustomer($customer_data['mail']);
        if ($customer === false) {
            if(!$customer = $this->createCustomer($customer_data)) {
                return false;
            }
        }

        try {
            $this->hc_api_client->domain->register($customer->id, $domain, 12);
            $renew_count = $interval_months / 12 - 1;
            if ($renew_count > 0 && is_int($renew_count)) {
                for ($i = 0; $i < $renew_count; $i++) {
                    $this->hc_api_client->domain->renew($domain, 12);
                }
            }
            return $this->infoDomain($domain);
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom registracije domena: ' . $e->getMessage();
            $this->logError('Error registering domain', [
                'domain' => $domain,
                'interval_months' => $interval_months,
                'customer_data' => (array)$customer_data,
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * @param $domain
     * @param int $interval
     * @param bool $whois
     * @return bool
     */
    public function renewDomain($domain, $interval = 1, $whois = false)
    {
        try {
            if ($interval > 0 && is_int($interval)) {
                for ($i = 0; $i < $interval; $i++) {
                    $this->hc_api_client->domain->renew($domain, 12);
                }
            }
            return true;
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom obnove domena: ' . $e->getMessage();
            $this->logError('Error renewing domain', [
                'domain' => $domain,
                'interval_months' => $interval * 12,
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function createCustomer($data)
    {

        if ($this->customerExists($data['mail'])) {
            $this->errors[] = 'Customer sa ovom e-mail adresom već postoji.';
            return false;
        }

        try {

            $country = $data['country'];

            $result = $this->hc_api_client->customer->create([
                'organisation'    => $data['organisation'], // Name of the organisation.
                'name'            => $data['name'], // Name of the customer. (required)
                'gender'          => $data['gender'], // Gender of the customer.
                'address'         => $data['address'], // Address of the customer. (required)
                'zipcode'         => $data['zipcode'], // Zipcode of the customer. (required)
                'city'            => $data['city'], // City of the customer. (required)
                'country'         => $country, // Short code of the country of the customer. (required)
                'state'           => $data['state'], // State of the customer. If the country has states, this is parameter becomes required to fill in.
                'email'           => $data['email'], // Email address of the customer. The email address has to be unique. (required, unique)
                'voice'           => $data['voice'], // Telephone number of the customer. (required)
                'fax'             => $data['fax'], // Fax number of the customer.
                'vat_number'      => $data['vat_number'], // VAT number of the customer.
                'registration_ip' => $data['registration_ip'], // The IP address of the customer. (required)
                'password'        => $data['password'], // Password of the customer. (required)
            ]);

            return $result ?? false;

        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom kreiranja customer-a na Resello: ' . $e->getMessage();
            $this->logError('Error creating customer', [
                'customer_data' => (array)$data,
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * @param $customer_email
     * @return bool
     */
    public function customerExists($customer_email)
    {
        return is_array($this->getCustomer($customer_email));
    }

    /**
     * @param $customer_email
     * @return bool
     */
    public function getCustomer($customer_email)
    {
        try {
            $result = $this->hc_api_client->customer->lookup($customer_email);
            return $result[0] ?? false;
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom provere customer-a';
            $this->logError('Error getting customer data', [
                'customer_email' => $customer_email,
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * Domain availability
     *
     * @param $domain
     * @return bool
     */
    public function isAvailable($domain)
    {
        if(!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-_]+\.[a-zA-Z]{2,11}?$/', $domain)) {
            return false;
        }
        try {
            return $this->hc_api_client->domain->check($domain) !== 'taken';
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = $e->getMessage();
            $this->logError('Error checking domain availability', [
                'domain' => $domain,
                'exception' => (array)$e
            ]);
            return null;
        }
    }


    /**
     * @param $domain
     * @return mixed|null
     */
    public function infoDomain($domain)
    {
        try {
            return $this->hc_api_client->domain->get($domain);
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom preuzimanja podataka o domenu: ' . $e->getMessage();
            $this->logError('Error getting domain info', [
                'domain' => $domain,
                'exception' => (array)$e
            ]);
            return null;
        }
    }

    /**
     * @param $domain
     * @param $nameservers
     * @return bool
     */
    public function setNameservers($domain, $nameservers)
    {

        $domain_info = $this->infoDomain($domain);
        if(!isset($domain_info) || !$domain_info) {
            return false;
        }

        $nameservers_array = [];
        foreach ($nameservers as $nameserver) {
            $nameservers_array[] = ['hostname' => $nameserver];
        }

        try {
            $this->hc_api_client->domain->setNameservers($domain, $nameservers_array);
            return true;
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom upisa DNS zapisa.';
            $this->logError('Error setting name servers', [
                'domain' => $domain,
                'nameservers' => (array)$nameservers_array,
                'exception' => (array)$e
            ]);
            return false;
        }
    }

    /**
     * @param $domain
     * @return mixed|null
     */
    public function getNameservers($domain)
    {
        try {
            $nameservers = $this->hc_api_client->domain->getNameservers($domain);
            $nameservers_array = [];
            foreach($nameservers as $nameserver) {
                if(isset($nameserver->hostname) && $nameserver->hostname !== '' ) {
                    $nameservers_array[]['hostname'] = $nameserver->hostname;
                }
            }
            return $nameservers_array;
        } catch (HostControlAPIClientError $e) {
            $this->errors[] = 'Greška prilikom preuzimanja DNS zapisa domena: ' . $e->getMessage();
            $this->logError('Error getting name servers', [
                'domain' => $domain,
                'exception' => (array)$e
            ]);
            return null;
        }
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
        \Log::channel('resello')->error($message, $data);
    }

    /**
     * @param $message
     * @param array $data
     */
    private function logResponse($message, $data = [])
    {
        \Log::channel('resello')->info($message, $data);
    }

}