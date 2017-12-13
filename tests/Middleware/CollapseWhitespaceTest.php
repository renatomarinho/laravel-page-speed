<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use Illuminate\Http\Request;
use Mockery as m;
use RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace;
use RenatoMarinho\LaravelPageSpeed\Test\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CollapseWhitespaceTest extends TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    protected function getMiddleware()
    {
        $this->middleware = new CollapseWhitespace();
    }

    public function testCollapseWhitespace()
    {
        $response = $this->middleware->handle($this->request, $this->getNext());

        $partial = explode('<title>', $response->getContent());
        $compress = '<!DOCTYPE html><!--[if IE 8]><html lang="en" class="ie8 no-js"><![endif]--><!--[if IE 9]><html lang="en" class="ie9 no-js"><![endif]--><!--[if !IE]><!--><html lang="en"><!--<![endif]--><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge">';

        $this->assertSame($compress, trim($partial[0]));
    }

    public function testSkipBinaryFileResponse()
    {
        $request = Request::create('/', 'GET', [], [], ['file' => new UploadedFile(__FILE__, 'foo.php')]);

        $response = $this->middleware->handle($request, function ($request) {
            return response()->download($request->file);
        });

        $this->assertInstanceOf(BinaryFileResponse::class, $response);
    }

    public function testExpectLogicExceptionInBinaryFileResponse()
    {
        $this->expectException('LogicException');

        $mock = m::mock(CollapseWhitespace::class)
                    ->shouldAllowMockingProtectedMethods()
                    ->makePartial();

        $mock->shouldReceive('shouldProcessPageSpeed')
            ->once()
            ->andReturn(true);

        $request = Request::create('/', 'GET', [], [], ['file' => new UploadedFile(__FILE__, 'foo.php')]);

        $response = $mock->handle($request, function ($request) {
            return response()->download($request->file);
        });
    }
}
