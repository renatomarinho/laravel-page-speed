<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Config;

use Illuminate\Http\Request;
use RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace;
use RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $this->assertContains("https://", $response->getContent());
        $this->assertContains("http://", $response->getContent());
        $this->assertContains("https://code.jquery.com/jquery-3.2.1.min.js", $response->getContent());
    }


    public function testEnableIsNull()
    {
        config(['laravel-page-speed.enable' => null]);

        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertContains("//", $response->getContent());
        $this->assertContains("//", $response->getContent());
        $this->assertContains("//code.jquery.com/jquery-3.2.1.min.js", $response->getContent());
    }

    public function testSkipRoute()
    {
        config(['laravel-page-speed.skip' => ['*/downloads/*', '*/downloads2/*']]);

        $request = Request::create('https://foo/bar/downloads/100', 'GET');

        $response = $this->middleware->handle($request, $this->getNext($request));

        $this->assertEquals($this->html, $response->getContent());
    }

    public function testNotSkipRoute()
    {
        config(['laravel-page-speed.skip' => ['*/downloads/*', '*/downloads2/*']]);

        $request = Request::create('https://foo/bar/downloads3/100', 'GET');

        $response = $this->middleware->handle($request, $this->getNext($request));

        $this->assertNotEquals($this->html, $response->getContent());
    }

    public function testSkipRouteWithFileExtension()
    {
        config(['laravel-page-speed.skip' => ['*.pdf', '*.csv']]);

        $request = Request::create('https://foo/bar/test.pdf', 'GET');

        $response = $this->middleware->handle($request, $this->getNext($request));

        $this->assertEquals($this->html, $response->getContent());
    }

    public function testNotSkipRouteWithFileExtension()
    {
        config(['laravel-page-speed.skip' => ['*.pdf', '*.csv']]);

        $request = Request::create('https://foo/bar/test.php', 'GET');

        $response = $this->middleware->handle($request, $this->getNext($request));

        $this->assertNotEquals($this->html, $response->getContent());
    }

    public function testSkipBinaryFileResponse()
    {
        $this->middleware = new CollapseWhitespace();

        $request = Request::create('/', 'GET', [], [], ['file' => new UploadedFile(__FILE__, 'foo.php')]);

        $response = $this->middleware->handle($request, function ($request) {
            return response()->download($request->file);
        });

        $this->assertInstanceOf(BinaryFileResponse::class, $response);
    }
}
