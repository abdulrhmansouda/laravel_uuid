<?php

namespace MUID\Providers;

use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResources();
    }

    private function registerResources(){
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
