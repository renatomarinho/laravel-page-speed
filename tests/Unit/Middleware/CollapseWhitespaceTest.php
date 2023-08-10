<?php

declare(strict_types=1);

namespace DotNinth\LaravelPageSpeed\Middleware;

it('apply removes newlines', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\nWorld";
    $expectedResult = "HelloWorld";

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes carriage returns', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\rWorld";
    $expectedResult = "HelloWorld";

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes remaining newlines', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\nWorld\n";
    $expectedResult = "HelloWorld";

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes tabs', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\tWorld";
    $expectedResult = "HelloWorld";

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply replaces multiple spaces with single space', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello     World";
    $expectedResult = "Hello World";

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes spaces between HTML tags', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "<div> Hello </div>";
    $expectedResult = "<div>Hello</div>";

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

