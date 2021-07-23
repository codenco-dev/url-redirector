<?php

namespace CodencoDev\UrlRedirector\Tests;

use CodencoDev\UrlRedirector\UrlRedirectorServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'CodencoDev\\UrlRedirector\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            UrlRedirectorServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');


        $migration = include_once __DIR__.'/../database/migrations/create_url-redirector_table.php.stub';
        (new $migration())->up();

    }
}
