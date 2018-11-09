<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class RemoveComments extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            '/<!--[^]><!\[](.*?)[^\]]-->/s' => '',
            '/^\h*(?|(.*"[^"]*\/\/[^"]*".*)|(.*)\/\/.*\h*)$/m' => '$1',
            '/\/\*[\s\S]*?\*\/|([^\\:]|^)\/\/.*$/m' => '$1',
            '/\h*\/\*.*?\*\/\h*/s' => '',
        ];

        return $this->replace($replace, $buffer);
    }
}
