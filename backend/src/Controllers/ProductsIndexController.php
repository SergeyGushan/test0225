<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Modules\Request\Request;
use App\Modules\Response\Response;
use App\Repositories\ProductRepository;

class ProductsIndexController extends ControllerAbstract
{
    public function __invoke(Request $request): Response
    {
        $products = ProductRepository::get(
            $request->integer('limit', 25),
            $request->integer('offset')
        );

        return \response()->json(['products' => $products]);
    }
}