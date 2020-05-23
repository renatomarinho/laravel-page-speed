<?php

namespace RenatoMarinho\LaravelPageSpeed;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    private const MIDDLEWARES_PATH = 'src/Middleware/';
    private const MIDDLEWARES_NAMESPACE = 'RenatoMarinho\\LaravelPageSpeed\\Middleware\\';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-page-speed.php' => config_path('laravel-page-speed.php'),
        ]);

        $this->registerMiddlewares();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-page-speed.php', 'laravel-page-speed.php');
    }

    /**
     * Register package middlewares.
     */
    protected function registerMiddlewares()
    {
        $middlewares = array_diff($this->getMiddlewares(), config('laravel-page-speed.disabled_middlewares', []));

        foreach ($middlewares as $middleware) {
            $this->app[Kernel::class]->pushMiddleware($middleware);
        }
    }

    private function getMiddlewares()
    {
        $middlewaresFiles = glob(self::MIDDLEWARES_PATH . '*.php');

        return array_map(function ($middleware) {
            return $this->transformMiddlewareFilePathToNamespace($middleware);
        }, $middlewaresFiles);
    }

    private function transformMiddlewareFilePathToNamespace(string $middlewareFile)
    {
        $middlewareFile = str_replace('.php', '', $middlewareFile);

        return str_replace(self::MIDDLEWARES_PATH, self::MIDDLEWARES_NAMESPACE, $middlewareFile);
    }
}
