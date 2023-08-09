<?php

declare(strict_types=1);

namespace RenatoMarinho\LaravelPageSpeed\Middleware;

use Illuminate\Support\Collection;

class InsertDNSPrefetch extends PageSpeed
{
    /**
     * Apply the DNS prefetch middleware to the buffer.
     *
     * @param  string  $buffer
     * @return string
     */
    public function apply($buffer)
    {
        $matches = $this->extractUrls($buffer);
        $dnsPrefetch = $this->generateDnsPrefetchLinks($matches);
        $replace = $this->generateReplaceArray($dnsPrefetch);

        return $this->replace($replace, $buffer);
    }

    /**
     * Extract URLs from the buffer.
     */
    private function extractUrls(string $buffer): Collection
    {
        preg_match_all(
            '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            $buffer,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        return collect($matches[0]);
    }

    /**
     * Generate DNS prefetch links from the extracted URLs.
     */
    private function generateDnsPrefetchLinks(Collection $urls): string
    {
        return $urls->map(function ($item) {
            $domain = $this->trimUrl($item[0]);
            $domain = explode('/', str_replace('//', '', $domain));

            return "<link rel=\"dns-prefetch\" href=\"//{$domain[0]}\">";
        })->unique()->implode("\n");
    }

    /**
     * Trim the URL by removing excess slashes and apply any necessary transformations.
     */
    private function trimUrl(string $url): string
    {
        return (new TrimUrls())->apply($url);
    }

    /**
     * Generate the replace array for the buffer replacement.
     */
    private function generateReplaceArray(string $dnsPrefetch): array
    {
        return [
            '#<head>(.*?)#' => "<head>\n{$dnsPrefetch}",
        ];
    }
}
