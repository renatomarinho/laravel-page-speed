<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use Illuminate\Http\Request;
use RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class InsertDNSPrefetchTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new InsertDNSPrefetch();
    }

    public function testInsertDNSPrefetch()
    {
        $request = new Request();

        $response = $this->middleware->handle($request, $this->getNext());


        $this->assertContains('<link rel="dns-prefetch" href="//github.com">', $response->getContent());
        $this->assertContains('<link rel="dns-prefetch" href="//browsehappy.com">', $response->getContent());
        $this->assertContains('<link rel="dns-prefetch" href="//emblemsbf.com">', $response->getContent());
        $this->assertContains('<link rel="dns-prefetch" href="//code.jquery.com">', $response->getContent());
        $this->assertContains('<link rel="dns-prefetch" href="//www.google-analytics.com">', $response->getContent());
    }
}
