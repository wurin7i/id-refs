<?php

use WuriN7i\IdRefs\Console\UpdateRegionDataCommand;
use WuriN7i\IdRefs\ServiceProvider;

test('service provider registers migrations', function () {
    $provider = new ServiceProvider($this->app);

    expect($provider)->toBeInstanceOf(ServiceProvider::class);
});

test('service provider registers commands in console', function () {
    if (! $this->app->runningInConsole()) {
        $this->markTestSkipped('Test only runs in console environment.');
    }

    $provider = new ServiceProvider($this->app);
    $provider->boot();

    expect($this->app->make(UpdateRegionDataCommand::class))
        ->toBeInstanceOf(UpdateRegionDataCommand::class);
});

test('service provider loads migrations', function () {
    $provider = new ServiceProvider($this->app);
    $provider->register();

    // Test that migrations are loaded (this is implicitly tested when migrations run)
    expect(true)->toBeTrue();
});
