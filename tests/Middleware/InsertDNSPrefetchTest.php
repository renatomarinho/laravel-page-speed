<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class InsertDNSPrefetchTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new InsertDNSPrefetch();
    }

    public function testApply()
    {
        $html = $this->middleware->apply( $this->html );

        $this->assertContains('<link rel="dns-prefetch" href="//github.com">', $html);
        $this->assertContains('<link rel="dns-prefetch" href="//browsehappy.com">', $html);
        $this->assertContains('<link rel="dns-prefetch" href="//emblemsbf.com">', $html);
        $this->assertContains('<link rel="dns-prefetch" href="//code.jquery.com">', $html);
        $this->assertContains('<link rel="dns-prefetch" href="//www.google-analytics.com">', $html);
    }
}