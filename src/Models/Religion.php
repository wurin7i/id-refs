<?php

namespace WuriN7i\IdData\Models;

use WuriN7i\IdData\Enums\ReferenceType;

/**
 * Religion Model
 */
class Religion extends ReferenceData
{
    use Concerns\AsReference;

    public string $type = ReferenceType::Religion;
}
