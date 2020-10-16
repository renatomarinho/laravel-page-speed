<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Closure;

class LazyLoadImages extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/<img(\b[^><]((?!loading).)*)>/' => '<img $1 loading="lazy">',
        ];

        return $this->replace($replace, $buffer);
    }
}
