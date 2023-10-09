<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 26.7.2018.
 * Time: 12:22
 */

namespace App\SocialNetworks\Providers;

use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('facebook', 'App\SocialNetworks\Facebook');
    }

}