<?php

namespace WuriN7i\IdRefs\Models;

use WuriN7i\IdRefs\Enums\ReferenceType;

/**
 * BloodType Model
 */
class BloodType extends ReferenceData
{
    use Concerns\AsReference, Concerns\HasDataset;

    protected ReferenceType $refType = ReferenceType::BloodType;
}
