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
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Tests\\Factories\\'.class_basename($modelName).'Factory'
        );

        \Route::get('posts/{post}')->name('posts.show');
        \Route::get('with-slug-posts/{with_slug_post}')->name('with-slug-posts.show');


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


        include_once __DIR__.'/../database/migrations/create_url_redirector_table.php.stub';
        (new \CreateUrlRedirectorTable())->up();

        include_once __DIR__.'/migrations/create_posts_table.php.stub';
        (new \CreatePostTable())->up();



    }
}
