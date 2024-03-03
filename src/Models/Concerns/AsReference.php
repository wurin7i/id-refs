<?php

namespace WuriN7i\IdData\Models\Concerns;

use Exception;
use WuriN7i\IdData\Enums\ReferenceType;
use WuriN7i\IdData\Models\ReferenceData;
use WuriN7i\IdData\Models\Scopes\ByTypeScope;

trait AsReference
{
    public static function bootAsReference(): void
    {
        static::creating(function(ReferenceData $model) {
            $model->setType(ReferenceType::fromValue($model->type));
        });

        static::addGlobalScope(new ByTypeScope());
    }

    public function initializeAsReference(): void
    {
        $validImplementation = property_exists($this, 'type');

        try {
            ReferenceType::fromValue($this->type);
        } catch (\BenSampo\Enum\Exceptions\InvalidEnumMemberException $th) {
            $validImplementation = false;
        }

        if (!$validImplementation) {
            $className = get_class($this);
            throw new Exception("Class {$className} has not defined or \$type value is not valid.");
        }
    }
}