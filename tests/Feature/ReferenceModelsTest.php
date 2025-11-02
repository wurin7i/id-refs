<?php

use WuriN7i\IdRefs\Enums\ReferenceType;
use WuriN7i\IdRefs\Models\BloodType;
use WuriN7i\IdRefs\Models\Gender;
use WuriN7i\IdRefs\Models\Religion;

test('gender model has correct reference type', function () {
    $gender = new Gender;

    expect($gender->getReferenceType())->toBe(ReferenceType::Gender);
});

test('blood type model has correct reference type', function () {
    $bloodType = new BloodType;

    expect($bloodType->getReferenceType())->toBe(ReferenceType::BloodType);
});

test('religion model has correct reference type', function () {
    $religion = new Religion;

    expect($religion->getReferenceType())->toBe(ReferenceType::Religion);
});

test('can create gender records', function () {
    $male = Gender::create([
        'code' => 'M',
        'label' => 'Male',
    ]);

    $female = Gender::create([
        'code' => 'F',
        'label' => 'Female',
    ]);

    expect(Gender::count())->toBe(2)
        ->and($male->type)->toBe(ReferenceType::Gender)
        ->and($female->type)->toBe(ReferenceType::Gender);
});

test('can create blood type records', function () {
    $bloodA = BloodType::create([
        'code' => 'A',
        'label' => 'A',
    ]);

    $bloodB = BloodType::create([
        'code' => 'B',
        'label' => 'B',
    ]);

    expect(BloodType::count())->toBe(2)
        ->and($bloodA->type)->toBe(ReferenceType::BloodType)
        ->and($bloodB->type)->toBe(ReferenceType::BloodType);
});

test('can get all genders', function () {
    Gender::create(['code' => 'M', 'label' => 'Male']);
    Gender::create(['code' => 'F', 'label' => 'Female']);

    $genders = Gender::all();

    expect($genders)->toHaveCount(2)
        ->and($genders->pluck('code')->toArray())->toContain('M', 'F');
});

test('different model types are isolated', function () {
    Gender::create(['code' => 'M', 'label' => 'Male']);
    BloodType::create(['code' => 'A', 'label' => 'A']);

    expect(Gender::count())->toBe(1)
        ->and(BloodType::count())->toBe(1);
});
