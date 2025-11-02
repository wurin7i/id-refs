<?php

use WuriN7i\IdRefs\Console\UpdateRegionDataCommand;

test('update region command exists', function () {
    $command = new UpdateRegionDataCommand;

    expect($command->getName())->toBe('idrefs:update-region')
        ->and($command->getDescription())->toBe('Update region data');
});

test('update region command has correct signature', function () {
    $command = new UpdateRegionDataCommand;

    expect($command->getDefinition()->hasOption('source'))->toBeTrue();
});

test('command can be registered in application', function () {
    $this->artisan('list')
        ->assertSuccessful()
        ->expectsOutputToContain('idrefs:update-region');
});
