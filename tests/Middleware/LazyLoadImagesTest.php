<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\LazyLoadImages;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class LazyLoadImagesTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new LazyLoadImages();
    }

    public function testLazyLoadImages()
    {
        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertContains('<img src="http://emblemsbf.com/img/18346.jpg" width="250" style="height:300px; padding:10px" loading="lazy"/>', $response->getContent());
        $this->assertContains('<img src="tile whitespace.png" width="250" style="height:300px; padding:10px" loading="lazy"/>', $response->getContent());
    }
}
