<?php

namespace WuriN7i\IdData;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

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
        //
    }
}