<?php


namespace App\Services\RealTime;


use Illuminate\Support\ServiceProvider;

class RealTimeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('realtime', RealTime::class);
    }
}