<?php

namespace WuriN7i\IdRefs\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use WuriN7i\IdRefs\Enums\RegionLevel;

/**
 * Region Model
 */
class Region extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'ref_regions';

    protected $fillable = [
        'label',
        'bps_code',
        'name',
        'level',
        'parent_id',
        'is_hidden',
    ];

    protected $casts = [
        'level' => RegionLevel::class,
        'is_hidden' => 'boolean',
    ];

    public function getConnectionName()
    {
        if (app()->environment('testing')) {
            return 'testing';
        }

        return config()->has('database.connections.vault') ? 'vault' : config('database.default');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function scopeIsActive(Builder $builder, bool $availability = true): Builder
    {
        return $builder->where($this->qualifyColumn('is_hidden'), ! $availability);
    }

    public function getLabelAttribute($value)
    {
        if (preg_match('~^KABUPATEN\s([\w\s]+)(,\s[.+])?$~i', $value, $matches)) {
            $value = $matches[1];
        }

        return Str::title($value);
    }

    public function scopeByBpsCode(Builder $builder, string $code): Builder
    {
        return $builder->where($this->qualifyColumn('bps_code'), $code);
    }

    public function scopeByLevel(Builder $builder, RegionLevel $level): Builder
    {
        return $builder->where($this->qualifyColumn('level'), $level->value);
    }

    public function scopeProvinceOnly(Builder $builder): Builder
    {
        return $this->scopeByLevel($builder, RegionLevel::Province);
    }

    public function scopeCityOnly(Builder $builder): Builder
    {
        return $this->scopeByLevel($builder, RegionLevel::City);
    }

    public function scopeDistrictOnly(Builder $builder): Builder
    {
        return $this->scopeByLevel($builder, RegionLevel::District);
    }

    public function scopeVillageOnly(Builder $builder): Builder
    {
        return $this->scopeByLevel($builder, RegionLevel::Village);
    }
}
