<?php

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Illuminate\Support\Str;

class InlineCss extends PageSpeed
{
    /**
     * The HTML content.
     *
     * @var string
     */
    private $html = '';

    /**
     * The class attributes extracted from the style tags.
     *
     * @var array
     */
    private $class = [];

    /**
     * The styles extracted from the style tags.
     *
     * @var array
     */
    private $style = [];

    /**
     * The inline CSS styles to be injected.
     *
     * @var array
     */
    private $inline = [];

    /**
     * Apply the inline CSS transformation to the HTML content.
     *
     * @param  string  $buffer the HTML content
     * @return string the transformed HTML content
     */
    public function apply($buffer)
    {
        $this->html = $buffer;

        preg_match_all('#style="(.*?)"#', $this->html, $matches, PREG_OFFSET_CAPTURE);

        $this->class = collect($matches[1])->mapWithKeys(function ($item) {
            return ['page_speed_' . Str::random() => $item[0]];
        })->unique();

        return $this->injectStyle()->injectClass()->fixHTML()->html;
    }

    /**
     * Inject the inline CSS styles into the HTML head section.
     *
     * @return $this
     */
    private function injectStyle()
    {
        collect($this->class)->each(function ($attributes, $class) {
            $this->inline[] = ".{$class} { {$attributes} }";
            $this->style[] = ['class' => $class, 'attributes' => preg_quote($attributes, '/')];
        });

        $injectStyle = implode(' ', $this->inline);
        $this->html = $this->replace(
            ['#</head>(.*?)#' => "\n<style>{$injectStyle}</style>\n</head>"],
            $this->html
        );

        return $this;
    }

    /**
     * Inject the class attributes into the HTML tags.
     *
     * @return $this
     */
    private function injectClass()
    {
        collect($this->style)->each(function ($item) {
            $this->html = $this->replace(
                ['/style="' . $item['attributes'] . '"/' => "class=\"{$item['class']}\""],
                $this->html
            );
        });

        return $this;
    }

    /**
     * Fix the HTML tags with multiple class attributes.
     *
     * @return $this
     */
    private function fixHTML()
    {
        $newHTML = [];
        $tmp = explode('<', $this->html);

        foreach ($tmp as $value) {
            $matches = $this->getClassAttributes($value);
            $newHTML[] = count($matches) > 1 ? $this->replaceMultipleClassAttributes($matches, $value) : $value;
        }

        $this->html = implode('<', $newHTML);

        return $this;
    }

    /**
     * Replaces multiple class attributes in a given string.
     *
     * @param  array  $matches An array of class attributes to be replaced.
     * @param  string  $value The original string to be modified.
     * @return string The modified string with replaced class attributes.
     */
    private function replaceMultipleClassAttributes(array $matches, string $value): string
    {
        $class = implode(' ', $matches);
        $value = $this->replace(['/class="(.*?)"/' => ''], $value);
        $value = $this->replace(['/>/' => 'class="' . $class . '">'], $value);
        $value = str_replace('  ', ' ', $value);

        return $value;
    }

    /**
     * Retrieves an array of class attributes from a given string.
     *
     * @param  string  $value The string from which to extract class attributes.
     * @return array An array of class attributes.
     */
    private function getClassAttributes(string $value): array
    {
        preg_match_all('/(?<!:)class="(.*?)"/', $value, $matches);

        return $matches[1];
    }
}
