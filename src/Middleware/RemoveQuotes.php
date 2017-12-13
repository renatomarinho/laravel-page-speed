<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class RemoveQuotes extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/ src="(.*?)"/' => ' src=$1',
            '/ width="(.*?)"/' => ' width=$1',
            '/ height="(.*?)"/' => ' height=$1',
            '/ name="(.*?)"/' => ' name=$1',
            '/ charset="(.*?)"/' => ' charset=$1',
            '/ align="(.*?)"/' => ' align=$1',
            '/ border="(.*?)"/' => ' border=$1',
            '/ crossorigin="(.*?)"/' => ' crossorigin=$1',
            '/ type="(.*?)"/' => ' type=$1',
            '/\/>/' => '>',
        ];

        return $this->replace($replace, $buffer);
    }
}
