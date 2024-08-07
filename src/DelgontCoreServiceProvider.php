<?php

namespace Delgont\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

use Delgont\Core\Console\Commands\MakeRepository;
use Delgont\Core\Console\Commands\MakeModuleRepository;


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
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRepository::class,
                MakeModuleRepository::class
            ]);
        }
        
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

  
}
