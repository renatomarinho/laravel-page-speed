<?php

declare(strict_types=1);

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class RemoveComments extends PageSpeed
{
    /**
     * Regular expression pattern to match JavaScript and CSS comments
     */
    public const REGEX_MATCH_JS_AND_CSS_COMMENTS = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/';

    /**
     * Regular expression pattern to match HTML comments, excluding Livewire comments
     */
    public const REGEX_MATCH_HTML_COMMENTS = '/<!--[^]><!\[](?!Livewire)(.*?)[^\]]-->/s';

    /**
     * Applies the remove comments functionality to the given buffer.
     *
     * @param  string  $buffer The input buffer
     * @return string The buffer with comments removed
     */
    public function apply(string $buffer): string
    {
        $buffer = $this->replaceInsideHtmlTags(['script', 'style'], self::REGEX_MATCH_JS_AND_CSS_COMMENTS, '', $buffer);

        $replaceHtmlRules = [
            self::REGEX_MATCH_HTML_COMMENTS => '',
        ];

        return $this->replace($replaceHtmlRules, $buffer);
    }
}
