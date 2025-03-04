<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\ProductDto;
use App\Modules\Request\RequestFile;
use App\Repositories\ProductRepository;

class ImportService
{
    public function products(RequestFile $file, string $separator = ';'): void

    {
        $content = $this->normalizeContent($file->content());
        $products = [];

        foreach (explode("\r\n", $content) as $key => $line) {
            if ($key === 0) {
                continue;
            }

            $data = explode($separator, $line);

            $products[] = ProductDto::from([
                'code' => $data[0],
                'name' => $data[1],
                'level1' => $data[2],
                'level2' => $data[3],
                'level3' => $data[4],
                'price' => $this->normalizePrice($data[5]),
                'price_sp' => $this->normalizePrice($data[6]),
                'quantity' => $data[7],
                'property_fields' => $data[8],
                'joint_purchases' => $data[9],
                'unit' => $data[10],
                'image' => $data[11],
                'show_on_main' => $data[12],
                'description' => $data[13],
            ])->toArray();

        }

        ProductRepository::createMany($products);
    }

    private function normalizeContent(string $content): string
    {
        $content = preg_replace('/,{2,}/', '', $content);
        return preg_replace('/(?<!\\\\)"/', '', $content);
    }

    private function normalizePrice(string $price): float
    {
        return (float)str_replace(',', '.', $price);
    }
}