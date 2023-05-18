<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class CollapseWhitespace extends PageSpeed
{
    public function apply($buffer)
    {
        $replace = [
            "/\n([\S])/" => '$1',
            "/\r/" => '',
            "/\n/" => '',
            "/\t/" => '',
            '/ >/' => '>',
            '/ +/' => ' ',
            '/> +</' => '><',
        ];

        if (in_array(request()?->host(), config('laravel-page-speed.domain'), true)) {
            unset($replace["/\n/"]);
        }

        return $this->replace($replace, $this->removeComments($buffer));
    }

    protected function removeComments($buffer)
    {
        return (new RemoveComments)->apply($buffer);
    }
}
