<?php

declare(strict_types=1);

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class TrimUrls extends PageSpeed
{
    /**
     * Trim URLs from the given buffer
     *
     * @param  string  $buffer The input buffer to apply transformations to
     * @return string The resulting buffer after applying transformations
     */
    public function apply(string $buffer): string
    {
        return $this->replace([
            '/https:/' => '',
            '/http:/' => '',
        ], $buffer);
    }
}
