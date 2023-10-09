<?php

namespace App\Services\Resello;

class Domain extends ResourceWrapper
{
    protected $paths = array(
        'collection' => '/domain',
        'transfer' => '/domain-transfer',
        'transferstatus' => '/domain-transfer/%d',
        'single' => '/domain/%s',
        'renew' => '/domain/%s/renew',
        'nameserver' => '/domain/%s/name-server',
        'auth_code' => '/domain/%s/auth-code',
        'dnsrecords' => '/domain/%s/zone',
        'is' => '/domain-is',
    );

    /**
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function all()
    {
        return $this->apiclient->get($this->get_request_path('collection'));
    }

    /**
     * @param $hostcontrol_customer_id
     * @param $domainname
     * @param $interval
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function register($hostcontrol_customer_id, $domainname, $interval)
    {
        return $this->apiclient->post($this->get_request_path('collection'), array(
            'customer'  => intval($hostcontrol_customer_id),
            'domain'    => $domainname,
            'interval'  => intval($interval),
        ));
    }

    /**
     * @param $hostcontrol_customer_id
     * @param $domainname
     * @param $authcode
     * @param $interval
     * @param $privacy_protect
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function transfer($hostcontrol_customer_id, $domainname, $authcode, $interval, $privacy_protect)
    {
        return $this->apiclient->post($this->get_request_path('transfer'), array(
            'customer'  => intval($hostcontrol_customer_id),
            'domain'    => $domainname,
            'auth_code'  => $authcode,
            'interval'  => intval($interval),
            'is_privacy_protect_enabled' => (bool)$privacy_protect
        ));
    }

    /**
     * @param $transfer
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function getTransferStatus($transfer)
    {
        $path = $this->get_request_path('transferstatus', array($transfer));
        return $this->apiclient->get($path);
    }

    /**
     * @param $domainname
     * @param $interval
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function renew($domainname, $interval)
    {
        $path = $this->get_request_path('renew', array($domainname));
        return $this->apiclient->post($path, array(
            'domain'    => $domainname,
            'interval'  => intval($interval)
        ));
    }

    /**
     * @param $domainname
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function getNameservers($domainname)
    {
        $path = $this->get_request_path('nameserver', array($domainname));
        return $this->apiclient->get($path);
    }

    /**
     * @param $domainname
     * @param $nameservers
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function setNameservers($domainname, $nameservers)
    {
        $path = $this->get_request_path('nameserver', array($domainname));
        return $this->apiclient->post($path, array(
            'name_servers' => $nameservers
        ));
    }

    /**
     * @param $domainname
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function getAuthcode($domainname)
    {
        $path = $this->get_request_path('auth_code', array($domainname));
        return $this->apiclient->get($path);
    }

    /**
     * @param $domainname
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function getDNSRecords($domainname)
    {
        $path = $this->get_request_path('dnsrecords', array($domainname));
        return $this->apiclient->get($path);
    }

    /**
     * @param $domainname
     * @param $records
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function setDNSRecords($domainname, $records)
    {
        $path = $this->get_request_path('dnsrecords', array($domainname));
        return $this->apiclient->post($path, array(
            'records' => $records
        ));
    }

    /**
     * @param $domain
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function check($domain)
    {
        $path = $this->get_request_path('is');
        return $this->apiclient->post($path, array(
            'domain' => $domain
        ));
    }

    /**
     * @param $name
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function get($name)
    {
        $path = $this->get_request_path('single', array($name));
        return $this->apiclient->get($path);
    }

    /**
     * @param $name
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function delete($name)
    {
        $path = $this->get_request_path('single', array($name));
        return $this->apiclient->delete($path);
    }

}
