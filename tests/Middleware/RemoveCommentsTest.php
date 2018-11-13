<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class RemoveCommentsTest extends TestCase
{
    protected $response;

    public function setUp()
    {
        parent::setUp();

        $this->response = $this->middleware->handle($this->request, $this->getNext());
    }

    protected function getMiddleware()
    {
        $this->middleware = new RemoveComments();
    }

    public function testRemoveHtmlComments()
    {
        $this->assertNotContains(
            "<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->",
            $this->response->getContent()
        );

        $this->assertContains(
            "<!--[if IE 8]>",
            $this->response->getContent()
        );

        $this->assertContains(
            "<!--[if !IE]><!-->",
            $this->response->getContent()
        );

        $this->assertContains(
            "<!--<![endif]-->",
            $this->response->getContent()
        );
    }

    public function testRemoveCssComments()
    {
        $this->assertNotContains(
            "/* This is a single-line css comment */",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "/* This is
                a multi-line
                css comment */",
            $this->response->getContent()
        );

        $this->assertContains(
            "<!--<![endif]-->",
            $this->response->getContent()
        );

        $this->assertContains(
            '.laravel-page-speed',
            $this->response->getContent()
        );

        $this->assertContains(
            'text-align: center;',
            $this->response->getContent()
        );

        $this->assertContains(
            'color: black;',
            $this->response->getContent()
        );
    }

    public function testRemoveJsComments()
    {
        $this->assertNotContains(
            "// Single Line Comment",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "/*
            Multi-line1
            Comment
        */",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "// Single Line Comment",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "/* before - inline comment*/",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "// after - inline comment",
            $this->response->getContent()
        );

        $this->assertContains(
            "console.log('Laravel');",
            $this->response->getContent()
        );

        $this->assertContains(
            "console.log('Page');",
            $this->response->getContent()
        );

        $this->assertContains(
            "console.log('Speed!');",
            $this->response->getContent()
        );
    }
}
