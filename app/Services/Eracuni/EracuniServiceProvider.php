<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 15.10.2018.
 * Time: 10:33
 */

namespace App\Services\Eracuni;


use Illuminate\Support\ServiceProvider;

class EracuniServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('eracuni', function () {
            return new Eracuni(config('services.eracuni.username'), config('services.eracuni.password'), config('services.eracuni.token'));
        });
    }

}