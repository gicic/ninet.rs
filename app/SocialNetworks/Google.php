<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 26.7.2018.
 * Time: 14:47
 */

namespace App\SocialNetworks;


class Google
{
    protected $client;

    public function __construct()
    {
        $this->client = new \Google_Client();
        $this->client->setApplicationName('NiNet Company');
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
    }
}