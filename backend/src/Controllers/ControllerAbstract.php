<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Modules\Request\Request;
use App\Modules\Response\Response;

abstract class ControllerAbstract
{
    abstract public function __invoke(Request $request): Response;
}