<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Closure;
use Config;

abstract class PageSpeed
{
    /**
     * Apply rules.
     *
     * @param string $buffer
     * @return string
     */
    abstract public function apply($buffer);

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return \Illuminate\Http\Response $response
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $html = $response->getContent();
        $newContent = $this->apply($html);

        return $response->setContent($newContent);
    }

    /**
     * Replace content response.
     *
     * @param  array $replace
     * @param  string $buffer
     * @return string
     */
    protected function replace(array $replace, $buffer)
    {
        return preg_replace(array_keys($replace), array_values($replace), $buffer);
    }
}
