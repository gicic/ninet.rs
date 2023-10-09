<?php

namespace App\Providers;

use App\Solus\Solus;
use Illuminate\Support\ServiceProvider;

class SolusServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('solus', function () {
            return new Solus(config('services.solus_master.api_url'), config('services.solus_master.api_id'), config('services.solus_master.api_key'));
        });
    }
}
