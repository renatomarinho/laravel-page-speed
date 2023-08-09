<?php

declare(strict_types=1);

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class TrimUrls extends PageSpeed
{
    public function apply(string $buffer): string
    {
        $replace = [
            '/https:/' => '',
            '/http:/' => '',
        ];

        return $this->replace($replace, $buffer);
    }
}
