<?php

namespace WuriN7i\IdData\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use WuriN7i\IdData\Enums\ReferenceType;

class ByTypeScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $query, Model $model): void
    {
        $query->byType(ReferenceType::fromValue($model->type));
    }
}
