<?php

namespace MUID\Tests;

use MUID\Providers\BlueprintMacroServiceProvider;
use Illuminate\Contracts\Config\Repository;
use MUID\Providers\BaseServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            BlueprintMacroServiceProvider::class,
            BaseServiceProvider::class,
        ];
    }


    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app->make('config'), function (Repository $config) {
            $config->set('database.default', 'mysql');
            $config->set('database.connections.mysql', [
                'driver'   => 'mysql',
                'database' => 'dbtest',
                'username' => 'root',
                'password' => '',
            ]);
        });
    }
}
