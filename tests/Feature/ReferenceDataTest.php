<?php

use WuriN7i\IdRefs\Enums\ReferenceType;
use WuriN7i\IdRefs\Models\ReferenceData;

test('can create reference data', function () {
    $referenceData = ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'M',
        'label' => 'Male',
    ]);

    expect($referenceData)->toBeInstanceOf(ReferenceData::class)
        ->and($referenceData->type)->toBe(ReferenceType::Gender)
        ->and($referenceData->code)->toBe('M')
        ->and($referenceData->label)->toBe('Male');
});

test('automatically sets sort order when not provided', function () {
    $referenceData1 = ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'M',
        'label' => 'Male',
    ]);

    $referenceData2 = ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'F',
        'label' => 'Female',
    ]);

    expect($referenceData1->sort_order)->toBe(1)
        ->and($referenceData2->sort_order)->toBe(2);
});

test('can apply type scope', function () {
    ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'M',
        'label' => 'Male',
    ]);

    ReferenceData::create([
        'type' => ReferenceType::BloodType,
        'code' => 'A',
        'label' => 'A',
    ]);

    $genderData = ReferenceData::applyType(ReferenceType::Gender)->get();
    $bloodTypeData = ReferenceData::applyType(ReferenceType::BloodType)->get();

    expect($genderData)->toHaveCount(1)
        ->and($bloodTypeData)->toHaveCount(1)
        ->and($genderData->first()->type)->toBe(ReferenceType::Gender)
        ->and($bloodTypeData->first()->type)->toBe(ReferenceType::BloodType);
});

test('can soft delete reference data', function () {
    $referenceData = ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'M',
        'label' => 'Male',
    ]);

    $referenceData->delete();

    expect(ReferenceData::count())->toBe(0)
        ->and(ReferenceData::withTrashed()->count())->toBe(1);
});

test('casts type to enum', function () {
    $referenceData = ReferenceData::create([
        'type' => ReferenceType::Gender->value,
        'code' => 'M',
        'label' => 'Male',
    ]);

    expect($referenceData->type)->toBeInstanceOf(ReferenceType::class)
        ->and($referenceData->type)->toBe(ReferenceType::Gender);
});

test('type and code combination is unique', function () {
    ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'M',
        'label' => 'Male',
    ]);

    // This should throw an exception due to unique constraint
    expect(fn () => ReferenceData::create([
        'type' => ReferenceType::Gender,
        'code' => 'M',
        'label' => 'Male Duplicate',
    ]))->toThrow(\Illuminate\Database\QueryException::class);
});
