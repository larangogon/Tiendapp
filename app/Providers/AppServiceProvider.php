<?php

namespace App\Providers;

use App\Decorators\DecoratorProduct;
use App\Decorators\DecoratorRol;
use App\Decorators\DecoratorSize;
use App\Decorators\DecoratorTrademark;
use App\Decorators\DecoratorUser;
use App\Interfaces\InterfaceProducts;
use App\Interfaces\InterfaceRoles;
use App\Interfaces\InterfaceSizes;
use App\Interfaces\InterfaceTrademarks;
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
        $this->app->bind(InterfaceSizes::class, DecoratorSize::class);
        $this->app->bind(InterfaceProducts::class, DecoratorProduct::class);
        $this->app->bind(InterfaceTrademarks::class, DecoratorTrademark::class);
    }
}
