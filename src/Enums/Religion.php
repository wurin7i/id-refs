<?php

namespace WuriN7i\IdRefs\Enums;

use WuriN7i\IdRefs\Contracts\ReferenceCoder;
use WuriN7i\IdRefs\Enums\UtilsTrait;

enum Religion: string implements ReferenceCoder
{
    use UtilsTrait;

    case Islam = 'islam';
    case Protestan = 'protestan';
    case Katolik = 'katolik';
    case Hindu = 'hindu';
    case Buddha = 'buddha';
    case Khonghucu = 'khonghucu';
}