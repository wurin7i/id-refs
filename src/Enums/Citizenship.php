<?php

namespace WuriN7i\IdRefs\Enums;

use WuriN7i\IdRefs\Contracts\ReferenceCoder;

enum Citizenship: string implements ReferenceCoder
{
    use UtilsTrait;

    case WNI = 'wni';
    case WNA = 'wna';

    public function label(): string
    {
        return match ($this) {
            self::WNI => 'WNI',
            self::WNA => 'WNA',
        };
    }
}