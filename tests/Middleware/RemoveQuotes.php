<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use Illuminate\Http\Request;
use RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class RemoveQuotesTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new RemoveQuotes();
    }

    public function testRemoveQuotes()
    {
        $request = new Request();

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertContains('<link rel=apple-touch-icon href=icon.png>', $response->getContent());
        $this->assertContains('<meta charset=utf-8>', $response->getContent());
        $this->assertContains('<img src=http://emblemsbf.com/img/18346.jpg width=250 style="height:300px; padding:10px" />', $response->getContent());
    }
}
