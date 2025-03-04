<?php

declare(strict_types=1);

use App\Modules\Response\Response;
use JetBrains\PhpStorm\NoReturn;

if (!function_exists('config')) {
    function config(string $key, $default = null): mixed
    {
        static $config;

        if (is_null($config)) {
            $config = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.ini');
        }

        return $config[$key] ?? $default;
    }
}

if(!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        $pathResult = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

        if ($path) {
            $pathResult .= trim($path, DIRECTORY_SEPARATOR);
        }

        return $pathResult;
    }
}


if (!function_exists('files_from_folder')) {
    function files_from_folder(string $folder): array
    {
        return array_diff(scandir($folder), ['.', '..']);
    }
}

if (!function_exists('response')) {
    function response(int $code = 200, string $content = '', array $headers = []): Response
    {
        return new Response($code, $content, $headers);
    }
}

if (!function_exists('debug')) {
    #[NoReturn] function debug($data): never
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit();
    }
}
