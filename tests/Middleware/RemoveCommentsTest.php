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

    public function testApply()
    {
        $this->assertNotContains(
            "<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->",
            $this->middleware->apply($this->html)
        );

        $this->assertContains(
            "<!--[if IE 8]>",
            $this->middleware->apply($this->html)
        );

        $this->assertContains(
            "<!--[if !IE]><!-->",
            $this->middleware->apply($this->html)
        );

        $this->assertContains(
            "<!--<![endif]-->",
            $this->middleware->apply($this->html)
        );

        $this->assertContains(
            "<![endif]-->",
            $this->middleware->apply($this->html)
        );
    }
}
