<?php

namespace App\Providers;

use App\Decorators\DecoratorRol;
use App\Decorators\DecoratorUser;
use App\Interfaces\InterfaceRoles;
use App\Interfaces\InterfaceUsers;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(InterfaceRoles::class, DecoratorRol::class);
        $this->app->bind(InterfaceUsers::class, DecoratorUser::class);
    }
}
