<?php

namespace WuriN7i\IdRefs\Enums;

use WuriN7i\IdRefs\Contracts\ReferenceCoder;

enum Gender: string implements ReferenceCoder
{
    use UtilsTrait;

    case Male = 'male';
    case Female = 'female';
    case Other = 'other';
    case Unknown = 'unknown';

    public function label(): string
    {
        return match ($this) {
            self::Male => 'Laki-laki',
            self::Female => 'Perempuan',
            self::Other => 'Lainnya',
            self::Unknown => 'Tidak Diketahui',
        };
    }
}