<?php

declare(strict_types=1);

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RenatoMarinho\LaravelPageSpeed\Entities\HtmlSpecs;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class PageSpeed
{
    /**
     * Regular expression pattern for void tags
     */
    const VOID_TAGS_PATTERN = '/\<\s*(%tags)[^>]*\>/';

    /**
     * Regular expression pattern for normal tags with content
     */
    const NORMAL_TAGS_PATTERN = '/\<\s*(%tags)[^>]*\>((.|\n)*?)\<\s*\/\s*(%tags)\>/';

    /**
     * Indicates if PageSpeed middleware is enabled or not
     *
     * @var bool|null
     */
    protected static $isEnabled;

    /**
     * Apply the PageSpeed transformations to the HTML buffer
     *
     * @param  string  $buffer The HTML buffer
     * @return string The transformed HTML buffer
     */
    abstract public function apply(string $buffer): string;

    /**
     * Handle an incoming request
     *
     * @param  \Illuminate\Http\Request  $request HTTP request
     * @param  \Closure  $next The next middleware
     * @return \Illuminate\Http\Response $response The response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldProcessPageSpeed($request, $response)) {
            return $response;
        }

        $html = $response->getContent();
        $newContent = $this->apply($html);

        return $response->setContent($newContent);
    }

    /**
     * Replace patterns in the buffer using preg_replace
     *
     * @param  array  $replace The patterns to replace
     * @param  string  $buffer The buffer to replace patterns in
     * @return string The buffer with patterns replaced
     */
    protected function replace(array $replace, string $buffer): string
    {
        return preg_replace(array_keys($replace), array_values($replace), $buffer);
    }

    /**
     * Check if PageSpeed middleware is enabled
     *
     * @return bool True if PageSpeed middleware is enabled, false otherwise
     */
    protected function isEnabled(): bool
    {
        if (! is_null(static::$isEnabled)) {
            return static::$isEnabled;
        }

        static::$isEnabled = (bool) config('laravel-page-speed.enable', true);

        return static::$isEnabled;
    }

    /**
     * Check if PageSpeed should process the request and response
     *
     * @param  Request  $request The HTTP request
     * @param  Response|BinaryFileResponse|StreamedResponse  $response The HTTP response
     * @return bool True if PageSpeed should process the request and response, false otherwise
     */
    protected function shouldProcessPageSpeed(
        Request $request,
        Response|BinaryFileResponse|StreamedResponse $response
    ): bool {
        if (! $this->isEnabled()) {
            return false;
        }

        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            return false;
        }

        $patterns = config('laravel-page-speed.skip', []);

        return ! $request->is($patterns);
    }

    /**
     * Match all HTML tags in the buffer
     *
     * @param  array  $tags The HTML tags to match
     * @param  string  $buffer The HTML buffer
     * @return array The matched HTML tags
     */
    protected function matchAllHtmlTag(array $tags, string $buffer): array
    {
        $voidTags = array_intersect($tags, HtmlSpecs::voidElements());
        $normalTags = array_diff($tags, $voidTags);

        return array_merge(
            $this->matchTags($voidTags, self::VOID_TAGS_PATTERN, $buffer),
            $this->matchTags($normalTags, self::NORMAL_TAGS_PATTERN, $buffer)
        );
    }

    /**
     * Matches tags in the given buffer against a pattern
     *
     * @param  array  $tags The tags to match
     * @param  string  $pattern The pattern to match against
     * @param  string  $buffer The buffer to search in
     * @return array The matched tags
     */
    protected function matchTags(array $tags, string $pattern, string $buffer): array
    {
        if (empty($tags)) {
            return [];
        }

        $normalizedPattern = str_replace('%tags', implode('|', $tags), $pattern);

        preg_match_all($normalizedPattern, $buffer, $matches);

        return $matches[0];
    }

    /**
     * Replaces the specified content inside HTML tags with a given replacement string
     *
     * @param  array  $tags The HTML tags to match
     * @param  string  $regex The regular expression pattern to match the content inside the HTML tags
     * @param  string  $replace The replacement string to use
     * @param  string  $buffer The HTML content to search and replace within
     * @return string The modified HTML content
     */
    protected function replaceInsideHtmlTags(array $tags, string $regex, string $replace, string $buffer): string
    {
        foreach ($this->matchAllHtmlTag($tags, $buffer) as $tagMatched) {
            preg_match_all($regex, $tagMatched, $contentsMatched);

            $tagAfterReplace = str_replace($contentsMatched[0], $replace, $tagMatched);
            $buffer = str_replace($tagMatched, $tagAfterReplace, $buffer);
        }

        return $buffer;
    }
}
