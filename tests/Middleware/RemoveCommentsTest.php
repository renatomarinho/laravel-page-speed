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
            "<!-- Place favicon.ico in the root directory -->",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "<!-- Add your site or application content here -->",
            $this->response->getContent()
        );
        
        $this->assertNotContains(
            "<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->",
            $this->response->getContent()
        );

        $this->assertContains(
            "<!--[if IE 8]> <html lang=\"en\" class=\"ie8 no-js\"> <![endif]-->",
            $this->response->getContent()
        );

        $this->assertContains(
            "<!--[if IE 9]> <html lang=\"en\" class=\"ie9 no-js\"> <![endif]-->",
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

        $this->assertContains(
            "<!--[if lte IE 9]>
            <p class=\"browserupgrade\">You are using an <strong>outdated</strong> browser. Please <a href=\"https://browsehappy.com/\">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->",
            $this->response->getContent()
        );
    }

    public function testRemoveCssComments()
    {
        $this->assertNotContains(
            "/* before - css inline comment*/color: black;/* after - css inline comment*/",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "/* This is
                a multi-line
                css comment */",
            $this->response->getContent()
        );

        $this->assertContains(
            '.laravel-page-speed {
                text-align: center;
                color: black;
            }',
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
            *   Multi-line
            *    
            *   Comment
            */",
            $this->response->getContent()
        );

        $this->assertNotContains(
            "/* before - inline comment*/console.log('Speed!');// after - inline comment",
            $this->response->getContent()
        );

        $this->assertContains(
            "<script>
            
            console.log('Laravel');
            
            console.log('Page');
            console.log('Speed!');
        </script>",
            $this->response->getContent()
        );
    }
}
