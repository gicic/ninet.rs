<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.9.2018.
 * Time: 10:22
 */

namespace App\Services\GoDaddy;


use App\Services\GoDaddy\Resource\Consent;
use App\Services\GoDaddy\Resource\Contact;
use App\Services\GoDaddy\Resource\Domain;
use Illuminate\Support\Facades\Request;

class GoDaddyDomain extends GoDaddyClient
{

    /**
     * GoDaddyDomain constructor.
     * @param string $baseUrl
     * @param string $apiKey
     * @param string $shopperID
     * @throws GoDaddyException
     */
    public function __construct($baseUrl, $apiKey, $shopperID)
    {
        parent::__construct($baseUrl, $apiKey, $shopperID);
    }

    /**
     * Returns list of domains associated with the Shopper
     *
     * @param array $data
     *
     * Possible data parameters:
     * - statuses (array|string):     Only include results with status value in the specified set
     * - statusGroups (array|string): Only include results with status value in any of the specified groups
     * - limit (long):                Maximum number of domains to return
     * - marker (string):             Marker Domain to use as the offset in results
     * - includes (array|string):     Optional details to be included in the response
     * - modifiedDate (string):       Only include results that have been modified since the specified date
     *
     * @return mixed|string
     * @throws GoDaddyException
     */
    public function getDomains(array $data = [])
    {
        $url = '/domains';
        return $this->makeRequest('get', $url, $data);
    }

    /**
     * Returns data for provided domain associated with the Shopper
     *
     * @param string $domain
     * @return mixed
     * @throws GoDaddyException
     */
    public function getDomain($domain)
    {
        $url = '/domains/' . $domain;
        return $this->makeRequest('get', $url, []);
    }

    /**
     * Updates domain details (lock, nameservers, automatic renewal)
     *
     * @param $domain
     * @param bool $locked
     * @param array $nameservers
     * @param bool $renewAuto
     * @return mixed
     * @throws GoDaddyException
     */
    public function updateDomain($domain, $locked = null, $nameservers = [], $renewAuto = null)
    {
        $url = '/domains/' . $domain;
        $body = [];
        if(isset($locked)) {
            $body['locked'] = $locked;
        }
        if(isset($nameservers) && count($nameservers)) {
            $body['nameServers'] = $nameservers;
        }
        if(isset($renewAuto)) {
            $body['renewAuto'] = (bool)$renewAuto;
        }

        return $this->makeRequest('patch', $url, [], $body);
    }

    /**
     * Checks the availability of domain
     *
     * @param string $domain
     * @param string $checkType : Can be FAST or FULL
     * @return mixed
     * @throws GoDaddyException
     */
    public function isAvailable($domain, $checkType = 'FAST')
    {
        if(!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-_]+\.[a-zA-Z]{2,11}?$/', $domain)) {
            return false;
        }
        $url = '/domains/available';
        $data = [
            'domain' => $domain,
            'checkType' => $checkType,
        ];
        return boolval($this->makeRequest('get', $url, $data)->available);
    }

    /**
     * Bulk availability check
     *
     * @param array $domains
     * @param string $checkType
     * @return mixed
     * @throws GoDaddyException
     */
    public function isAvailableBulk($domains = [], $checkType = 'FAST')
    {
        $url = '/domains/available';
        $data['checkType'] = $checkType;
        $body['domains'] = $domains;

        return $this->makeRequest('post', $url, $data, $body);
    }

    /**
     * Returns agreement codes and terms of usage
     * Agreement codes are used for domain registration and privacy purchase
     *
     * @param array $tlds : An array of top level domain names (com, biz, net...)
     * @param bool $privacy
     * @param bool $forTransfer
     * @return mixed
     * @throws GoDaddyException
     */
    public function getAgreements(array $tlds, $privacy = false, $forTransfer = false)
    {
        $url = '/domains/agreements';

        $data = [
            'tlds' => $tlds,
            'privacy' => $privacy,
            'forTransfer' => $forTransfer,
        ];

        $additionalHeaders['X-Market-Id'] = 'en-US';

        $response = $this->makeRequest('get', $url, $data, null, $additionalHeaders);

        \Log::channel('godaddy')->info('Domain Agreements', ['response' => (array)$response]);

        return $response;
    }

    /**
     * Registers a new domain
     *
     * @param \App\Services\GoDaddy\Resource\Domain $domain
     * @param Consent $consent
     * @param array $contacts : An array of App\Services\GoDaddy\Resource\Contact instances
     * @return mixed
     * @throws GoDaddyException
     */
    public function registerDomain(Domain $domain, Consent $consent, array $contacts = [])
    {
        $url = '/domains/purchase';

        $body = [
            'domain' => $domain->domain,
            'consent' => $consent->toArray(),
            'period' => (int)$domain->period,
            'nameServers' => $domain->nameServers,
            'renewAuto' => (bool)$domain->renewAuto,
            'privacy' => (bool)$domain->privacy,
        ];

        foreach($contacts as $contact) {
            if( ! $contact instanceof Contact) {
                throw new GoDaddyException('Contact must be an instance of App\Services\GoDaddyResellerREST\Resource\Contact');
            }

            $body[$contact->getContactType()] = $contact->toArray();
        }

        $this->validateRegistrationSchema($body);

        $response = $this->makeRequest('post', $url, [], $body);

        \Log::channel('godaddy')->info('Domain Registration', ['response' => (array)$response]);

        return $response;
    }

    /**
     * Validates the body of registration request
     *
     * @param array $body
     * @return mixed
     * @throws GoDaddyException
     */
    public function validateRegistrationSchema(array $body)
    {
        $url = '/domains/purchase/validate';

        $response = $this->makeRequest('post', $url, [], $body);

        \Log::channel('godaddy')->info('Domain Request Validation', ['response' => (array)$response]);

        return $response;
    }

    /**
     * Renews an existing domain
     *
     * @param string $domain
     * @param int $period
     * @return mixed
     * @throws GoDaddyException
     */
    public function renewDomain($domain, $period = 1)
    {
        $url = '/domains/' . $domain . '/renew';

        $body = [
            'period' => $period,
        ];
        $response = $this->makeRequest('post', $url, [], $body);

        \Log::channel('godaddy')->info('Domain Renewal', ['response' => (array)$response]);

        return $response;
    }

    /**
     * Updates the contacts of an existing domain
     *
     * @param string $domain
     * @param array $contacts : An array of App\Services\GoDaddyResellerREST\Resource\Contact instances
     * @return mixed
     * @throws GoDaddyException
     */
    public function updateContacts($domain, array $contacts)
    {
        $url = '/domains/' . $domain . '/contacts';

        $body = [];
        foreach($contacts as $contact) {
            if( ! $contact instanceof Contact) {
                throw new GoDaddyException('Contact must be an instance of App\Services\GoDaddyResellerREST\Resource\Contact');
            }

            $body[$contact->getContactType()] = $contact->toArray();
        }
        return $this->makeRequest('patch', $url, [], $body);
    }

    /**
     * Orders the privacy for an existing domain
     *
     * @param string $domain
     * @param Consent $consent
     * @return mixed
     * @throws GoDaddyException
     */
    public function orderPrivacy($domain, Consent $consent)
    {
        $url = '/domains/' . $domain . '/privacy/purchase';

        $body = [
            'consent' => $consent->toArray(),
        ];

        $response = $this->makeRequest('post', $url, [], $body);

        \Log::channel('godaddy')->info('Domain Privacy Order', ['response' => (array)$response]);

        return $response;
    }

    /**
     * Cancels privacy protection for an existing domain
     *
     * @param string $domain
     * @return mixed
     * @throws GoDaddyException
     */
    public function cancelPrivacy($domain)
    {
        $url = '/domains/' . $domain . '/privacy';
        $response = $this->makeRequest('delete', $url);

        \Log::channel('godaddy')->info('Domain Privacy Cancellation', ['response' => (array)$response]);

        return $response;
    }

    /**
     * Transfer domain to GoDaddy registrar
     *
     * @param string $domain
     * @param string $authCode
     * @param Consent $consent
     * @param bool $privacy
     * @param int $period
     * @return mixed
     * @throws GoDaddyException
     */
    public function transferIn($domain, $authCode, Consent $consent, $privacy = false, $period = null)
    {
        $url = '/domains/' . $domain . '/transfer';
        $body = [
            'consent' => $consent->toArray(),
            'authCode' => $authCode,
            'privacy' => $privacy,
        ];
        if(!empty($period)) {
            $body['period'] = $period;
        }
        $response = $this->makeRequest('post', $url, [], $body);

        \Log::channel('godaddy')->info('Domain Transfer In', ['response' => (array)$response]);

        return $response;
    }

    /**
     * @param string $extension
     * @param bool $privacy
     * @param bool $transfer
     * @return Consent
     * @throws GoDaddyException
     */
    public function getConsent($extension, $privacy = false, $transfer = false)
    {
        $agreements = $this->getAgreements([$extension], $privacy, $transfer);
        $consent = new Consent();
        foreach ($agreements as $agreement) {
            $consent->agreementKeys[] = $agreement->agreementKey;
        }
        $consent->agreedBy = Request::ip();
        $consent->agreedAt = gmdate("Y-m-d\TH:i:s\Z");

        return $consent;
    }

}