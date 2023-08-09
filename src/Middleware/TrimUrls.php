<?php

declare(strict_types=1);

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class TrimUrls extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/https:/' => '',
            '/http:/' => '',
        ];

        return $this->replace($replace, $buffer);
    }
}
