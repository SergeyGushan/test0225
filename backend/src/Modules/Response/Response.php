<?php

declare(strict_types=1);

namespace App\Modules\Response;

class Response
{
    private(set) string $content = '' {
        get {
            return $this->content;
        }
    }

    private(set) array $headers = [] {
        get {
            return $this->headers;
        }
    }

    private(set) int $code = 200 {
        get {
            return $this->code;
        }
    }

    public function __construct(int $code = 200, string $content = '', array $headers = []) {
        $this->code = $code;
        $this->content = $content;
        $this->headers = $headers;
    }

    public function json(array $data): self
    {
        $headers = $this->headers;
        $headers['Content-Type'] = 'application/json';

        $this->headers = $headers;
        $this->content .= json_encode($data);

        return $this;
    }
}