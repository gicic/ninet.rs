<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 4.9.2018.
 * Time: 12:59
 */

namespace App\Services\OneTimeSecret;


use Illuminate\Support\ServiceProvider;

class OneTimeSecretServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('ots', function () {
            return new OTS(config('services.ots.client_id'), config('services.ots.token'), config('services.ots.tll'));
        });
    }

}