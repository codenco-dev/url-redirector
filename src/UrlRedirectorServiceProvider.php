<?php

namespace CodencoDev\UrlRedirector;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use CodencoDev\UrlRedirector\Commands\UrlRedirectorCommand;

class UrlRedirectorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('url-redirector')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_url-redirector_table')
            ->hasCommand(UrlRedirectorCommand::class);
    }
}
