<?php

namespace WuriN7i\IdRefs;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use WuriN7i\IdRefs\Console\UpdateRegionDataCommand;

class ServiceProvider extends SupportServiceProvider
{
    public function register()
    {
        if (!class_exists('Model')) {
            require(__DIR__ . '/../helpers/Model.php');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function boot()
    {
        include(__DIR__ . '/init.php');

        if ($this->app->runningInConsole()) {
            $this->commands([UpdateRegionDataCommand::class]);
        }
    }
}