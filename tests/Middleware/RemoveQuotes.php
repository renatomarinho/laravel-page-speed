<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class RemoveQuotesTest extends TestCase
{
    public $middleware;

    public function getMiddleware()
    {
        $this->middleware = new RemoveQuotes();
    }

    public function testApply()
    {
        $html = $this->middleware->apply($this->html);

        $this->assertContains('<link rel=apple-touch-icon href=icon.png>', $html);
        $this->assertContains('<meta charset=utf-8>', $html);
        $this->assertContains('<img src=http://emblemsbf.com/img/18346.jpg width=250 style="height:300px; padding:10px" />', $html);
    }
}