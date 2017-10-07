<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class CollapseWhitespaceTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new CollapseWhitespace();
    }

    public function testApply()
    {
        $partial = explode('<title>', $this->html);

        $compress = '<!DOCTYPE html><!--[if IE 8]><html lang="en" class="ie8 no-js"><![endif]--><!--[if IE 9]><html lang="en" class="ie9 no-js"><![endif]--><!--[if !IE]><!--><html lang="en"><!--<![endif]--><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge">';
        $this->assertSame($compress, $this->middleware->apply(trim($partial[0])));
    }
}
