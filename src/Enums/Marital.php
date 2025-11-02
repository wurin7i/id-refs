<?php

namespace WuriN7i\IdRefs\Enums;

use WuriN7i\IdRefs\Contracts\ReferenceCoder;

enum Marital: string implements ReferenceCoder
{
    use UtilsTrait;

    case BelumKawin = 'belum-kawin';
    case Kawin = 'kawin';
    case CeraiHidup = 'cerai-hidup';
    case CeraiMati = 'cerai-mati';
}
