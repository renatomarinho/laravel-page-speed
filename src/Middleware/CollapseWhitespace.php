<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class CollapseWhitespace extends PageSpeed
{
    const REPLACEMENT = [
        "/\n([\S])/" => '$1',
        "/\r/"       => '',
        "/\n/"       => '',
        "/\t/"       => '',
        '/ +/'       => ' ',
        '/> +</'     => '><',
    ];

    /** @var string[] */
    private $preFounds = [];

    /** @var string[] */
    private $textareaFounds = [];

    /** @var string */
    private $key;

    /**
     * CollapseWhitespace constructor
     */
    public function __construct()
    {
        $this->key = \md5(\random_int(0, 100) . \date('d.m.Y H:i:s')).'-';
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
    private function preReplaceChange($buffer)
    {
        $buffer = $this->prepareTextArea($buffer);
        $buffer = $this->preparePre($buffer);

        return $buffer;
    }

    /**
     * Perform post-replace changes
     *
     * @param string $buffer
     * @return string
     */
    private function postReplaceChange($buffer)
    {
        $buffer = $this->recoverTextArea($buffer);
        $buffer = $this->recoverPre($buffer);

        return $buffer;
    }

    /**
     * Cut <textarea> content to prevent minification
     *
     * @param string $buffer
     * @return string
     */
    private function prepareTextArea($buffer)
    {
        \preg_match_all('#\<textarea.*\>.*\<\/textarea\>#Uis', $buffer, $foundTxt);

        $this->textareaFounds = isset($foundTxt[0]) ? $foundTxt[0] : [];

        return \str_replace(
            $this->textareaFounds,
            \array_map(function ($el) {
                return '<textarea>'.$this->key.$el.'</textarea>';
            }, \array_keys($this->textareaFounds)),
            $buffer
        );
    }

    /**
     * Cut <pre> content to prevent minification
     *
     * @param string $buffer
     * @return string
     */
    private function preparePre($buffer)
    {
        \preg_match_all('#\<pre.*\>.*\<\/pre\>#Uis', $buffer, $foundPre);

        $this->preFounds = isset($foundPre[0]) ? $foundPre[0] : [];

        return \str_replace(
            $this->preFounds,
            \array_map(function ($el) {
                return '<pre>'.$this->key.$el.'</pre>';
            }, \array_keys($this->preFounds)),
            $buffer
        );
    }

    /**
     * Revert original <textarea> content to view
     *
     * @param string $buffer
     * @return string
     */
    private function recoverTextArea($buffer)
    {
        return \str_replace(
            \array_map(function ($el) {
                return '<textarea>'.$this->key.$el.'</textarea>';
            }, \array_keys($this->textareaFounds)),
            $this->textareaFounds,
            $buffer
        );
    }

    /**
     * Revert original <pre> content to view
     *
     * @param string $buffer
     * @return string
     */
    private function recoverPre($buffer)
    {
        return \str_replace(
            \array_map(function ($el) {
                return '<pre>'.$this->key.$el.'</pre>';
            }, \array_keys($this->preFounds)),
            $this->preFounds,
            $buffer
        );
    }
}
