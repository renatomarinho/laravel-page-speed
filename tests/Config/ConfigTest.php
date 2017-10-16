<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Config;

use Illuminate\Http\Request;
use RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class ConfigTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new TrimUrls();
    }

    public function testDisableFlag()
    {
        $this->app['config']->set('laravel-page-speed.enable', false);

        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertContains("https://", $response->getContent());
        $this->assertContains("http://", $response->getContent());
        $this->assertContains("https://code.jquery.com/jquery-3.2.1.min.js", $response->getContent());
    }

    public function testSkipRoute()
    {
        $this->app['config']->set('laravel-page-speed.skip', ['*/downloads/*']);

        $request = Request::create('https://foo/bar/downloads/100', 'GET');

        $response = $this->middleware->handle($request, $this->getNext($request));

        $this->assertEquals($this->html, $response->getContent());
    }

    public function testSkipRouteWithFileExtension()
    {
        $this->app['config']->set('laravel-page-speed.skip', ['*.pdf']);

        $request = Request::create('https://foo/bar/test.pdf', 'GET');

        $response = $this->middleware->handle($request, $this->getNext($request));

        $this->assertEquals($this->html, $response->getContent());
    }
}
