<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.9.2018.
 * Time: 13:02
 */

namespace App\Services\OneTimeSecret;


class OTS
{

    private $resource;

    /**
     * OTS constructor.
     * @param $customerID
     * @param $token
     * @param $ttl
     */
    public function __construct($customerID, $token, $ttl)
    {
        $this->resource = new OneTimeSecret();
        $this->resource->setCustomerID($customerID);
        $this->resource->setToken($token);
        $this->resource->setTTL($ttl);
    }

    /**
     * Generate OTS link
     *
     * @param string $secret
     * @return string
     */
    public function getSecretLink($secret)
    {
        $result = $this->resource->shareSecret($secret);

        return $this->resource->getSecretURI($result);
    }

}