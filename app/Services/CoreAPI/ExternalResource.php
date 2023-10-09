<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.12.2018.
 * Time: 15:00
 */

namespace App\Services\CoreAPI;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ExternalResource
{

    protected $guzzleClient;
    protected $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->guzzleClient = new Client();
    }

    public function createOrderExternalResource($orderId)
    {
        $accessToken = \App\Services\CoreAPI\Facades\CoreAPI::getClientAccessToken();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        try {
            $response = $this->guzzleClient->post($this->baseUrl . '/external-resource/create/' . $orderId, ['headers' => $headers]);
            \Log::info('External resource response', [$response]);
        } catch (ClientException $e) {
            \Log::error('Guzzle Client Exception', [$e]);
            return false;
        }
        return json_decode((string) $response->getBody());
    }

    public function renewOrderExternalResource($orderId)
    {
        $accessToken = \App\Services\CoreAPI\Facades\CoreAPI::getClientAccessToken();
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        try {
            $response = $this->guzzleClient->post($this->baseUrl . '/external-resource/renew/' . $orderId, ['headers' => $headers]);
            \Log::info('External resource response', [$response]);
        } catch (ClientException $e) {
            \Log::error('Guzzle Client Exception', [$e]);
            return false;
        }
        return json_decode((string) $response->getBody());
    }
}