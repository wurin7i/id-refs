<?php

namespace WuriN7i\IdRefs\Models;

use WuriN7i\IdRefs\Enums\ReferenceType;

/**
 * Occupation Model
 */
class Occupation extends ReferenceData
{
    use Concerns\AsReference, Concerns\HasDataset;

    protected ReferenceType $refType = ReferenceType::Occupation;
}
