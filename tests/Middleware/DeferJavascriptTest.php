<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\DeferJavascript;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class DeferJavascriptTest extends TestCase
{
    public function test_defer_javascript()
    {
        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertContains('Boilerplate/js/main.js" defer', $response->getContent());
        $this->assertNotContains('analytics.js" async defer defer', $response->getContent());
        $this->assertNotContains('analytics.js" async defer defer', $response->getContent());
        $this->assertNotContains('<script defer>window.jQuery', $response->getContent());
    }

    protected function getMiddleware()
    {
        $this->middleware = new DeferJavascript();
    }
}
