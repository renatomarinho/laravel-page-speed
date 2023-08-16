<?php

declare(strict_types=1);

namespace IdealCreativeLab\LaravelTachyon\Middleware;

it('apply removes newlines', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\nWorld";
    $expectedResult = 'HelloWorld';

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes carriage returns', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\rWorld";
    $expectedResult = 'HelloWorld';

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes remaining newlines', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\nWorld\n";
    $expectedResult = 'HelloWorld';

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes tabs', function () {
    $middleware = new CollapseWhitespace();
    $buffer = "Hello\tWorld";
    $expectedResult = 'HelloWorld';

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply replaces multiple spaces with single space', function () {
    $middleware = new CollapseWhitespace();
    $buffer = 'Hello     World';
    $expectedResult = 'Hello World';

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('apply removes spaces between HTML tags', function () {
    $middleware = new CollapseWhitespace();
    $buffer = '<div>Hello</div>   <div>World</div>';
    $expectedResult = '<div>Hello</div><div>World</div>';

    $result = $middleware->apply($buffer);

    expect($result)->toBe($expectedResult);
});

it('ignores elements with data-tachyon-ignore', function () {
    $middleware = new CollapseWhitespace();
    $buffer = <<<HTML
<div>
    <div>Hello</div>   <div>World</div>
    <div data-tachyon-ignore>
        <p>Hello</p>

        <p>World</p>
    </div>
</div>
HTML;

    $expectedResult = <<<HTML
<div><div>Hello</div><div>World</div><div data-tachyon-ignore>
        <p>Hello</p>

        <p>World</p>
    </div>
</div>
HTML;

    $result = $middleware->apply($buffer);
    expect($result)->toBe($expectedResult);
});
