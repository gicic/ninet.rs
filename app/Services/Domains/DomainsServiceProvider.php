<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 22.10.2018.
 * Time: 10:03
 */

namespace App\Services\Domains;


use Illuminate\Support\ServiceProvider;

class DomainsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('domains', Domains::class);
    }

}