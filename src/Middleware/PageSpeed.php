<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Closure, Config;

abstract class PageSpeed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $html = $response->getContent();
        $newContent = $this->apply($html);

        return $response->setContent($newContent);
    }

    protected function replace(array $replace, string $buffer) : string
    {
        return preg_replace(array_keys($replace), array_values($replace), $buffer);
    }
}