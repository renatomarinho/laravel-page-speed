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
        config(['laravel-page-speed.enable' => false]);

        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertStringContainsString("https://", $response->getContent());
        $this->assertStringContainsString("http://", $response->getContent());
        $this->assertStringContainsString("https://code.jquery.com/jquery-3.2.1.min.js", $response->getContent());
    }


    public function testEnableIsNull()
    {
        config(['laravel-page-speed.enable' => null]);

        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertStringContainsString("//", $response->getContent());
        $this->assertStringContainsString("//", $response->getContent());
        $this->assertStringContainsString("//code.jquery.com/jquery-3.2.1.min.js", $response->getContent());
    }

    public function testSkipRoute()
    {
        config(['laravel-page-speed.skip' => ['*/downloads/*', '*/downloads2/*']]);

        $request = Request::create('https://foo/bar/downloads/100', 'GET');

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertEquals($this->html, $response->getContent());
    }

    public function testNotSkipRoute()
    {
        config(['laravel-page-speed.skip' => ['*/downloads/*', '*/downloads2/*']]);

        $request = Request::create('https://foo/bar/downloads3/100', 'GET');

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertNotEquals($this->html, $response->getContent());
    }

    public function testSkipRouteWithFileExtension()
    {
        config(['laravel-page-speed.skip' => ['*.pdf', '*.csv']]);

        $request = Request::create('https://foo/bar/test.pdf', 'GET');

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertEquals($this->html, $response->getContent());
    }

    public function testNotSkipRouteWithFileExtension()
    {
        config(['laravel-page-speed.skip' => ['*.pdf', '*.csv']]);

        $request = Request::create('https://foo/bar/test.php', 'GET');

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertNotEquals($this->html, $response->getContent());
    }
}
