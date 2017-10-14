<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use Illuminate\Http\Request;
use RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class TrimUrlsWithDisableFlagTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new TrimUrls();
    }

    public function testTrimUrlsWithDisableFlag()
    {
        $this->app['config']->set('laravel-page-speed.enable', false);

        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertContains("https://", $response->getContent());
        $this->assertContains("http://", $response->getContent());
        $this->assertContains("https://code.jquery.com/jquery-3.2.1.min.js", $response->getContent());
    }
}
