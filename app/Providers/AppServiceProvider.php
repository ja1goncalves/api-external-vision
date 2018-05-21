<?php

namespace App\Providers;

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
        /**
        return Relation::morphMap([
            'consult'   => 'App\Consult',
            'mothers'   => 'App\Mothers',
            'copartner' => 'App\Copartner',
        ]);
         * */
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
