<?php

namespace WuriN7i\IdRefs\Models;

use WuriN7i\IdRefs\Enums\ReferenceType;

/**
 * EducationDegree Model
 */
class EducationDegree extends ReferenceData
{
    use Concerns\AsReference;
    use Concerns\HasDataset;

    protected ReferenceType $refType = ReferenceType::EducationDegree;
}
