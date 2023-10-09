<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 17.10.2018.
 * Time: 11:44
 */

namespace App\Services\Rnids;


use Illuminate\Support\ServiceProvider;

class RnidsServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->app->singleton('rnids', Rnids::class);
        $this->app->singleton('rnids', function () {
            $rnids = new Rnids();
            $rnids->login();
            return $rnids;
        });
    }
}