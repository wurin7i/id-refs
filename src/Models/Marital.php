<?php

namespace WuriN7i\IdData\Models;

use WuriN7i\IdData\Enums\ReferenceType;

/**
 * Marital Model
 */
class Marital extends ReferenceData
{
    use Concerns\AsReference;

    public string $type = ReferenceType::Marital;
}
