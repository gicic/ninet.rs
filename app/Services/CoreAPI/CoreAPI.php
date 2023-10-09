<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.12.2018.
 * Time: 15:07
 */

namespace App\Services\CoreAPI;


use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

class CoreAPI
{
    protected $baseUrl;
    protected $clientSecret;
    protected $guzzleClient;
    protected $clientID;

    protected $allowedMethods = ['get', 'post', 'put', 'patch', 'delete'];

    /**
     * CoreAPI constructor.
     * @param $baseUrl
     * @param $clientSecret
     * @param $clientID
     * @throws \Exception
     */
    public function __construct($baseUrl, $clientSecret, $clientID)
    {
        $this->baseUrl = $baseUrl;
        $this->clientSecret = $clientSecret;
        $this->clientID = $clientID;

        if (empty($this->baseUrl) || $this->baseUrl === '') {
            throw new \Exception('API base URL is not set.');
        }

        if (empty($this->clientSecret) || $this->clientSecret === '') {
            throw new \Exception('Client secret is not set.');
        }

        if (empty($this->clientID) || $this->clientID === '') {
            throw new \Exception('Client ID is not set.');
        }

        $this->guzzleClient = new Client();

    }

    /**
     * @return null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getClientAccessToken()
    {
        $localToken = $this->getAccessTokenFromStorage();

        if(isset($localToken)) {
            return $localToken;
        }

        $apiToken = $this->getAccessTokenFromApi();

        return $apiToken;
    }

    /**
     * @return null
     */
    protected function getAccessTokenFromApi()
    {
        $baseUrl = rtrim($this->baseUrl,'/api');
        $response = $this->guzzleClient->post($baseUrl . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientID,
                'client_secret' => $this->clientSecret,
            ],
        ]);

        $responseData = json_decode((string) $response->getBody(), true);

        if(isset($responseData['access_token'])) {
            $data = [
                'expires_at' => date('Y-m-d H:i:s', time() + $responseData['expires_in']),
                'access_token' => $responseData['access_token'],
            ];

            $jsonData = json_encode($data);

            \Storage::disk('local')->put('is-api-access-token.json', $jsonData);

            return $responseData['access_token'];
        }

        return null;
    }

    /**
     * @return null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getAccessTokenFromStorage()
    {
        if(\Storage::disk('local')->exists('is-api-access-token.json')) {
            $file = \Storage::disk('local')->get('is-api-access-token.json');

            $fileContents = json_decode($file);

            $expiresAt = Carbon::parse($fileContents->expires_at);

            if ($expiresAt->isPast()) {
                return null;
            }

            return $fileContents->access_token;
        }

        return null;
    }

    /**
     * @param string $requestMethod (get, post, put, patch, delete)
     * @param string $url
     * @param array $data
     * @param array $body
     * @param array $additionalHeaders
     * @return mixed
     * @throws \Exception
     */
    public function makeRequest($requestMethod, $url, array $data = [], $body = null, array $additionalHeaders = [])
    {
        if(!in_array($requestMethod, $this->allowedMethods)) {
            throw new \Exception("Request method: " . strtoupper($requestMethod) . " is not allowed.");
        }

        $requestUrl = $this->baseUrl . $url;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getClientAccessToken(),
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
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $this->StatusCodeHandling($response);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function StatusCodeHandling(\Psr\Http\Message\ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();

        if(!in_array($statusCode, ['200', '204'])) {
            $error = json_decode($response->getBody()->getContents());
            throw new \Exception($error, $statusCode);
        }

        return json_decode($response->getBody()->getContents());
    }
}