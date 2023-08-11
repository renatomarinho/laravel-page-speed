<?php

declare(strict_types=1);

namespace IdealCreativeLab\LaravelTachyon\Entities;

class HtmlSpecs
{
    /**
     * Return an array of void elements
     */
    public static function voidElements(): array
    {
        return [
            'area',
            'base',
            'br',
            'col',
            'embed',
            'hr',
            'img',
            'input',
            'link',
            'meta',
            'param',
            'source',
            'track',
            'wbr',
        ];
    }
}
