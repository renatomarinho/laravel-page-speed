<?php

namespace RenatoMarinho\LaravelBladeMinify\Middleware;

use Closure;

class Minify
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

        //ini_set('zlib.output_compression', 'On');

        return $this->html($response);
    }

    public function html($response)
    {
        $buffer = $response->getContent();

        $replace = array(
            '/<!--[^\[](.*?)[^\]]-->/s' => '',
            "/<\?php/" => '<?php ',
            "/\n([\S])/" => '$1',
            "/\r/" => '',
            "/\n/" => '',
            "/\t/" => '',
            "/ +/" => ' ',
        );

        if (strpos($buffer, '<pre>') !== false) {
            $replace = array(
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/" => '<?php ',
                "/\r/" => '',
                "/>\n</" => '><',
                "/>\s+\n</" => '><',
                "/>\n\s+</" => '><',
            );
        }

        $buffer = preg_replace(array_keys($replace), array_values($replace), $buffer);

        $response->setContent($buffer);

        return $response;
    }
}
