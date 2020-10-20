<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Closure;

class LazyLoadImages extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/<img(\b[^><]((?!loading).)*)\/?>/' => '<img loading="lazy"$1>',
        ];

        return $this->replace($replace, $buffer);
    }
}
