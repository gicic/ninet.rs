<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.10.2018.
 * Time: 13:17
 */

namespace App\WHM;

use App\CommonFunctions;
use App\Models\OrderDetail;
use App\Models\WhmServer;
use Gufy\CpanelWhm\CpanelWhm;

class WHM
{

    /**
     * @param WhmServer $whmServer
     * @return CpanelWhm
     */
    protected static function getCpanelInstance(WhmServer $whmServer)
    {

        $hostname = $whmServer->name;
        if(substr($hostname, 0, 8) !== 'https://') {
            $hostname = 'https://' . $hostname;
        }

        $hostname .= ':' . $whmServer->api_port ?? '2087';

        $cpanelWhm = new CpanelWhm();
        $cpanelWhm->setTimeout(0);
        $cpanelWhm->setAuthenticationDetails($whmServer->api_user, $whmServer->api_token, $hostname);

        return $cpanelWhm;
    }

    /**
     * @param WhmServer $whmServer
     * @param string $domain
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $plan
     * @param bool $dedicatedIp
     * @return mixed
     * @throws WHMException
     */
    public static function createAccount(WhmServer $whmServer, $domain, $username, $password, $email, $plan, $dedicatedIp = false)
    {
        $cpanelWhm = self::getCpanelInstance($whmServer);

        $hosting = $cpanelWhm->createacct([
            'domain'       => $domain,
            'username'     => $username,
            'password'     => $password,
            'contactemail' => $email,
            'plan'         => $plan,
            'ip'           => $dedicatedIp === true ? 'y' : 'n',
        ]);

        $hosting = json_decode($hosting);

        $hostingResult = $hosting->result[0];

        if ($hostingResult->status == 0) {
            throw new WHMException($hostingResult->statusmsg);
        }

        return $hostingResult;
    }

    /**
     * @param WhmServer $whmServer
     * @param null $searchType
     * @param null $search
     * @return mixed
     * @throws WHMException
     */
    public static function listAccounts(WhmServer $whmServer, $searchType = null, $search = null)
    {
        $cpanelWhm = self::getCpanelInstance($whmServer);

        $result = $cpanelWhm->listaccts([
            'searchtype' => $searchType,
            'search'     => $search,
        ]);

        $result = json_decode($result);

        if($result->status == 0) {
            throw new WHMException($result->statusmsg);
        }

        return $result->acct;
    }

    /**
     * @param WhmServer $whmServer
     * @return mixed
     * @throws WHMException
     */
    public static function appList(WhmServer $whmServer)
    {
        $cpanelWhm = self::getCpanelInstance($whmServer);

        $result = $cpanelWhm->applist();
        $result = json_decode($result);

        if(!$result) {
            throw new WHMException('Invalid WHM result');
        }

        return $result;
    }

    /**
     * @param WhmServer $whmServer
     * @param $fName
     * @param $lName
     * @return string
     */
    public static function generateUsername(WhmServer $whmServer, $fName, $lName)
    {
        $username = 'h' . CommonFunctions::getInitial($fName) . CommonFunctions::getInitial($lName);

        foreach (range('a', 'z') as $character) {
            if (!self::usernameExists($whmServer, $username . $character . date('my')) && !self::usernameExistsDB($username . $character . date('my'))) {
                return $username . $character . date('my');
            }
        }
    }

    /**
     * @param WhmServer $whmServer
     * @param $username
     * @return bool
     */
    public static function usernameExists(WhmServer $whmServer, $username)
    {
        $cpanelWhm = self::getCpanelInstance($whmServer);

        $result = $cpanelWhm->listaccts([
            'searchtype' => 'user',
            'search'     => $username,
        ]);

        $result = json_decode($result);
        return (bool)count($result->acct);
    }

    /**
     * @param $username
     * @return mixed
     */
    private static function usernameExistsDB($username)
    {
        return OrderDetail::where('resource_id', $username)->count();
    }

}