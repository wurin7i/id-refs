<?php

namespace WuriN7i\IdRefs\Enums;

use WuriN7i\IdRefs\Contracts\ReferenceCoder;

enum BloodType: string implements ReferenceCoder
{
    use UtilsTrait;

    case O = 'oou';
    case A = 'oau';
    case B = 'obu';
    case AB = 'abu';

    case ONegative = 'oon';
    case ANegative = 'oan';
    case BNegative = 'obn';
    case ABNegative = 'abn';

    case OPositive = 'oop';
    case APositive = 'oap';
    case BPositive = 'obp';
    case ABPositive = 'abp';

    public function label(): string
    {
        return match ($this) {
            self::O => 'O',
            self::A => 'A',
            self::B => 'B',
            self::AB => 'AB',

            self::ONegative => 'O Negative',
            self::ANegative => 'A Negative',
            self::BNegative => 'B Negative',
            self::ABNegative => 'AB Negative',

            self::OPositive => 'O Positive',
            self::APositive => 'A Positive',
            self::BPositive => 'B Positive',
            self::ABPositive => 'AB Positive',
        };
    }
}