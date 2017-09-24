<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class ElideAttributesTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new ElideAttributes();
    }

    public function testApply()
    {
        $html = $this->middleware->apply($this->html);

        $this->assertContains('<input type="text" disabled value="teste" width="100%">', $html);
        $this->assertContains('<input type="text" disabled>', $html);
        $this->assertContains('<option selected class="selected">Item</option>', $html);
        $this->assertContains('<button name="ok" disabled class="btn">OK</button>', $html);
        $this->assertContains('<form>', $html);
    }
}
