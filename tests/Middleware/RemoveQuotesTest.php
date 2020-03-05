<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

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
        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertStringContainsString('<link rel="apple-touch-icon" href="icon.png">', $response->getContent());
        $this->assertStringContainsString('<meta charset=utf-8>', $response->getContent());
        $this->assertStringContainsString('<meta name=viewport content="width=device-width, initial-scale=1">', $response->getContent());
        $this->assertStringContainsString('<img src=http://emblemsbf.com/img/18346.jpg width=250 style="height:300px; padding:10px" >', $response->getContent());
        $this->assertStringContainsString('<img src=/images/1000coin.png>', $response->getContent());
        $this->assertStringContainsString('<vue-component :src="\'src\'" :type="\'type\'" :width="200"></vue-component>', $response->getContent());
    }
}
