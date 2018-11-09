<?php

namespace RenatoMarinho\LaravelPageSpeed;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use RenatoMarinho\LaravelPageSpeed\Middleware\InlineCss;
use RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes;
use RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch;
use RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments;
use RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls;
use RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes;
use RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace;

class ServiceProvider extends BaseServiceProvider
{
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
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-page-speed.php', 'laravel-page-speed.php');
        $this->registerMiddleware();
    }

    /**
     * Register the middleware.
     */
    protected function registerMiddleware()
    {
        $middlewares = [
            InlineCss::class,
            ElideAttributes::class,
            InsertDNSPrefetch::class,
            RemoveComments::class,
            TrimUrls::class,
            RemoveQuotes::class,
            CollapseWhitespace::class,
        ];

        $middlewares = array_diff($middlewares, config('laravel-page-speed.disable_middleware'));

        $kernel = $this->app[Kernel::class];
        foreach ($middlewares as $middleware) {
            $kernel->pushMiddleware($middleware);
        }
    }
}
