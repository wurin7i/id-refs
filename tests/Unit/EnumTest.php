<?php

use WuriN7i\IdRefs\Enums\BloodType;
use WuriN7i\IdRefs\Enums\Gender;
use WuriN7i\IdRefs\Enums\ReferenceType;
use WuriN7i\IdRefs\Enums\RegionLevel;
use WuriN7i\IdRefs\Enums\Religion;

test('region level enum has correct cases', function () {
    $cases = RegionLevel::cases();

    expect($cases)->toHaveCount(5)
        ->and(RegionLevel::Country->value)->toBe(0)
        ->and(RegionLevel::Province->value)->toBe(1)
        ->and(RegionLevel::City->value)->toBe(2)
        ->and(RegionLevel::District->value)->toBe(3)
        ->and(RegionLevel::Village->value)->toBe(4);
});

test('reference type enum has correct cases', function () {
    $cases = ReferenceType::cases();

    expect($cases)->toHaveCount(7)
        ->and(ReferenceType::BloodType->value)->toBe('blood-type')
        ->and(ReferenceType::EducationDegree->value)->toBe('education-degree')
        ->and(ReferenceType::Citizenship->value)->toBe('citizenship')
        ->and(ReferenceType::Gender->value)->toBe('gender')
        ->and(ReferenceType::Marital->value)->toBe('marital')
        ->and(ReferenceType::Occupation->value)->toBe('occupation')
        ->and(ReferenceType::Religion->value)->toBe('religion');
});

test('gender enum has correct cases', function () {
    $cases = Gender::cases();

    expect($cases)->toHaveCount(4)
        ->and(Gender::Male->value)->toBe('male')
        ->and(Gender::Female->value)->toBe('female')
        ->and(Gender::Other->value)->toBe('other')
        ->and(Gender::Unknown->value)->toBe('unknown');
});

test('blood type enum has correct cases', function () {
    $cases = BloodType::cases();

    expect($cases)->toHaveCount(12)
        ->and(BloodType::A->value)->toBe('oau')
        ->and(BloodType::B->value)->toBe('obu')
        ->and(BloodType::AB->value)->toBe('abu')
        ->and(BloodType::O->value)->toBe('oou')
        ->and(BloodType::APositive->value)->toBe('oap')
        ->and(BloodType::ANegative->value)->toBe('oan');
});

test('religion enum has correct cases', function () {
    $cases = Religion::cases();

    expect($cases)->toHaveCount(6)
        ->and(Religion::Islam->value)->toBe('islam')
        ->and(Religion::Protestan->value)->toBe('protestan')
        ->and(Religion::Katolik->value)->toBe('katolik')
        ->and(Religion::Hindu->value)->toBe('hindu')
        ->and(Religion::Buddha->value)->toBe('buddha')
        ->and(Religion::Khonghucu->value)->toBe('khonghucu');
});

test('gender enum provides labels', function () {
    expect(Gender::Male->label())->toBe('Laki-laki')
        ->and(Gender::Female->label())->toBe('Perempuan')
        ->and(Gender::Other->label())->toBe('Lainnya')
        ->and(Gender::Unknown->label())->toBe('Tidak Diketahui');
});

test('enums can be compared', function () {
    expect(RegionLevel::Province)->toBe(RegionLevel::Province)
        ->and(RegionLevel::Province)->not->toBe(RegionLevel::City)
        ->and(ReferenceType::Gender)->toBe(ReferenceType::Gender)
        ->and(ReferenceType::Gender)->not->toBe(ReferenceType::BloodType);
});

test('enums can be serialized and deserialized', function () {
    $regionLevel = RegionLevel::Province;
    $serialized = serialize($regionLevel);
    $unserialized = unserialize($serialized);

    expect($unserialized)->toBe(RegionLevel::Province);

    $referenceType = ReferenceType::Gender;
    $serialized = serialize($referenceType);
    $unserialized = unserialize($serialized);

    expect($unserialized)->toBe(ReferenceType::Gender);
});
