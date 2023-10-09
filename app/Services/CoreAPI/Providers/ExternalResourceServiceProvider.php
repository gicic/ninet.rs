<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.12.2018.
 * Time: 15:57
 */

namespace App\Services\CoreAPI\Providers;


use App\Services\CoreAPI\ExternalResource;
use Illuminate\Support\ServiceProvider;

class ExternalResourceServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('external-resource', function () {
            return new ExternalResource(config('services.core-api.baseUrl'));
        });
    }

}