<?php

namespace WuriN7i\IdRefs\Models;

use WuriN7i\IdRefs\Enums\ReferenceType;

/**
 * Citizenship Model
 */
class Citizenship extends ReferenceData
{
    use Concerns\AsReference;
    use Concerns\HasDataset;

    protected ReferenceType $refType = ReferenceType::Citizenship;
}
