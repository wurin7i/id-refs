<?php

namespace WuriN7i\IdRefs\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WuriN7i\IdRefs\Contracts\ReferenceCoder;
use WuriN7i\IdRefs\Enums\ReferenceType;

/**
 * ReferenceData Model
 *
 * @property ReferenceType $type
 * @property string $code
 * @property string $label
 * @property int $sort_order
 *
 * @method static Builder applyType(string|ReferenceType $refType)
 * @method static Builder applyCode(string|ReferenceCoder $refCoder)
 */
class ReferenceData extends Model
{
    use SoftDeletes;

    /**
     * @var string The database table used by the model.
     */
    protected $table = 'ref_references';

    protected $fillable = ['type', 'code', 'label', 'sort_order'];

    protected $casts = [
        'type' => ReferenceType::class,
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (! $model->sort_order) {
                $model->sort_order = $model->getNextSortOrder();
            }
        });
    }

    public function getConnectionName()
    {
        if (app()->environment('testing')) {
            return 'testing';
        }

        return config()->has('database.connections.vault') ? 'vault' : config('database.default');
    }

    public function getNextSortOrder(): int
    {
        $latestSortOrder = $this->newQuery()->max('sort_order') ?: 0;

        return $latestSortOrder + 1;
    }

    public function scopeApplyType(Builder $builder, string|ReferenceType $refType): Builder
    {
        $type = $refType instanceof ReferenceType ? $refType->value : $refType;

        return $builder->where($this->qualifyColumn('type'), $type);
    }

    public function scopeApplyCode(Builder $builder, string|ReferenceCoder $refCoder): Builder
    {
        $code = $refCoder instanceof ReferenceCoder ? $refCoder->getCode() : $refCoder;

        return $builder->where($this->qualifyColumn('code'), $code);
    }
}
