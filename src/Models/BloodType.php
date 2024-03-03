<?php

namespace WuriN7i\IdData\Models;

use WuriN7i\IdData\Enums\ReferenceType;

/**
 * BloodType Model
 */
class BloodType extends ReferenceData
{
    use Concerns\AsReference;

    public string $type = ReferenceType::BloodType;
}
