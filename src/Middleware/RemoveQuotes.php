<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class RemoveQuotes extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/ src="(.\S*?)"/' => ' src=$1',
            '/ width="(.\S*?)"/' => ' width=$1',
            '/ height="(.\S*?)"/' => ' height=$1',
            '/ name="(.\S*?)"/' => ' name=$1',
            '/ charset="(.\S*?)"/' => ' charset=$1',
            '/ align="(.\S*?)"/' => ' align=$1',
            '/ border="(.\S*?)"/' => ' border=$1',
            '/ crossorigin="(.\S*?)"/' => ' crossorigin=$1',
            '/ type="(.\S*?)"/' => ' type=$1',
            '/\/>/' => '>',
        ];

        return $this->replace($replace, $buffer);
    }
}
