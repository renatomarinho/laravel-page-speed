<?php

namespace RenatoMarinho\LaravelPageSpeed\Test\Middleware;

use RenatoMarinho\LaravelPageSpeed\Test\TestCase;
use Symfony\Component\HttpFoundation\StreamedResponse;
use RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes;

class ShouldNotProcessResponseTest extends TestCase
{
    protected function getMiddleware()
    {
        $this->middleware = new RemoveQuotes();
    }

    /**
     * Test that a StreamedResponse is ignored by middleware.
     *
     * @return void
     */
    public function testAStreamedResponseWithRemoveQuotesMiddleware()
    {
        $response = $this->middleware->handle($this->request, $this->getNext());

        $this->assertInstanceOf(StreamedResponse::class, $response);
    }

    /**
     * Get next response.
     *
     * @return \Closure
     */
    protected function getNext()
    {
        $response =  (new StreamedResponse(function () {
            echo "I am Streamed";
        }));

        $response->headers->set('Content-Disposition', $response->headers->makeDisposition(
            'attachment',
            'foo.txt'
        ));

        return function ($request) use ($response) {
            return $response;
        };
    }
}
