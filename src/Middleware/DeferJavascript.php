<?php

declare(strict_types=1);

namespace DotNinth\LaravelPageSpeed\Middleware;

class DeferJavascript extends PageSpeed
{
    /**
     * Add defer attribute to script tags
     *
     * @param  string  $buffer The buffer to add the defer attribute to
     * @return string The modified buffer after adding the defer attribute
     */
    public function apply(string $buffer): string
    {
        return $this->replace([
            '/<script(?=[^>]+src[^>]+)((?![^>]+defer|data-pagespeed-no-defer[^>]+)[^>]+)/i' => '<script$1 defer',
        ], $buffer);
    }
}
