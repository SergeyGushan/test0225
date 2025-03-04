<?php

declare(strict_types=1);

namespace App\Modules\Request;

readonly class Request
{
    public function __construct(
        private array  $params,
        private array  $files,
        private string $method,
        private string $path
    ) {
    }

    public static function make(): self
    {
        return new self(
            $_REQUEST,
            $_FILES,
            $_SERVER['REQUEST_METHOD'],
            explode('?', $_SERVER['REQUEST_URI'])[0]
        );
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->params;
    }

    public function integer(string $key, int $default = 0): int
    {
        if (isset($this->params[$key]) && is_numeric($this->params[$key])) {
            return (int) $this->params[$key];
        }

        return $default;
    }

    public function file(string $key): ?RequestFile
    {
        $file = $this->files[$key] ?? null;

        if (is_null($file)) {
            return null;
        }

        return RequestFile::fromRequest($file);
    }
}
