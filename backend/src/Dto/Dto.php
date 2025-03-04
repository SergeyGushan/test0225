<?php

declare(strict_types=1);

namespace App\Dto;

abstract class Dto
{
    abstract public static function from(array $data): self;

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}