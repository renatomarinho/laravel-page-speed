<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Exception;

class CollapseWhitespace extends PageSpeed
{
    public function apply($buffer)
    {
        if (str_contains($buffer, 'Error:')) {
            return $buffer;
        }
        
        if (in_array(request()?->host(), config('laravel-page-speed.domain'), true)) {
            return $this->replace([], $this->removeComments($buffer));
        }

        $replace = [
            "/\n([\S])/" => '$1',
            "/\r/" => '',
            "/\n/" => '',
            "/\t/" => '',
            '/ >/' => '>',
            '/ +/' => ' ',
            '/> +</' => '><',
        ];

        return $this->replace($replace, $this->removeComments($buffer));
    }

    protected function removeComments($buffer)
    {
        return (new RemoveComments)->apply($buffer);
    }
}
