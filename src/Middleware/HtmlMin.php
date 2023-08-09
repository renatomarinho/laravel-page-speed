<?php

declare(strict_types=1);

namespace Abordage\HtmlMin;

class HtmlMin
{
    protected bool $findDoctypeInDocument = true;

    protected bool $removeHtmlComments = true;

    protected bool $removeBlankLinesInScriptElements = false;

    protected bool $removeWhitespaceBetweenTags = true;

    protected array $ignoreElements = [
        'pre',
        'textarea',
        'script',
    ];

    protected array $skippedElements = [];

    public function findDoctypeInDocument(bool $enable = true): HtmlMin
    {
        $this->findDoctypeInDocument = $enable;

        return $this;
    }

    public function removeBlankLinesInScriptElements(bool $enable = true): HtmlMin
    {
        $this->removeBlankLinesInScriptElements = $enable;

        return $this;
    }

    public function removeWhitespaceBetweenTags(bool $enable = true): HtmlMin
    {
        $this->removeWhitespaceBetweenTags = $enable;

        return $this;
    }

    public function minify(string $html): string
    {
        if ($this->findDoctypeInDocument && $this->doctypeNotFound($html)) {
            return $html;
        }

        if ($this->removeHtmlComments) {
            $html = $this->removeHtmlComments($html);
        }

        if ($this->removeBlankLinesInScriptElements) {
            $html = $this->trimScriptElements($html);
        }

        $html = $this->collapseWhitespaces($html);

        return trim($html);
    }

    protected function doctypeNotFound(string $html): bool
    {
        $string = substr(trim($html), 0, 100);

        return stripos($string, '<!DOCTYPE') === false;
    }

    protected function removeHtmlComments(string $html): string
    {
        return (string) preg_replace('~<!--[^]><!\[](?!Livewire)(.*?)[^]]-->~s', '', $html);
    }

    protected function trimScriptElements(string $html): string
    {
        if (preg_match_all('~<script[^>]*>(.*)</script>~Uuis', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $replace = trim((string) preg_replace('~^\p{Z}+|\p{Z}+$|^\s+~m', '', $match[1]));
                $html = str_replace($match[1], $replace, $html);
            }
        }

        return $html;
    }

    protected function collapseWhitespaces(string $html): string
    {
        $html = $this->hideElements($html);

        $whitespaceCollapses = [
            '~\s+~u' => ' ',
        ];

        if ($this->removeWhitespaceBetweenTags) {
            $regexes = [
                '~> +<~' => '><',
                '~(<[a-z]+[^>]*>) +~i' => '$1',
                '~ +(</[a-z]+)~i' => '$1',
            ];
            $whitespaceCollapses = array_merge($whitespaceCollapses, $regexes);
        }

        $html = (string) preg_replace(array_keys($whitespaceCollapses), array_values($whitespaceCollapses), $html);

        return $this->restoreElements($html);
    }

    protected function hideElements(string $html): string
    {
        foreach ($this->ignoreElements as $element) {
            $pattern = '~<' . $element . '[^>]*>(.*)</' . $element . '>~Uuis';
            if (preg_match_all($pattern, $html, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $this->skippedElements['#' . md5($match[1]) . '#'] = $match[1];
                }
            }
        }
        if (count($this->skippedElements)) {
            $html = str_replace(array_values($this->skippedElements), array_keys($this->skippedElements), $html);
        }

        return $html;
    }

    protected function restoreElements(string $html): string
    {
        if (count($this->skippedElements)) {
            return str_replace(array_keys($this->skippedElements), array_values($this->skippedElements), $html);
        }

        return $html;
    }
}
