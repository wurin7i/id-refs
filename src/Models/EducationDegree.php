<?php

namespace WuriN7i\IdData\Models;

use WuriN7i\IdData\Enums\ReferenceType;

/**
 * EducationDegree Model
 */
class EducationDegree extends ReferenceData
{
    use Concerns\AsReference;

    public string $type = ReferenceType::EducationDegree;
}
