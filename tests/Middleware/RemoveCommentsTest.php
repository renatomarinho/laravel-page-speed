<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class RemoveCommentsTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new RemoveComments();
    }

    public function testRemoveComments()
    {
        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertNotContains(
            "<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->",
            $response->getContent()
        );

        $this->assertContains(
            "<!--[if IE 8]>",
            $response->getContent()
        );

        $this->assertContains(
            "<!--[if !IE]><!-->",
            $response->getContent()
        );

        $this->assertContains(
            "<!--<![endif]-->",
            $response->getContent()
        );

        $this->assertContains(
            "<![endif]-->",
            $response->getContent()
        );
        
        $this->assertNotContains(
            "/** comment of example */",
            $response->getContent()
        );

        $this->assertNotContains(
            "/*
              * comment of example
              */",
            $response->getContent()
        );

        $this->assertNotContains(
            "// comment of example",
            $response->getContent()
        );
    }
}
