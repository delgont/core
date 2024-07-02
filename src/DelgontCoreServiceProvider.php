<?php

namespace Delgont\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;




class DelgontCoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

  
}
