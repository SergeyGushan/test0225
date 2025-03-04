<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\ProductDto;

class ProductRepository extends Repository
{
    public static function create(array $data): void
    {
        parent::insert($data);
    }

    public static function createMany(array $data): void
    {
        foreach (array_chunk($data, 500) as $chunk) {
            parent::insertMany($chunk);
        }
    }

    public static function get(int $limit = 25, int $offset = 0): array
    {
        return array_map(fn($product) => ProductDto::from($product)->toArray(), parent::select($limit, $offset));
    }

    public static function table(): string
    {
        return 'products';
    }
}