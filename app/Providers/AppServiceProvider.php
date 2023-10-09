<?php

namespace App\Providers;

use App\Models\Project;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(\Schema::hasTable('projects')) {
            $currentProject = Project::where('code', 'JS')->first();
        }
        $viewShareData = [];

        if(!empty($currentProject)) {
            $viewShareData['currentProject'] = $currentProject;
        }
        \View::share($viewShareData);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
