<?php

namespace WuriN7i\IdRefs\Models;

use WuriN7i\IdRefs\Enums\ReferenceType;

/**
 * Religion Model
 */
class Religion extends ReferenceData
{
    use Concerns\AsReference;
    use Concerns\HasDataset;

    protected ReferenceType $refType = ReferenceType::Religion;
}
