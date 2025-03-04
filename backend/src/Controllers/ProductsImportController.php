<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Modules\Request\Request;
use App\Modules\Response\Response;
use App\Service\ImportService;

class ProductsImportController extends ControllerAbstract
{
    private ImportService $importService;

    public function __construct() {
        $this->importService = new ImportService();
    }

    public function __invoke(Request $request): Response
    {
        $this->importService->products($request->file('file'), $request->get('separator'));

        return \response(201);
    }
}