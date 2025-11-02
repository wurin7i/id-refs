<?php

use WuriN7i\IdRefs\Enums\RegionLevel;
use WuriN7i\IdRefs\Models\Region;

test('can create region', function () {
    $region = Region::create([
        'label' => 'DKI Jakarta',
        'name' => 'DKI Jakarta',
        'bps_code' => '31',
        'level' => RegionLevel::Province,
        'is_hidden' => false,
    ]);

    expect($region)->toBeInstanceOf(Region::class)
        ->and($region->label)->toBe('Dki Jakarta') // Title case dari accessor
        ->and($region->name)->toBe('DKI Jakarta')
        ->and($region->level)->toBe(RegionLevel::Province)
        ->and($region->is_hidden)->toBeFalse();
});

test('can create region with parent', function () {
    $province = Region::create([
        'label' => 'DKI Jakarta',
        'name' => 'DKI Jakarta',
        'bps_code' => '31',
        'level' => RegionLevel::Province,
    ]);

    $city = Region::create([
        'label' => 'Jakarta Pusat',
        'name' => 'Jakarta Pusat',
        'bps_code' => '3171',
        'level' => RegionLevel::City,
        'parent_id' => $province->id,
    ]);

    expect($city->parent)->toBeInstanceOf(Region::class)
        ->and($city->parent->id)->toBe($province->id);
});

test('can get children regions', function () {
    $province = Region::create([
        'label' => 'DKI Jakarta',
        'name' => 'DKI Jakarta',
        'bps_code' => '31',
        'level' => RegionLevel::Province,
    ]);

    $city1 = Region::create([
        'label' => 'Jakarta Pusat',
        'name' => 'Jakarta Pusat',
        'bps_code' => '3171',
        'level' => RegionLevel::City,
        'parent_id' => $province->id,
    ]);

    $city2 = Region::create([
        'label' => 'Jakarta Selatan',
        'name' => 'Jakarta Selatan',
        'bps_code' => '3174',
        'level' => RegionLevel::City,
        'parent_id' => $province->id,
    ]);

    expect($province->children)->toHaveCount(2)
        ->and($province->children->pluck('id')->toArray())
        ->toContain($city1->id, $city2->id);
});

test('can filter active regions', function () {
    Region::create([
        'label' => 'Active Region',
        'name' => 'Active Region',
        'level' => RegionLevel::Province,
        'is_hidden' => false,
    ]);

    Region::create([
        'label' => 'Hidden Region',
        'name' => 'Hidden Region',
        'level' => RegionLevel::Province,
        'is_hidden' => true,
    ]);

    $activeRegions = Region::isActive()->get();
    $hiddenRegions = Region::isActive(false)->get();

    expect($activeRegions)->toHaveCount(1)
        ->and($hiddenRegions)->toHaveCount(1)
        ->and($activeRegions->first()->label)->toBe('Active Region')
        ->and($hiddenRegions->first()->label)->toBe('Hidden Region');
});

test('label attribute processes kabupaten names correctly', function () {
    $region = new Region;
    $region->setRawAttributes(['label' => 'KABUPATEN BOGOR']);

    // This tests the getLabelAttribute method - should remove KABUPATEN and apply title case
    expect($region->label)->toBe('Bogor');
});

test('casts level to enum', function () {
    $region = Region::create([
        'label' => 'Test Region',
        'name' => 'Test Region',
        'level' => RegionLevel::Province->value,
    ]);

    expect($region->level)->toBeInstanceOf(RegionLevel::class)
        ->and($region->level)->toBe(RegionLevel::Province);
});
