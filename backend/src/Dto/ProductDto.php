<?php

declare(strict_types=1);

namespace App\Dto;

class ProductDto extends Dto
{
    public string $id;

    public function __construct(
        public string $code,
        public string $name,
        public ?string $level1,
        public ?string $level2,
        public ?string $level3,
        public ?float $price,
        public ?float $price_sp,
        public ?bool $joint_purchases,
        public ?string $unit,
        public ?string $image,
        public ?string $description,
        public ?bool $show_on_main = false,
        public ?array $property_fields = [],
        public ?int $quantity = 0,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            (string) $data['code'],
            (string) $data['name'],
            (string) $data['level1'],
            (string) $data['level2'],
            (string) $data['level3'],
            (int) ($data['price'] * 100),
            (int) ($data['price_sp'] * 100),
            (bool) $data['joint_purchases'],
            (string) $data['unit'],
            (string) $data['image'],
            (string) $data['description'],
            (bool) $data['show_on_main'],
            json_decode($data['property_fields'] ?? "", true),
            (int) $data['quantity']
        );
    }
}