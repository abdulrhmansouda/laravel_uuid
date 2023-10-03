<?php

namespace MUID\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class BlueprintMacroServiceProvider extends ServiceProvider
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
        Blueprint::macro('muid', function ($column_name = 'muid', $column_length = null) {
            $column_length = (is_null($column_length)) ? config('muid.default.column_length') : $column_length;
            return $this->char($column_name, $column_length);
        });
    }
}
