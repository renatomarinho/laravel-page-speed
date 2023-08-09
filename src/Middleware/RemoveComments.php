<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

class RemoveComments extends PageSpeed
{
    public const REGEX_MATCH_JS_AND_CSS_COMMENTS = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/';

    public const REGEX_MATCH_HTML_COMMENTS = '/<!--[^]><!\[](.*?)[^\]]-->/s';

    public function apply($buffer)
    {
        $buffer = $this->replaceInsideHtmlTags(['script', 'style'], self::REGEX_MATCH_JS_AND_CSS_COMMENTS, '', $buffer);

        $replaceHtmlRules = [
            self::REGEX_MATCH_HTML_COMMENTS => '',
        ];

        return $this->replace($replaceHtmlRules, $buffer);
    }
}
