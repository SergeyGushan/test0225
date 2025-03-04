<?php

declare(strict_types=1);

namespace App\Modules\Request;

readonly class RequestFile
{
    public function __construct(
        public string $name,
        public string $type,
        public int $size,
        public string $patch,
    ) {
    }

    public static function fromRequest(array $files): self
    {
        return new self(
            $files['name'],
            $files['type'],
            $files['size'],
            $files['tmp_name'],
        );
    }

    public function content(): string
    {
        return file_get_contents($this->patch);
    }
}