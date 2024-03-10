<?php

namespace WuriN7i\IdRefs\Enums;

use Illuminate\Support\Str;

trait UtilsTrait
{
    public function label(): string
    {
        return Str::headline($this->name);
    }

    public function is($against): bool
    {
        if (!$against instanceof self) {
            $against = self::tryFrom($against);
        }

        return $this === $against;
    }

    public function getCode(): string
    {
        return $this->value;
    }
}
