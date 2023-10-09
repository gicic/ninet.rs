<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.9.2018.
 * Time: 09:37
 */

namespace App\Services\GoDaddy;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

class GoDaddyClient
{

    protected $baseUrl;
    protected $apiKey;
    protected $guzzleClient;
    protected $shopperID;

    protected $allowedMethods = ['get', 'post', 'put', 'patch', 'delete'];

    /**
     * GoDaddyClient constructor.
     * @param $baseUrl
     * @param $apiKey
     * @param $shopperID
     * @throws GoDaddyException
     */
    public function __construct($baseUrl, $apiKey, $shopperID)
    {

        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->shopperID = $shopperID;

        if (empty($this->baseUrl) || $this->baseUrl === '') {
            throw new GoDaddyException('API base URL is not set.');
        }

        if (empty($this->apiKey) || $this->apiKey === '') {
            throw new GoDaddyException('API key(secret) is not set.');
        }

        if (empty($this->shopperID) || $this->shopperID === '') {
            throw new GoDaddyException('Shopper ID is not set.');
        }

        $this->guzzleClient = new Client();

    }

    /**
     * @param string $requestMethod (get, post, put, patch, delete)
     * @param string $url
     * @param array $data
     * @param array $body
     * @param array $additionalHeaders
     * @return mixed
     * @throws GoDaddyException
     */
    public function makeRequest($requestMethod, $url, array $data = [], $body = null, array $additionalHeaders = [])
    {
        if(!in_array($requestMethod, $this->allowedMethods)) {
            throw new GoDaddyException("Request method: " . strtoupper($requestMethod) . " is not allowed.");
        }

        $requestUrl = $this->baseUrl . $url;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'sso-key ' . $this->apiKey,
            'X-Shopper-Id' => $this->shopperID,
        ];

        if(! empty($additionalHeaders) && count($additionalHeaders)) {
            $headers = array_merge($headers, $additionalHeaders);
        }

        try {
            if ($requestMethod === 'get') {
                $response = $this->guzzleClient->get($requestUrl, ['headers' => $headers, RequestOptions::QUERY => $data, RequestOptions::JSON => $body]);
            }

            if ($requestMethod === 'post') {
                $response = $this->guzzleClient->post($requestUrl, ['headers' => $headers, RequestOptions::QUERY => $data, RequestOptions::JSON => $body]);
            }

            if ($requestMethod === 'put') {
                $response = $this->guzzleClient->put($requestUrl, ['headers' => $headers, RequestOptions::QUERY => $data, RequestOptions::JSON => $body]);
            }

            if ($requestMethod === 'patch') {
                $response = $this->guzzleClient->patch($requestUrl, ['headers' => $headers, RequestOptions::QUERY => $data, RequestOptions::JSON => $body]);
            }

            if ($requestMethod === 'delete') {
                $response = $this->guzzleClient->delete($requestUrl, ['headers' => $headers, RequestOptions::QUERY => $data, RequestOptions::JSON => $body]);
            }
        } catch (ClientException $e) {
            throw new GoDaddyException($e->getMessage(), $e->getCode());
        }

        return $this->StatusCodeHandling($response);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws GoDaddyException
     */
    public function StatusCodeHandling(\Psr\Http\Message\ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();

        if(!in_array($statusCode, ['200', '204'])) {
            \Log::channel('godaddy')->error('GoDaddy Request Error', [$response->getBody()]);
            \Log::channel('godaddy')->error('GoDaddy Response Error', [$response]);
            $error = json_decode($response->getBody()->getContents());
            throw new GoDaddyException($error, $statusCode);
        }

        return json_decode($response->getBody()->getContents());
    }

}