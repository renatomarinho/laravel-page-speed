<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\InlineCss;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class InlineCssTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new InlineCss();
    }

    public function testApply()
    {
        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertContains('<style>.page_speed_', $response->getContent());
        $this->assertContains('class="page_speed_', $response->getContent());
        $this->assertContains('class="btn page_speed_', $response->getContent());
        $this->assertContains('class="selected page_speed_', $response->getContent());
        
        $this->assertNotContains('class="selected"', $response->getContent());
        $this->assertNotContains('class="btn"', $response->getContent());
        $this->assertNotContains('style="', $response->getContent());
    }
}
