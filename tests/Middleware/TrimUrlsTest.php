<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class TrimUrlsTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new TrimUrls();
    }

    public function testApply()
    {
        $html = $this->middleware->apply($this->html);

        $this->assertNotContains("https://", $html);
        $this->assertNotContains("http://", $html);
        $this->assertContains("//code.jquery.com/jquery-3.2.1.min.js", $html);
    }
}