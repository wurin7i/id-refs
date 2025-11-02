<?php

namespace WuriN7i\IdRefs;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use WuriN7i\IdRefs\Console\UpdateRegionDataCommand;

class ServiceProvider extends SupportServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function boot()
    {
        include __DIR__.'/init.php';

        if ($this->app->runningInConsole()) {
            $this->commands([UpdateRegionDataCommand::class]);
        }
    }
}
