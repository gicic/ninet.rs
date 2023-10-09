<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.9.2018.
 * Time: 15:04
 */

namespace App\Services\GoDaddy\Resource;


class Domain
{
    /**
     * Full domain name
     * @var string
     */
    public $domain;

    /**
     * Period of domain registration
     * @var int
     */
    public $period = 1;

    /**
     * An array of domain name servers
     * @var array
     */
    public $nameServers = [];
    public $renewAuto = false;
    public $privacy = false;
}