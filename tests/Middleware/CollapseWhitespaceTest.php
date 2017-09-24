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

        $compress = '<!doctype html><html class="no-js" lang=""><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge">';
        $this->assertSame($compress, $this->middleware->apply(trim($partial[0])));
    }
}
