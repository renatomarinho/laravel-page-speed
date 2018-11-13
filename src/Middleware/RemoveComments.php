<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class RemoveComments extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/<!--[^]><!\[](.*?)[^\]]-->/s' => '',
            '/\/\*[\s\S]*?\*\/|([^\\:]|^)([^=\'\/\/])([^p:\/\/])\/\/.*$/m' => '$1',
            '/\h*\/\*.*?\*\/\h*/s' => '',
        ];

        return $this->replace($replace, $buffer);
    }
}