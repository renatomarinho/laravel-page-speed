<?php

declare(strict_types=1);

namespace DotNinth\LaravelTachyon\Middleware;

class CollapseWhitespace extends PageSpeed
{
    /**
     * Regular expressions used for whitespace collapsing
     *
     * @var array<string,string>
     */
    protected array $regexps = [
        "/\n([\S])/" => '$1', // Remove newlines that are followed by a non-whitespace character
        "/\r/" => '', // Remove carriage returns
        "/\n/" => '', // Remove remaining newlines
        "/\t/" => '', // Remove tabs
        '/ +/' => ' ', // Replace multiple spaces with a single space
        '/> +</' => '><', // Remove spaces between HTML tags
    ];

    /**
     * Elements to ignore when collapsing whitespace
     *
     * @var array<string>
     */
    protected array $ignoreElements = [
        'pre',
        'textarea',
        'script',
    ];

    /**
     * Elements that were skipped during whitespace collapsing
     *
     * @var array<string,string>
     */
    protected array $skippedElements = [];

    /**
     * Apply the whitespace collapsing to the given buffer
     *
     * @param  string  $buffer The input buffer to apply transformations to
     * @return string The transformed buffer
     */
    public function apply(string $buffer): string
    {
        $buffer = $this->removeComments($buffer);
        $buffer = $this->hideElements($buffer);
        $buffer = $this->replace($this->regexps, $buffer);

        return $this->restoreSkippedElements($buffer);
    }

    /**
     * Remove comments from a given buffer
     *
     * @param  string  $buffer The buffer to remove comments from
     * @return string The updated buffer without comments
     */
    protected function removeComments(string $buffer): string
    {
        return (new RemoveComments())->apply($buffer);
    }

    /**
     * Hide elements in the given buffer
     *
     * @param  string  $buffer The buffer to hide elements in
     * @return string The buffer with hidden elements
     */
    protected function hideElements(string $buffer): string
    {
        $this->findSkippedElements($buffer);

        return $this->replaceSkippedElements($buffer);
    }

    /**
     * Find and add skipped elements from a given buffer
     *
     * @param  string  $buffer The buffer to search for skipped elements
     */
    protected function findSkippedElements(string $buffer): void
    {
        foreach ($this->ignoreElements as $element) {
            $pattern = '/<' . $element . '[^>]*>(.*)<\/' . $element . '>/Uuis';
            if (preg_match_all($pattern, $buffer, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $this->addSkippedElement($match[1]);
                }
            }
        }
    }

    /**
     * Adds a skipped element to the list
     *
     * @param  string  $element The element to be skipped
     */
    protected function addSkippedElement(string $element): void
    {
        $hash = '#' . md5($element) . '#';
        $this->skippedElements[$hash] = $element;
    }

    /**
     * Replaces the skipped elements in the given buffer
     *
     * @param  string  $buffer The buffer to replace the skipped elements in
     * @return string The modified buffer after replacing the skipped elements
     */
    protected function replaceSkippedElements(string $buffer): string
    {
        if (! empty($this->skippedElements)) {
            return str_replace(array_values($this->skippedElements), array_keys($this->skippedElements), $buffer);
        }

        return $buffer;
    }

    /**
     * Restores the skipped elements in the given buffer
     *
     * @param  string  $buffer The buffer containing the skipped elements
     * @return string The buffer with the skipped elements restored
     */
    protected function restoreSkippedElements(string $buffer): string
    {
        if (! empty($this->skippedElements)) {
            return str_replace(array_keys($this->skippedElements), array_values($this->skippedElements), $buffer);
        }

        return $buffer;
    }
}
