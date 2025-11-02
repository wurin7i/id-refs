<?php

namespace WuriN7i\IdRefs\Models;

use WuriN7i\IdRefs\Enums\ReferenceType;

/**
 * Gender Model
 */
class Gender extends ReferenceData
{
    use Concerns\AsReference;
    use Concerns\HasDataset;

    protected ReferenceType $refType = ReferenceType::Gender;
}
