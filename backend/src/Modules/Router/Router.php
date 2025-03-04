<?php

declare(strict_types=1);

namespace App\Modules\Router;

class Router
{
    private static array $routes;

    public static function add(string $method, string $path, callable $handler): void
    {
        self::$routes[$method][self::preparePatch($path)] = $handler;
    }

    public static function get(string $path, callable $handler): void
    {
        self::add('GET', $path, $handler);
    }

    public static function post(string $path, callable $handler): void
    {
        self::add('POST', $path, $handler);
    }

    public static function getHandler(string $method, string $path): ?callable
    {
        return self::$routes[self::prepareMethod($method)][self::preparePatch($path)] ?? null;
    }

    private static function prepareMethod(string $method): string
    {
        return strtoupper($method);
    }

    private static function preparePatch(string $path): string
    {
        return strtoupper(trim($path, '/'));
    }
}