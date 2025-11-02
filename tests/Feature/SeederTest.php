<?php

use WuriN7i\IdRefs\Database\Seeders\ReferenceDataSeeder;
use WuriN7i\IdRefs\Enums\ReferenceType;
use WuriN7i\IdRefs\Models\ReferenceData;

test('reference data seeder can run', function () {
    $seeder = new ReferenceDataSeeder;
    $seeder->run();

    expect(ReferenceData::count())->toBeGreaterThan(0);
});

test('reference data seeder creates gender data', function () {
    $seeder = new ReferenceDataSeeder;
    $seeder->run();

    $genderData = ReferenceData::where('type', ReferenceType::Gender)->get();

    expect($genderData)->toHaveCount(4)
        ->and($genderData->pluck('code')->toArray())
        ->toContain('male', 'female', 'other', 'unknown');
});

test('reference data seeder creates blood type data', function () {
    $seeder = new ReferenceDataSeeder;
    $seeder->run();

    $bloodTypeData = ReferenceData::where('type', ReferenceType::BloodType)->get();

    expect($bloodTypeData->count())->toBeGreaterThan(0);
});

test('reference data seeder creates religion data', function () {
    $seeder = new ReferenceDataSeeder;
    $seeder->run();

    $religionData = ReferenceData::where('type', ReferenceType::Religion)->get();

    expect($religionData)->toHaveCount(6)
        ->and($religionData->pluck('code')->toArray())
        ->toContain('islam', 'protestan', 'katolik', 'hindu', 'buddha', 'khonghucu');
});

test('seeded data has correct sort order', function () {
    $seeder = new ReferenceDataSeeder;
    $seeder->run();

    $genderData = ReferenceData::where('type', ReferenceType::Gender)
        ->orderBy('sort_order')
        ->get();

    expect($genderData->first()->sort_order)->toBe(1)
        ->and($genderData->last()->sort_order)->toBeGreaterThan(1);
});
