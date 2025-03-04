<?php

declare(strict_types=1);

use App\Modules\Response\Response;

function render(Response $response): void
{
    foreach ($response->headers as $header => $value) {
        header("{$header}: {$value}");
    }

    http_response_code($response->code);

    echo $response->content;
}