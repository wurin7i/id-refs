<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use WuriN7i\IdRefs\Enums\ReferenceType;

Blueprint::macro('identityAttribute', function (ReferenceType $refType, ?string $column = null) {
    $foreignKey = $column ?? Str::snake(Str::studly($refType->value)) . '_id';
    $this->foreignId($foreignKey)->nullable()->references('id')->on('ref_references');
});
