<?php

namespace App\Http\Middleware;

use RenatoMarinho\LaravelPageSpeed\Middleware\PageSpeed;

class CollapseWhitespace extends PageSpeed
{

    const REPLACEMENT = [
        "/\n([\S])/" => '$1',
        "/\r/"       => '',
        "/\n+/"      => '',
        "/\t/"       => '',
        '/ +/'       => ' ',
        '/> +</'     => '><',
    ];

    protected $_ignoreElements = [
        'pre',
        'textarea',
        'style',
        'script'
    ];

    /** @var string[][] */
    protected $skippedElements = [];

    /** @var string */
    protected $key;

    /**
     * CollapseWhitespace constructor
     */
    public function __construct()
    {
        $this->key = md5(random_int(0, 100) . date('d.m.Y H:i:s')) . '-';
    }

    /**
     * Apply replacement
     *
     * @param string $buffer
     * @return string
     */
    public function apply($buffer)
    {
        $buffer = $this->preReplaceChange($buffer);

        $buffer = $this->replace(self::REPLACEMENT, $buffer);

        $buffer = $this->postReplaceChange($buffer);

        return $buffer;
    }

    /**
     * Perform pre-replace changes
     *
     * @param string $buffer
     * @return string
     */
    protected function preReplaceChange($buffer)
    {
        foreach($this->_ignoreElements as $element){
            $buffer = $this->prepare($buffer, $element);
        }

        return $buffer;
    }

    /**
     * Perform post-replace changes
     *
     * @param string $buffer
     * @return string
     */
    protected function postReplaceChange($buffer)
    {
        foreach($this->_ignoreElements as $element){
            $buffer = $this->recover($buffer, $element);
        }
        return $buffer;
    }

    /**
     * Cut <textarea> content to prevent minification
     *
     * @param string $buffer
     * @param string $element
     *
     * @return string
     */
    protected function prepare($buffer, $element)
    {
        preg_match_all("#\<{$element}.*\>.*\<\/{$element}\>#Uis", $buffer, $foundTxt);

        $this->skippedElements[$element] = isset($foundTxt[0])? $foundTxt[0] : [];

        return str_replace(
            $this->skippedElements[$element],
            array_map(function ($el) use($element) {
                return "<{$element}>{$this->key}{$el}</{$element}>";
            }, array_keys($this->skippedElements[$element])),
            $buffer
        );
    }

    /**
     * Revert original <textarea> content to view
     *
     * @param string $buffer
     * @param string $element
     *
     * @return string
     */
    protected function recover($buffer, $element)
    {
        return str_replace(
            array_map(function ($el) use($element) {
                return "<{$element}>{$this->key}{$el}</{$element}>";
            }, array_keys($this->skippedElements[$element])),
            $this->skippedElements[$element],
            $buffer
        );
    }

}
