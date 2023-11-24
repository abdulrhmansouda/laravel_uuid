<?php

namespace MUID\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MUID\Providers\BaseServiceProvider;
use MUID\Providers\BlueprintMacroServiceProvider;
use Orchestra\Testbench\TestCase;
use Illuminate\Contracts\Config\Repository;
use MUID\Models\TableDoesNotHaveMUIDAsPrimaryKeyTest;
use MUID\Models\TableTest;
use MUID\Providers\ConfigurationServiceProvider;

class CreateTableTest extends TestCase
{
    use RefreshDatabase;
    protected function getPackageProviders($app)
    {
        return [
            BaseServiceProvider::class,
            ConfigurationServiceProvider::class,
            BlueprintMacroServiceProvider::class,
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
                'host'     => '127.0.0.1',
                'database' => 'testing_db',
                'username' => 'root',
                'password' => '',
            ]);
        });
    }
    public function test_table_test()
    {
        $instance = TableTest::create();

        $this->assertEquals(10, strlen($instance->muid));
        $this->assertEquals(5, strlen($instance->unique_code));
    }

    public function test_table_does_not_have_muid_as_primary_key_test()
    {
        $instance = TableDoesNotHaveMUIDAsPrimaryKeyTest::create();

        $this->assertIsInt($instance->id);
        $this->assertEquals(5, strlen($instance->unique_code));
    }
}
