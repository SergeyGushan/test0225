<?php

declare(strict_types=1);

use App\Controllers\ProductsIndexController;
use App\Controllers\ProductsImportController;
use App\Modules\Router\Router;

Router::get('/api/products', new ProductsIndexController());
Router::post('/api/products/import', new ProductsImportController());