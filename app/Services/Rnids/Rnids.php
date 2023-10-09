<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 7.2.2018.
 * Time: 15:01
 */

namespace App\Services\Rnids;

use EppRegistrar\EPP\eppCheckRequest;
use EppRegistrar\EPP\eppCheckResponse;
use EppRegistrar\EPP\eppContact;
use EppRegistrar\EPP\eppContactHandle;
use EppRegistrar\EPP\eppContactPostalInfo;
use EppRegistrar\EPP\eppCreateHostRequest;
use EppRegistrar\EPP\eppCreateResponse;
use EppRegistrar\EPP\eppDomain;
use EppRegistrar\EPP\eppException;
use EppRegistrar\EPP\eppHelloRequest;
use EppRegistrar\EPP\eppHost;
use EppRegistrar\EPP\eppInfoContactRequest;
use EppRegistrar\EPP\eppInfoDomainRequest;
use EppRegistrar\EPP\eppInfoDomainResponse;
use EppRegistrar\EPP\eppInfoHostRequest;
use EppRegistrar\EPP\eppInfoHostResponse;
use EppRegistrar\EPP\eppLoginRequest;
use EppRegistrar\EPP\eppLoginResponse;
use EppRegistrar\EPP\eppLogoutRequest;
use EppRegistrar\EPP\eppLogoutResponse;
use EppRegistrar\EPP\eppRenewRequest;
use EppRegistrar\EPP\eppRenewResponse;
use EppRegistrar\EPP\eppResponse;
use EppRegistrar\EPP\eppTransferRequest;
use EppRegistrar\EPP\eppTransferResponse;
use EppRegistrar\EPP\eppUpdateResponse;
use EppRegistrar\EPP\rnidsEppConnection;
use EppRegistrar\EPP\rnidsEppCreateContactRequest;
use EppRegistrar\EPP\rnidsEppCreateDomainRequest;
use EppRegistrar\EPP\rnidsEppInfoContactResponse;
use EppRegistrar\EPP\rnidsEppInfoDomainResponse;
use EppRegistrar\EPP\rnidsEppUpdateDomainRequest;

require_once __DIR__ . '/lib/autoloader.php';

class Rnids
{

    private $language = 'en';
    private $errors = [];

    public function __construct()
    {
        try {
            $this->conn = new rnidsEppConnection();
            $this->conn->connect();
            $this->greet();
        } catch (eppException $e) {
            $this->logError('Error connecting to API', [
                'exception' => (array)$e,
            ]);
        }
    }

    public function greet()
    {
        // Set $showgreeting to true to see the server greeting
        $showgreeting = false;
        try {
            $greeting = new eppHelloRequest();
            if ((($response = $this->conn->writeandread($greeting)) instanceof eppResponse) && ($response->Success())) {
                if ($showgreeting) {
                    echo "Welcome to " . $response->getServerName() . ", date and time: " . $response->getServerDate() . "\n";
                    $languages = $response->getLanguages();
                    if (is_array($languages)) {
                        echo "Supported languages:\n";
                        foreach ($languages as $language) {
                            echo "-" . $language . "\n";
                        }
                    }
                    $versions = $response->getVersions();
                    if (is_array($versions)) {
                        echo "Supported versions:\n";
                        foreach ($versions as $version) {
                            echo "-" . $version . "\n";
                        }
                    }
                    $services = $response->getServices();
                    if (is_array($services)) {
                        echo "Supported services:\n";
                        foreach ($services as $service) {
                            echo "-" . $service . "\n";
                        }
                    }
                    $extensions = $response->getExtensions();
                    if (is_array($extensions)) {
                        echo "Supported extensions:\n";
                        foreach ($extensions as $extension) {
                            echo "-" . $extension . "\n";
                        }
                    }
                }
                return true;
            }
        } catch (eppException $e) {
            $this->logError('Error greeting', [
                'exception' => (array)$e,
            ]);
            return false;
        }
        return false;
    }

    /**
     * @param $message
     * @param array $data
     */
    private function logError($message, $data = [])
    {
        \Log::channel('rnids')->error('RNIDS Error: ' . $message, ['error' => (array)$data]);
    }

    /**
     * @return bool
     */
    public function login()
    {
        try {
            $login = new eppLoginRequest();
            if ((($response = $this->conn->writeandread($login)) instanceof eppLoginResponse) && ($response->Success())) {
                return true;
            }
        } catch (eppException $e) {
            $this->logError('Error loging in', [
                'exception' => (array)$e,
            ]);
        }
        return false;
    }

    /**
     * @return bool
     */
    public function logout()
    {
        try {
            $logout = new eppLogoutRequest();
            if ((($response = $this->conn->writeandread($logout)) instanceof eppLogoutResponse) && ($response->Success())) {
                return true;
            }
        } catch (eppException $e) {
            $this->logError('Error loging out', [
                'exception' => (array)$e,
            ]);
        }
        return false;
    }

    /**
     * @param $domain
     * @param int $interval
     * @param array $contacts_data
     * @param array $nameservers
     * @param bool $whois
     * @param bool $ip_addresses
     * @return array|bool|null
     */
    public function registerDomain($domain, $interval = 1, $contacts_data = [], $nameservers = [], $whois = false)
    {
        try {

            $this->logRequest('Registration', compact(['domain', 'interval', 'contacts_data', 'namservers', 'whois']));

            $nameservers_validated = array();
            $nameserver_counter = 0;
            foreach ($nameservers as $nameserver) {
                if (!$this->checkHost($nameserver)) {
                    $this->createHost($nameserver, $this->nameserverIsSubdomain($nameserver, $domain) ? gethostbyname($nameserver) : null);
                    array_push($nameservers_validated, $nameserver);
                }
                $nameserver_counter++;
            }

            $registrant = $this->createContact([
                'email'            => $contacts_data['registrant']['email'],
                'telephone'        => $contacts_data['registrant']['telephone'],
                'name'             => $contacts_data['registrant']['first_name'] . ' ' . $contacts_data['registrant']['last_name'],
                'organization'     => $contacts_data['registrant']['organization'],
                'address'          => $contacts_data['registrant']['address'],
                'postcode'         => $contacts_data['registrant']['postcode'],
                'city'             => $contacts_data['registrant']['city'],
                'country'          => $contacts_data['registrant']['country'],
                'province'         => $contacts_data['registrant']['province'],
                'ident'            => $contacts_data['registrant']['company_id'],
                'identDescription' => null,
                'identExpiry'      => null,
                'isLegalEntity'    => $contacts_data['registrant']['is_legal_entity'],
                'identKind'        => null,
                'vatNo'            => $contacts_data['registrant']['vat'],
                'fax'              => null,
            ]);

            $admin = $this->createContact([
                'email'            => $contacts_data['admin']['email'],
                'telephone'        => $contacts_data['admin']['telephone'],
                'name'             => $contacts_data['admin']['first_name'] . ' ' . $contacts_data['admin']['last_name'],
                'organization'     => $contacts_data['admin']['organization'],
                'address'          => $contacts_data['admin']['address'],
                'postcode'         => $contacts_data['admin']['postcode'],
                'city'             => $contacts_data['admin']['city'],
                'country'          => $contacts_data['admin']['country'],
                'province'         => $contacts_data['admin']['province'],
                'ident'            => $contacts_data['admin']['company_id'],
                'identDescription' => null,
                'identExpiry'      => null,
                'isLegalEntity'    => $contacts_data['admin']['is_legal_entity'],
                'identKind'        => null,
                'vatNo'            => $contacts_data['admin']['vat'],
                'fax'              => null,
            ]);

            $tech = $this->createContact([
                'email'            => $contacts_data['tech']['email'],
                'telephone'        => $contacts_data['tech']['telephone'],
                'name'             => $contacts_data['tech']['first_name'] . ' ' . $contacts_data['tech']['last_name'],
                'organization'     => $contacts_data['tech']['organization'],
                'address'          => $contacts_data['tech']['address'],
                'postcode'         => $contacts_data['tech']['postcode'],
                'city'             => $contacts_data['tech']['city'],
                'country'          => $contacts_data['tech']['country'],
                'province'         => $contacts_data['tech']['province'],
                'ident'            => $contacts_data['tech']['company_id'],
                'identDescription' => null,
                'identExpiry'      => null,
                'isLegalEntity'    => $contacts_data['tech']['is_legal_entity'],
                'identKind'        => null,
                'vatNo'            => $contacts_data['tech']['vat'],
                'fax'              => null,
            ]);

            if ($registrant && $admin && $tech) {
                $domain_create = new eppDomain($domain, $registrant);
                $domain_create->setPeriod($interval);
                $registrant_create = new eppContactHandle($registrant);
                $domain_create->setRegistrant($registrant_create);
                $admin_create = new eppContactHandle($admin, eppContactHandle::CONTACT_TYPE_ADMIN);
                $domain_create->addContact($admin_create);
                $tech_create = new eppContactHandle($tech, eppContactHandle::CONTACT_TYPE_TECH);
                $domain_create->addContact($tech_create);

                if (is_array($nameservers_validated)) {
                    foreach ($nameservers_validated as $nameserver) {
                        $host = new eppHost($nameserver);
                        $domain_create->addHost($host);
                    }
                }

                $create = new rnidsEppCreateDomainRequest($domain_create, true, null, $whois);
                if ((($response = $this->conn->writeandread($create)) instanceof eppCreateResponse) && ($response->Success())) {
                    $this->logResponse($response);
//                    return [
//                        'response' => true,
//                        'domain_status' => 'registered',
//                        'expiration_date' => $response->getDomainExpirationDate(),
//                    ];
                    return true;
                }
            }
        } catch (eppException $e) {
            $this->logError('Error registering domain', [
                'domain'         => $domain,
                'interval_years' => $interval,
                'contacts_data'  => $contacts_data,
                'nameservers'    => $nameservers,
                'whois'          => $whois,
                'exception'      => (array)$e->getMessage(),
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $action
     * @param $request
     */
    private function logRequest($action, $request)
    {
        \Log::channel('rnids')->info('RNIDS Request->' . $action, ['request' => (array)$request]);
    }

    /**
     * @param $hostname
     * @return bool|null
     */
    private function checkHost($hostname)
    {
        try {
            $this->logRequest('checkHost', array($hostname));

            $checkhost = new eppHost($hostname);
            $check = new eppCheckRequest($checkhost);
            if ((($response = $this->conn->writeandread($check)) instanceof eppCheckResponse) && ($response->Success())) {
                return (bool)$response->getCheckedHosts()[$hostname];
            }
        } catch (eppException $e) {
            $this->logError('Error checking host', [
                'hostname'  => $hostname,
                'exception' => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $hostname
     * @param null $ipaddress
     * @return bool|null
     */
    private function createHost($hostname, $ipaddress = null)
    {
        try {
            $this->logRequest('createHost', array($hostname, $ipaddress));

            $create = new eppHost($hostname, $ipaddress);
            $host = new eppCreateHostRequest($create);
            if ((($response = $this->conn->writeandread($host)) instanceof eppCreateResponse) && ($response->Success())) {
                return true;
            }
        } catch (eppException $e) {
            $this->logError('Error creating host', [
                'hostname'  => $hostname,
                'ipaddress' => $ipaddress,
                'exception' => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $nameserver
     * @param $domain_name
     * @return bool
     */
    public function nameserverIsSubdomain($nameserver, $domain_name)
    {
        return substr_compare($nameserver, $domain_name, strlen($nameserver) - strlen($domain_name), strlen($domain_name)) === 0;
    }

    /**
     * @param $contact_data
     * @return bool|null
     */
    public function createContact($contact_data)
    {
        try {

            $postalinfo = new eppContactPostalInfo($contact_data['name'], $contact_data['city'], $contact_data['country'], $contact_data['organization'], $contact_data['address'], $contact_data['province'], $contact_data['postcode'], eppContact::TYPE_LOC);
            $contactinfo = new eppContact($postalinfo, $contact_data['email'], $contact_data['telephone'], $contact_data['fax']);
            $contact = new rnidsEppCreateContactRequest($contactinfo, $contact_data['ident'], $contact_data['identDescription'], $contact_data['identExpiry'], $contact_data['isLegalEntity'], $contact_data['identKind'], $contact_data['vatNo']);

            if ((($response = $this->conn->writeandread($contact)) instanceof eppCreateResponse) && ($response->Success())) {
                return $response->getContactId();
            }
        } catch (eppException $e) {
            $this->logError('Error creating contact', [
                'contactData'  => $contact_data,
                'exception' => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $domain
     * @param int $interval
     * @param bool $whois
     * @return array|null
     */
    public function renewDomain($domain, $interval = 1, $whois = false)
    {
        try {

            if (!$this->isAvailable(array($domain))[0]) {
                $domain_epp = new eppDomain($domain);
                $domain_epp->setPeriodUnit('y');
                $domain_epp->setPeriod($interval);

                $info = new eppInfoDomainRequest(new eppDomain($domain));
                if ((($response = $this->conn->writeandread($info)) instanceof eppInfoDomainResponse) && ($response->Success())) {
                    $expiry = substr($response->getDomainExpirationDate(), 0, 10);
                    $expiry = date("Y-m-d", strtotime($expiry));
                }


                $renew = new eppRenewRequest($domain_epp, $expiry);
                if ((($response = $this->conn->writeandread($renew)) instanceof eppRenewResponse) && ($response->Success())) {
                    $new_expiry = date("Y-m-d", strtotime($expiry . '+ ' . $interval . ' years'));
                    return [
                        'response'        => true,
                        'expiration_date' => $new_expiry,
                    ];
                }
            }
        } catch (eppException $e) {
            $this->logError('Error renewing domain', [
                'domain'         => $domain,
                'interval_years' => $interval,
                'exception'      => (array)$e,
            ]);
            return [
                'response' => false,
                'error'    => $this->translate('renewDomain', $e->getResponseCode(), $e->getReason()),
            ];
        }
        return null;
    }

    /**
     * @param $domains
     * @return array|bool|eppResponse|null
     */
    public function isAvailable($domains)
    {
        try {
            if (!is_array($domains)) {
                $domain_name = $domains;
                $domains = array($domain_name);
            }

            $check = new eppCheckRequest($domains);
            if ((($response = $this->conn->writeandread($check)) instanceof eppCheckResponse) && ($response->Success())) {
                $checks = $response->getCheckedDomains();

                if (count($domains) !== 1) {
                    $response = array();
                    foreach ($checks as $check) {
                        array_push($response, $check['available']);
                    }
                } else {
                    $response = $checks[0]['available'];
                }
                return $response;
            }
        } catch (eppException $e) {
            $this->logError('Error checking domains', [
                'domains'   => $domains,
                'exception' => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $command
     * @param $responseCode
     * @param null $reason
     * @return null|string
     */
    private function translate($command, $responseCode, $reason = null)
    {
        switch ($command) {
            case 'isAvailable':
            case 'infoDomain':
                switch ($responseCode) {
                    case 2003:
                        return $this->getLanguage() === 'en' ? 'Domain name missing' : 'Nedostaje parametar naziv domena';
                        break;
                    case 2005:
                        return $this->getLanguage() === 'en' ? 'Invalid domain name' : 'Naziv domena nije validan';
                        break;
                    case 2303:
                        return $this->getLanguage() === 'en' ? 'Domain name does not exist' : 'Naziv domena ne postoji u sistemu';
                        break;
                }
                break;
            case 'createDomain':
                switch ($responseCode) {
                    case 2005:
                        switch ($reason) {
                            case 'Domain name is not valid':
                                return $this->getLanguage() === 'en' ? 'Domain name is not valid' : 'Ime domena nije validno';
                                break;
                        }
                        break;
                    case 2302:
                        switch ($reason) {
                            case 'Domain is not available':
                                return $this->getLanguage() === 'en' ? 'Domain is not available' : 'Domen nije dostupan';
                                break;
                        }
                        break;
                    case 2306:
                        switch ($reason) {
                            case 'Host name is not valid':
                                return $this->getLanguage() === 'en' ? 'Host name is not valid' : 'Naziv DNS servera nije validan';
                                break;
                        }
                        break;
                }
                break;
            case 'updateDomain':
                switch ($responseCode) {
                    case 2005:
                        return $this->getLanguage() === 'en' ? 'Domain name is not valid' : 'Ime domena nije validno';
                        break;
                    case 2303:
                        return $this->getLanguage() === 'en' ? 'Domain name does not exist' : 'Naziv domena ne postoji u sistemu';
                        break;
                    case 2304:
                        return $this->getLanguage() === 'en' ? 'Domain status prohibits operation (Domain is locked)' : 'Status domena ne dozvoljava ovu operaciju (Domen je zaključan)';
                        break;
                }
                break;
            case 'renewDomain':
                switch ($responseCode) {
                    case 2306:
                        return $this->getLanguage() === 'en' ? 'Current expiration date provided is not the same as domain expiration date' : 'Prosleđeni datum isteka se ne poklapa sa trenutnim datumom isteka domena';
                        break;
                }
                break;
            case 'queryTransfer':
            case 'rejectTransfer':
            case 'confirmTransfer':
                switch ($responseCode) {
                    case 2202:
                        return $this->getLanguage() === 'en' ? 'Invalid authorization code' : 'Autorizacioni kod nije validan';
                        break;
                }
                break;

            case 'checkContact':
                switch ($responseCode) {
                    case 0001:
                        return $this->getLanguage() === 'en' ? 'Contact not found' : 'Kontakt nije pronađen';
                        break;
                }
                break;
            case 'createContact':
            case 'updateContact':
                switch ($responseCode) {
                    case 2003:
                        switch ($reason) {
                            case 'Name is mandatory field':
                                return $this->getLanguage() === 'en' ? 'Contact name is mandatory field' : 'Ime i prezime kontakta je obavezno polje';
                                break;
                            case 'Phone is mandatory field':
                                return $this->getLanguage() === 'en' ? 'Contact phone is mandatory field' : 'Broj telefona kontakta je obavezno polje';
                                break;
                            case 'Email is mandatory field':
                                return $this->getLanguage() === 'en' ? 'Contact Email is mandatory field' : 'Email adresa kontakta je obavezno polje';
                                break;
                            case 'City is mandatory field':
                                return $this->getLanguage() === 'en' ? 'Contact city is mandatory field' : 'Naziv mesta kontakta je obavezno polje';
                                break;
                            case 'Organization is mandatory field':
                                return $this->getLanguage() === 'en' ? 'Contact organization is mandatory field' : 'Naziv kompanije kontakta je obavezno polje';
                                break;
                            case 'Ident number is mandatory field':
                                return $this->getLanguage() === 'en' ? 'Contact ident number is mandatory field' : 'Identifikacioni broj kontakta je obavezno polje';
                                break;
                        }
                        break;
                    case 2005:
                        switch ($reason) {
                            case 'Email is not valid':
                                return $this->getLanguage() === 'en' ? 'Email is not valid' : 'Email adresa kontakta nije validna';
                                break;
                        }
                        break;
                    case 2400:
                        return $this->getLanguage() === 'en' ? 'Contact information not send' : 'Kontakt podaci nisu prosleđeni';
                        break;
                }
                break;
            case 'infoContact':
                switch ($responseCode) {
                    case 2303:
                        return $this->getLanguage() === 'en' ? 'Contact does not exist' : 'Traženi kontakt ne postoji u sistemu';
                        break;
                }
                break;
            case 'deleteContact':
                switch ($responseCode) {
                    case 2305:
                        switch ($reason) {
                            case 'Contact has related domains':
                                return $this->getLanguage() === 'en' ? 'Contact has related domains' : 'Kontakt je povezan sa domenima';
                                break;
                        }
                        break;
                }
                break;
            case 'checkHost':
            case 'createHost':
            case 'infoHost':
            case 'updateHost':
            case 'deleteHost':
                switch ($responseCode) {
                    case 2003:
                        return $this->getLanguage() === 'en' ? 'DNS name missing' : 'Nedostaje parametar naziv DNS-a';
                        break;
                    case 2005:
                        return $this->getLanguage() === 'en' ? 'Invalid DNS server name' : 'Naziv DNS servera nije validan';
                        break;
                    case 2303:
                        return $this->getLanguage() === 'en' ? 'Requested DNS does not exist' : 'Traženi DNS ne postoji u sistemu';
                        break;
                }
                break;

            default :
                return $responseCode;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param $lang
     */
    public function setLanguage($lang)
    {
        $this->language = $lang === 'sr' ? 'sr-Latn-RS' : $lang;
    }

    /**
     * @param $domain
     * @param $lock (lock, unlock)
     * @return bool|null
     */
    public function setDomainLocking($domain, $lock)
    {
        if (!in_array($lock, ['lock', 'unlock'])) {
            $this->logError('Invalid status type', [
                'domain' => $domain,
                'status' => $lock,
            ]);
            return false;
        }
        return $this->updateDomain($domain, null, null, null, null, $lock, null);
    }

    /**
     * @param $domain
     * @param null $registrant
     * @param null $admincontact
     * @param null $techcontact
     * @param null $nameservers
     * @param null $statuses
     * @param null $operationMode
     * @return bool|null
     */
    public function updateDomain($domain, $registrant = null, $admincontact = null, $techcontact = null, $nameservers = null, $statuses = null, $operationMode = null)
    {
        try {
            $domain_handle = new eppDomain($domain);

            $del = null;
            $response = null;
            $info = new eppInfoDomainRequest($domain_handle);

            if ((($response = $this->conn->writeandread($info)) instanceof rnidsEppInfoDomainResponse) && ($response->Success())) {
                $isWhoisPrivacy = $response->getWhoisPrivacy();

                /**
                 * Operation Mode
                 */
                if (!isset($operationMode) || empty($operationMode)) {
                    $operationMode = $response->getOperationMode();
                }

                if ($nameservers) {
                    $oldns = $response->getDomainNameservers();
                    if (is_array($oldns)) {
                        $del = new eppDomain($domain);

                        foreach ($oldns as $ns) {
                            $del->addHost($ns);
                        }
                    }
                }

                if ($statuses === 'unlock') {
                    $oldStatuses = $response->getDomainStatuses();
                    if (is_array($oldStatuses)) {
                        if (!$del) {
                            $del = new eppDomain($domain);
                        }

                        foreach ($oldStatuses as $stat) {
                            if (strpos($stat, 'client') === 0) {
                                $del->addStatus($stat);
                            }
                        }
                    }
                }
            }

            $whoIsPrivacyOn = $isWhoisPrivacy == 'true' ? true : false;

            $mod = null;
            if (isset($registrant)) {
                $mod = new eppDomain($domain);

                $registrant_handle = $this->createContact($registrant);

                $reg = new eppContactHandle($registrant_handle);
                $mod->setRegistrant($reg);
            }

            $add = null;
            if (isset($admincontact)) {
                if (!$add) {
                    $add = new eppDomain($domain);
                }

                $admin_handle = $this->createContact($admincontact);

                $admin = new eppContactHandle($admin_handle, eppContactHandle::CONTACT_TYPE_ADMIN);
                $add->addContact($admin);
            }
            if (isset($techcontact)) {
                if (!$add) {
                    $add = new eppDomain($domain);
                }

                $tech_handle = $this->createContact($techcontact);

                $tech = new eppContactHandle($tech_handle, eppContactHandle::CONTACT_TYPE_TECH);
                $add->addContact($tech);
            }

            if (isset($nameservers)) {
                if (!$add) {
                    $add = new eppDomain($domain);
                }

                $nameserver_counter = 0;
                foreach ($nameservers as $nameserver) {
                    if (trim($nameserver) != '') {
                        if (!$this->checkHost($nameserver)) {
                            $this->createHost($nameserver, $this->nameserverIsSubdomain($nameserver, $domain) ? gethostbyname($nameserver) : null);
                        }

                        $host = new eppHost($nameserver, $this->nameserverIsSubdomain($nameserver, $domain) ? gethostbyname($nameserver) : null);
                        $add->addHost($host);
                    }
                    $nameserver_counter++;
                }
            }
            if ($statuses === 'lock') {
                if (!$add) {
                    $add = new eppDomain($domain);
                }
                $add->addStatus('clientUpdateProhibited');
            }

            $getNotifyAdmin = $response->getNotifyAdmin() == 'true' ? true : false;
            $getDnsSec = $response->getDnsSec() == 'true' ? true : false;

            $update = new rnidsEppUpdateDomainRequest($domain_handle, $add, $del, $mod, false, null, $whoIsPrivacyOn, $operationMode, $getNotifyAdmin, $getDnsSec);
            if ((($response = $this->conn->writeandread($update)) instanceof eppUpdateResponse) && ($response->Success())) {
                $this->logResponse($response);
                return true;
            }
        } catch (eppException $e) {
            $this->logError('Error updating domain data', [
                'domain'        => $domain,
                'registrant'    => $registrant,
                'admincontact'  => $admincontact,
                'techcontact'   => $techcontact,
                'nameservers'   => $nameservers,
                'statuses'      => $statuses,
                'operationMode' => $operationMode,
                'exception'     => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $response
     */
    private function logResponse($response)
    {
        \Log::channel('rnids')->info('RNIDS Response', ['response' => (array)$response]);
    }

    /**
     * @param $domain
     * @param $nameservers
     * @param $ip_addresses
     * @return bool|null
     */
    public function setNameservers($domain, $nameservers)
    {
        return $this->updateDomain($domain, null, null, null, $nameservers, null, null);
    }

    /**
     * @param $domain
     * @return bool|mixed
     */
    public function getNameservers($domain)
    {
        $info = $this->infoDomain($domain);
        if (!isset($info) || $info === false) {
            return false;
        }

        return $info['nameservers'];
    }

    /**
     * @param $domain
     * @return array|bool|null
     */
    public function infoDomain($domain)
    {
        try {

            if (!$this->isAvailable(array($domain))[0]) {
                $epp = new eppDomain($domain);
                $info = new eppInfoDomainRequest($epp);
                if ((($response = $this->conn->writeandread($info)) instanceof rnidsEppInfoDomainResponse) && ($response->Success())) {
                    $data = array();

                    $d = $response->getDomain();

                    $data['created'] = $response->getDomainCreateDate();
                    $data['updated'] = $response->getDomainUpdateDate();
                    $data['expires'] = substr($response->getDomainExpirationDate(), 0, 10);
                    $data['whois'] = $response->getWhoisPrivacy();
                    $data['statuses'] = $response->getDomainStatuses();
                    $data['operationMode'] = $response->getOperationMode();

                    $ns_counter = 0;
                    foreach ($d->getHosts() as $nameserver) {
                        $epp = new eppHost($nameserver->getHostName());
                        $info = new eppInfoHostRequest($epp);
                        if ((($response = $this->conn->writeandread($info)) instanceof eppInfoHostResponse) && ($response->Success())) {
                            $host = $response->getHost();

                            $data['nameservers'][$ns_counter] = array('hostname' => $nameserver->getHostName());

                            if (count($host->getIpAddresses())) {
                                foreach ($host->getIpAddresses() as $ip => $type) {
                                    $data['nameservers'][$ns_counter] = array('hostname' => $nameserver->getHostName(),
                                                                              'ip'       => $ip,
                                                                              'type'     => $type);
                                }
                            }
                        }
                        $ns_counter++;
                    }

                    $data['registrant'] = $this->infoContact($d->getRegistrant());

                    foreach ($d->getContacts() as $contact) {
                        $data[$contact->getContactType()] = $this->infoContact($contact->getContactHandle());
                    }

                    return $data;
                }
            }
        } catch (eppException $e) {
            $this->logError('Error getting domain info', [
                'domain'    => $domain,
                'exception' => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $contactID
     * @return array|bool|null|string
     */
    private function infoContact($contactID)
    {
        try {

            if (!$this->checkContact($contactID)) {
                $contact = new eppContactHandle($contactID);
                $request = new eppInfoContactRequest($contact);
                if ((($response = $this->conn->writeandread($request)) instanceof rnidsEppInfoContactResponse) && ($response->Success())) {
                    return array('name'          => $response->getContactName(),
                                 'company'       => $response->getContactCompanyname(),
                                 'street'        => $response->getContactStreet(),
                                 'city'          => $response->getContactCity(),
                                 'zip'           => $response->getContactZipcode(),
                                 'province'      => $response->getContactProvince(),
                                 'country'       => $response->getContactCountrycode(),
                                 'phone'         => $response->getContactVoice(),
                                 'fax'           => $response->getContactFax(),
                                 'mail'          => $response->getContactEmail(),
                                 'islegalentity' => $response->getContactIsLegalEntity(),
                                 'ident'         => $response->getContactIdent(),
                                 'vat'           => $response->getContactVatNo());
                }
            }
            return $this->translate('checkContact', 0001);
        } catch (eppException $e) {
            $this->logError('Error getting contact info', [
                'contactID' => $contactID,
                'exception' => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $contactID
     * @return bool|null
     */
    public function checkContact($contactID)
    {
        try {

            $contact = new eppContactHandle($contactID);
            $request = new eppCheckRequest($contact);
            if ((($response = $this->conn->writeandread($request)) instanceof eppCheckResponse) && ($response->Success())) {
                return (bool)$response->getCheckedContacts()[$contactID];
            }
        } catch (eppException $e) {
            $this->logError('Error checking contact', [
                'contactID' => $contactID,
                'exception' => (array)$e,
            ]);
            return false;
        }
        return null;
    }

    /**
     * @param $domain
     * @param $auth_code
     * @return bool
     */
    public function transferInApprove($domain, $auth_code)
    {
        try {

            $d = new eppDomain($domain);

            $d->setAuthorisationCode($auth_code);

            $transfer = new eppTransferRequest(eppTransferRequest::OPERATION_APPROVE, $d);

            if ((($response = $this->conn->writeandread($transfer)) instanceof eppTransferResponse) && ($response->Success())) {
                $this->logResponse($response);
                return true;
            }
            return false;
        } catch (eppException $e) {
            $this->logError('Error during domain transfer', [
                'domain'    => $domain,
                'exception' => (array)$e,
            ]);
            return false;
        }
    }

}