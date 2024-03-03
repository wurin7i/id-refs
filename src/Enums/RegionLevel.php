<?php

namespace WuriN7i\IdData\Enums;

use BenSampo\Enum\Enum;

final class RegionLevel extends Enum
{
    public const Country  = 0;
    public const Province = 1;
    public const City     = 2;
    public const District = 3;
    public const Village  = 4;
}