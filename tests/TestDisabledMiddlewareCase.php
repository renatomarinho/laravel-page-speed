<?php

namespace RenatoMarinho\LaravelPageSpeed\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use RenatoMarinho\LaravelPageSpeed\ServiceProvider;

abstract class TestDisabledMiddlewareCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
