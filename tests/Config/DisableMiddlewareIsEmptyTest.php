<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Config;

use Illuminate\Contracts\Http\Kernel;
use RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls;
use RenatoMarinho\LaravelPageSpeed\Test\TestDisableMiddlewareCase;

class DisableMiddlewareIsEmptyTest extends TestDisableMiddlewareCase
{
    public function testDisableMiddlewareIsEmpty()
    {
        $this->assertTrue($this->app[Kernel::class]->hasMiddleware(TrimUrls::class));
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        config(['laravel-page-speed.disable_middleware' => []]);
    }
}
