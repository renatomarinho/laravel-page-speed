<?php

namespace DotNinth\LaravelPageSpeed\Middleware;

it('should elide attributes from the given buffer', function () {
    $elideAttributes = new ElideAttributes();

    $buffer = '<form method="get" id="myForm">Form Content</form>';

    $modifiedBuffer = $elideAttributes->apply($buffer);

    expect($modifiedBuffer)->not->toContain('method="get"');
    expect($modifiedBuffer)->toContain('<form id="myForm">Form Content</form>');
});

it('should elide disabled attributes from the given buffer', function () {
    $elideAttributes = new ElideAttributes();

    $buffer = '<input type="text" disabled="disabled" value="Hello">';

    $modifiedBuffer = $elideAttributes->apply($buffer);

    expect($modifiedBuffer)->not->toContain('disabled="disabled"');
    expect($modifiedBuffer)->toContain('<input type="text" disabled value="Hello">');
});

it('should elide selected attributes from the given buffer', function () {
    $elideAttributes = new ElideAttributes();

    $buffer = '<select>
                    <option value="">Select option</option>
                    <option value="1" selected="selected">Option 1</option>
                    <option value="2">Option 2</option>
                </select>';

    $modifiedBuffer = $elideAttributes->apply($buffer);

    expect($modifiedBuffer)->not->toContain('selected="selected"');
    expect($modifiedBuffer)->toContain('<option value="">Select option</option>');
    expect($modifiedBuffer)->toContain('<option value="1" selected>Option 1</option>');
    expect($modifiedBuffer)->toContain('<option value="2">Option 2</option>');
});
