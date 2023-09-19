<?php

namespace MUID\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use MUID\MUIDHelper;

class StrSupportMacroServiceProvider extends ServiceProvider
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
        Str::macro('generateMUIDByModel', function ($model_class_name, $column_name = 'muid') {
            return MUIDHelper::generateMUIDByModel($model_class_name, $column_name);
        });

        Str::macro('generateMUIDByTable', function ($table_name, $column_name = 'muid', $column_length = 10, $charset = '0123456789abcdefghijklmnopqrstuvwxyz-_') {
            return MUIDHelper::generateMUIDByTable($table_name, $column_name, $column_length, $charset);
        });
    }
}
