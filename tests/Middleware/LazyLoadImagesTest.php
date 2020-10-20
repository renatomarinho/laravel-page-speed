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

        $this->assertContains(
            '<img loading="lazy" src="http://emblemsbf.com/img/18346.jpg" width="250" style="height:300px; padding:10px" />',
            $response->getContent()
        );
        $this->assertContains(
            '<img loading="lazy" src="tile whitespace.png" width="250" style="height:300px; padding:10px"/>',
            $response->getContent()
        );
        $this->assertContains(
            '<img src="https://via.placeholder.com/200" width="200" alt="Image with eager loading" loading="eager">',
            $response->getContent()
        );
        $this->assertContains(
            '<img loading="auto" src="https://via.placeholder.com/200" height="200" alt="Image with auto loading">',
            $response->getContent()
        );
        $this->assertContains(
            '<img src="https://via.placeholder.com/200" height="200" loading="lazy" alt="Image with lazy loading">',
            $response->getContent()
        );
    }
}
