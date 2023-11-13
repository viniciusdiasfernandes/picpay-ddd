<?php

namespace App\Infra\Http;

class Response
{
    public function __construct(
        private readonly ?string $content = '',
        private readonly int     $status = 200
    )
    {
        http_response_code($this->status);
    }

    public function send(): void
    {
        ob_start();
        header("Content-Type:application/json; charset=utf-8");
        echo $this->content;
        ob_end_flush();
    }
}