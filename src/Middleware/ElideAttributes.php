<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class ElideAttributes extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/ method=("get"|get)/' => '',
            '/ disabled=[^ >]*(.*?)/' => ' disabled',
            '/ selected=[^ >]*(.*?)/' => ' selected',
        ];

        return $this->replace($replace, $buffer);
    }
}
