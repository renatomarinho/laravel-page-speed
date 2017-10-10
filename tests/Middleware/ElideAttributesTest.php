<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use Illuminate\Http\Request;
use RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;

class ElideAttributesTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new ElideAttributes();
    }

    public function testElideAttributes()
    {
        $request = new Request();

        $response = $this->middleware->handle($request, $this->getNext());

        $this->assertContains('<input type="text" disabled value="teste" width="100%">', $response->getContent());
        $this->assertContains('<input type="text" disabled>', $response->getContent());
        $this->assertContains('<option selected class="selected">Item</option>', $response->getContent());
        $this->assertContains('<button name="ok" disabled class="btn">OK</button>', $response->getContent());
        $this->assertContains('<form>', $response->getContent());
    }
}
