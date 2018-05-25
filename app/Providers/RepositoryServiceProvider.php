<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ApiLogRepository::class, \App\Repositories\ApiLogRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CompanieRepository::class, \App\Repositories\CompanieRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ConsultRepository::class, \App\Repositories\ConsultRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CopartnerRepository::class, \App\Repositories\CopartnerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmailRepository::class, \App\Repositories\EmailRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MotherRepository::class, \App\Repositories\MotherRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OccupationRepository::class, \App\Repositories\OccupationRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PhoneRepository::class, \App\Repositories\PhoneRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StreetRepository::class, \App\Repositories\StreetRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\VehiclesRepository::class, \App\Repositories\VehiclesRepositoryEloquent::class);
        //:end-bindings:
    }
}
