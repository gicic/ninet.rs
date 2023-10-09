<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 28.11.2018.
 * Time: 16:25
 */

namespace App\Repositories;


use App\Models\WhmPackage;
use App\Models\WhmServer;

class WhmRepository
{

    /**
     * @param WhmPackage $package
     * @return WhmServer|null
     */
    public static function getPreferredServer(WhmPackage $package)
    {
        return WhmServer::where('server_type', $package->package_type)
            ->orderBy('priority', 'desc')->first();
    }

}