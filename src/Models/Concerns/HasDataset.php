<?php

namespace WuriN7i\IdRefs\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use WuriN7i\IdRefs\Contracts\ReferenceCoder;
use WuriN7i\IdRefs\Models\ReferenceData;

trait HasDataset
{
    public static function bootHasDataset(): void
    {
        static::saved(function (ReferenceData $model) {
            if (count($model->getDirty())) {
                Cache::forget($model->type->value);
            }
        });
        static::deleted(fn (ReferenceData $model) => Cache::forget($model->type->value));
        static::restored(fn (ReferenceData $model) => Cache::forget($model->type->value));
    }

    public static function getArrayOptions(): Collection
    {
        return self::dataset()->pluck('label', 'id');
    }

    public static function fromEnum(ReferenceCoder $refCoder): ?Model
    {
        return self::dataset()->firstWhere('code', $refCoder->getCode());
    }

    public static function dataset(): Collection
    {
        $instance = new self;
        $cacheKey = $instance->getReferenceType()->value;

        return Cache::rememberForever($cacheKey, fn () => $instance->all());
    }
}
