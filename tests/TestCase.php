<?php

namespace RenatoMarinho\LaravelPageSpeed\Test;

use RenatoMarinho\LaravelPageSpeed\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected $html;
    protected $middleware;

    public function setUp()
    {
        parent::setUp();

        $this->getMiddleware();

        $this->html = $this->getBoilerplateHTML();
    }

    private function getBoilerplateHTML()
    {
        return file_get_contents(__DIR__ .'/Boilerplate/index.html');
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
