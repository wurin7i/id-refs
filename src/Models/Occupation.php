<?php

namespace WuriN7i\IdData\Models;

use WuriN7i\IdData\Enums\ReferenceType;

/**
 * Occupation Model
 */
class Occupation extends ReferenceData
{
    use Concerns\AsReference;

    public string $type = ReferenceType::Occupation;
}
