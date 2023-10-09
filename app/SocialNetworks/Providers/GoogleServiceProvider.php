<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 26.7.2018.
 * Time: 14:47
 */

namespace App\SocialNetworks\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('google', 'App\SocialNetworks\Google');
    }

}