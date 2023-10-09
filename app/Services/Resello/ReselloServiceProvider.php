<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 18.10.2018.
 * Time: 09:34
 */

namespace App\Services\Resello;


use Illuminate\Support\ServiceProvider;

class ReselloServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('resello', function() {
            return new Resello(config('services.resello.api_url'), config('services.resello.api_key'));
        });
    }
}