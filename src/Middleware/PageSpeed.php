<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Closure;
use Config;
use Illuminate\Support\Str;

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

        if (! $this->shouldProcessPageSpeed($request)) {
            return $response;
        }

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

    /**
     * Check Laravel Page Speed is enabled or not
     *
     * @return bool
     */
    public function isEnable()
    {
        return Config::get('laravel-page-speed.enable');
    }

    /**
     * Should Process
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldProcessPageSpeed($request)
    {
        if (! $this->isEnable()) {
            return false;
        }

        $patterns = Config::get('laravel-page-speed.skip');

        foreach ($patterns as $pattern) {
            if ($request->is($pattern)) {
                return false;
            }
        }

        return true;
    }
}
