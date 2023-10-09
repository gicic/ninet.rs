<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.12.2018.
 * Time: 15:22
 */

namespace App\Services\CoreAPI\Providers;


use App\Services\CoreAPI\CoreAPI;
use Illuminate\Support\ServiceProvider;

class CoreAPIServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('core-api', function () {
            return new CoreAPI(config('services.core-api.baseUrl'), config('services.core-api.clientSecret'), config('services.core-api.clientID'));
        });
    }
}