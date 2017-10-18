<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Closure;

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
    protected function isEnable()
    {
        $enable = config('laravel-page-speed.enable');
        return (is_null($enable))?true: (boolean) $enable ;
    }

    /**
     * Should Process
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldProcessPageSpeed($request)
    {
        $patterns = config('laravel-page-speed.skip');

        if (! $this->isEnable()) {
            return false;
        }

        if ( !is_array($patterns) ) {
            return false;
        }

        return collect($patterns)->every(function($pattern) use ($request){
            if (!$request->is($pattern)) {
                return true;
            }
        });
    }
}
