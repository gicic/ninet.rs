<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 26.7.2018.
 * Time: 12:19
 */

namespace App\SocialNetworks;


use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class Facebook
{
    protected $fb;

    public function __construct()
    {
        try {
            $this->fb = new \Facebook\Facebook([
                'app_id'                => config('services.facebook.client_id'),
                'app_secret'            => config('services.facebook.client_secret'),
                'default_graph_version' => 'v3.0',
            ]);
        } catch (FacebookSDKException $e) {
            \Log::channel('social')->error('Facebook connect error', ['exception' => $e->getMessage()]);
        }
    }

    /**
     * @return bool|\Facebook\Authentication\AccessToken|null
     */
    public function getAccessToken()
    {
        $helper = $this->fb->getJavaScriptHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            \Log::channel('social')->error('Facebook graph error', ['exception' => $e->getMessage()]);
            return false;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            \Log::channel('social')->error('Facebook SDK error', ['exception' => $e->getMessage()]);
            return false;
        }

        if (! isset($accessToken)) {
            \Log::channel('social')->error('Facebook SDK error', 'No cookie set or no OAuth data could be obtained from cookie.');
            return false;
        }

        return $accessToken;

    }

    /**
     * @return UserProfile|bool
     */
    public function getUserProfile()
    {
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $this->fb->get('/me?fields=id,name,first_name,last_name,email,address,hometown,location', $this->getAccessToken());
            $user = $response->getGraphUser();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            \Log::channel('social')->error('Facebook graph error', ['exception' => $e->getMessage()]);
            return false;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            \Log::channel('social')->error('Facebook SDK error', ['exception' => $e->getMessage()]);
            return false;
        }

        $userProfile = new UserProfile();

        $userProfile->id = $user->getId();
        if(!empty($user['name'])) {
            $nameArr = explode(' ', $user['name'], 2);
            $userProfile->firstName = $nameArr[0] ?? null;
            $userProfile->lastName = $nameArr[1] ?? null;
        }

        $userProfile->email = $user['email'] ?? null;
        $userProfile->city = $user['hometown'] ?? null;
        $userProfile->address = $user['address'] ?? null;

        return $userProfile;
    }
}