<?php

namespace MUID\Tests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MUID\Providers\BaseServiceProvider;
use MUID\Providers\BlueprintMacroServiceProvider;
use Orchestra\Testbench\TestCase;
use Illuminate\Contracts\Config\Repository;
use MUID\Models\TableTest;
use MUID\MUIDHelper;
use MUID\Providers\StrSupportMacroServiceProvider;

class generatingUniqueMUIDTest extends TestCase
{
    use RefreshDatabase;
    protected function getPackageProviders($app)
    {
        return [
            StrSupportMacroServiceProvider::class,
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
                'host'     => '127.0.0.1',
                'database' => 'testing_db',
                'username' => 'root',
                'password' => '',
            ]);
        });
    }

    public function test_generating_muid_by_model()
    {
        $unique_muid = MUIDHelper::generateMUIDByModel(TableTest::class);
        $this->assertEquals(10, strlen($unique_muid));

        $unique_muid = MUIDHelper::generateMUIDByModel(TableTest::class, 'unique_code');
        $this->assertEquals(5, strlen($unique_muid));
    }

    public function test_generating_muid_by_table()
    {
        $unique_muid = MUIDHelper::generateMUIDByTable('table_test');
        $this->assertEquals(10, strlen($unique_muid));

        $unique_muid = MUIDHelper::generateMUIDByTable('table_test', 'unique_code', 5);
        $this->assertEquals(5, strlen($unique_muid));
    }

    public function test_generating_muid_using_Str_support()
    {
        $unique_muid = Str::generateMUIDByModel(TableTest::class);
        $this->assertEquals(10, strlen($unique_muid));

        $unique_muid = Str::generateMUIDByModel(TableTest::class, 'unique_code');
        $this->assertEquals(5, strlen($unique_muid));

        $unique_muid = Str::generateMUIDByTable('table_test');
        $this->assertEquals(10, strlen($unique_muid));

        $unique_muid = Str::generateMUIDByTable('table_test', 'unique_code', 5);
        $this->assertEquals(5, strlen($unique_muid));
    }
}
