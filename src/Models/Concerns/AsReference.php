<?php

namespace WuriN7i\IdRefs\Models\Concerns;

use Exception;
use WuriN7i\IdRefs\Enums\ReferenceType;
use WuriN7i\IdRefs\Models\ReferenceData;
use WuriN7i\IdRefs\Models\Scopes\ByTypeScope;

trait AsReference
{
    public static function bootAsReference(): void
    {
        static::creating(function (ReferenceData $model) {
            $model->type = $model->getReferenceType();
        });

        static::addGlobalScope(new ByTypeScope);
    }

    public function initializeAsReference(): void
    {
        $validImplementation = property_exists($this, 'refType');

        if (! $validImplementation) {
            $className = get_class($this);
            throw new Exception("Class {$className} does not have a property \$refType or its value is invalid.");
        }
    }

    public function getReferenceType(): ReferenceType
    {
        return $this->refType;
    }
}
