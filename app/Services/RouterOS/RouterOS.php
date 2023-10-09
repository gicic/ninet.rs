<?php
/**
 * Created by PhpStorm.
 * User: milan
 * Date: 06.12.2018.
 * Time: 11:05
 */

namespace App\Services\RouterOS;


use RouterOS\Config;
use RouterOS\Client;
use RouterOS\Exceptions\Exception;
use RouterOS\Query;

class RouterOS
{

    /**
     * @param $resourceId
     * @param $ipAddress
     * @param string $portSpeed
     */
    public static function setServerPortSpeed($resourceId, $ipAddress, $portSpeed = '100M/100M')
    {

        foreach (config('router-os.routers') as $router) {
            self::setPortSpeed($resourceId, $ipAddress, $portSpeed, $router['host'], $router['port'], $router['user'], $router['pass'], $router['legacy']);
        }

    }

    /**
     * @param $resourceId
     * @param $ipAddress
     * @param $portSpeed
     * @param $host
     * @param $port
     * @param $user
     * @param $pass
     * @param $legacy
     * @return array|bool
     */
    protected static function setPortSpeed($resourceId, $ipAddress, $portSpeed, $host, $port, $user, $pass, $legacy)
    {
        try {
            $config =
                (new Config())
                    ->set('host', $host)
                    ->set('port', (int)$port)
                    ->set('user', $user)
                    ->set('legacy', $legacy)
                    ->set('pass', $pass);

            $client = new Client($config);
            $query = new Query('/queue/simple/add');
            $query->add('=name=' . $resourceId)
                ->add('=target=' . $ipAddress)
                ->add('=max-limit=' . $portSpeed);

            $request = $client->write($query);
            $response = $client->read(false);

            \Log::channel('router-os')->info('Port speed is set', [
                'resourceId'     => $resourceId,
                'ipAddress'      => $ipAddress,
                'portSpeed'      => $portSpeed,
                'host'           => $host,
                'port'           => $port,
                'user'           => $user,
                'pass'           => $pass,
                'legacy'         => $legacy,
                'routerResponse' => $response,
            ]);

            return $response;
        } catch (Exception $e) {
            \Log::channel('router-os')->error('Error setting port speed', [
                'resourceId'     => $resourceId,
                'ipAddress'      => $ipAddress,
                'portSpeed'      => $portSpeed,
                'host'           => $host,
                'port'           => $port,
                'user'           => $user,
                'pass'           => $pass,
                'legacy'         => $legacy,
                'routerRequest'  => $request ?? null,
                'routerResponse' => $response ?? null,
                'exception'      => $e,
            ]);
            return false;
        }
    }
}