<?php

use WuriN7i\IdRefs\Enums\ReferenceType;
use WuriN7i\IdRefs\Enums\RegionLevel;
use WuriN7i\IdRefs\Models\ReferenceData;
use WuriN7i\IdRefs\Models\Region;
use WuriN7i\IdRefs\ServiceProvider;

test('package can be loaded', function () {
    expect(class_exists(ServiceProvider::class))->toBeTrue()
        ->and(class_exists(Region::class))->toBeTrue()
        ->and(class_exists(ReferenceData::class))->toBeTrue();
});

test('enums are available', function () {
    expect(enum_exists(RegionLevel::class))->toBeTrue()
        ->and(enum_exists(ReferenceType::class))->toBeTrue();
});

test('basic functionality works', function () {
    // Test creating a region
    $region = Region::create([
        'label' => 'Test Province',
        'name' => 'Test Province',
        'level' => RegionLevel::Province,
    ]);

    // Test creating reference data
    $reference = ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'test',
        'label' => 'Test Gender',
    ]);

    expect($region->id)->toBeGreaterThan(0)
        ->and($reference->id)->toBeGreaterThan(0)
        ->and($region->level)->toBe(RegionLevel::Province)
        ->and($reference->type)->toBe(ReferenceType::Gender);
});
