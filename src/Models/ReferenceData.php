<?php

namespace WuriN7i\IdData\Models;

use Illuminate\Database\Eloquent\Builder;
use Model;
use Ramsey\Uuid\Nonstandard\Uuid;
use WuriN7i\IdData\Enums\ReferenceType;

/**
 * ReferenceData Model
 */
class ReferenceData extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'idd_reference_data';

    /**
     * {@inheritDoc}
     */
    public static function booted()
    {
        self::creating(function (self $model) {
            $model->generateUuid();
        });
    }

    public function generateUuid(): void
    {
        $namespace = Uuid::uuid5(Uuid::NIL, $this->type);
        $this->uuid = Uuid::uuid5($namespace, $this->label);
    }

    public function setType(ReferenceType $type): void
    {
        $this->attributes['type'] = $type->value;
    }

    public function scopeByType(Builder $builder, ReferenceType $type): Builder
    {
        return $builder->where($this->qualifyColumn('type'), $type->value);
    }
}
