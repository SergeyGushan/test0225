<?php

declare(strict_types=1);

namespace App\Repositories;

use App\App;

abstract class Repository
{
    abstract public static function table(): string;

    protected static function insert(array $data): void
    {
        App::db()->insert(static::table(), $data);
    }

    protected static function insertMany(array $data): void
    {
        App::db()->insertMany(static::table(), $data);
    }

    protected static function select(int $limit = 25, int $offset = 0): array
    {
       return App::db()->select(static::table(), pagination: [
            'limit' => $limit,
            'offset' => $offset
        ]);
    }
}