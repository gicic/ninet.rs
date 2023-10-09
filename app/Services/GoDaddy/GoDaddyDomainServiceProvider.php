<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 16.10.2018.
 * Time: 16:29
 */

namespace App\Services\GoDaddy;


use Illuminate\Support\ServiceProvider;

class GoDaddyDomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('godaddy-domain', function () {
            return new GoDaddyDomain(config('services.godaddy.base_url'), config('services.godaddy.api_key'), config('services.godaddy.shopper_id'));
        });
    }
}