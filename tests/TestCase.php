<?php

namespace RenatoMarinho\LaravelPageSpeed\Test;

use Illuminate\Http\Request;
use RenatoMarinho\LaravelPageSpeed\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected $html;
    protected $middleware;

    abstract protected function getMiddleware();

    public function setUp()
    {
        parent::setUp();

        $this->getMiddleware();

        $this->html = $this->getBoilerplateHTML();
        $this->request = new Request();
    }

    private function getBoilerplateHTML()
    {
        return file_get_contents(__DIR__ .'/Boilerplate/index.html');
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getNext()
    {
        $response = (new \Illuminate\Http\Response($this->html));
        return function ($request) use ($response) {
            return $response;
        };
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        config(['laravel-page-speed.enable' => true]);
        config(['laravel-page-speed.skip' => []]);
        config(['laravel-page-speed.disable_middleware' => []]);
    }
}
