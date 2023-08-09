<?php

declare(strict_types=1);

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class ElideAttributes extends PageSpeed
{
    public function apply(string $buffer): string
    {
        $replace = [
            '/ method=("get"|get)/' => '',
            '/ disabled=[^ >]*(.*?)/' => ' disabled',
            '/ selected=[^ >]*(.*?)/' => ' selected',
        ];

        return $this->replace($replace, $buffer);
    }
}
