<?php

declare(strict_types=1);

namespace DotNinth\LaravelPageSpeed\Middleware;

class ElideAttributes extends PageSpeed
{
    /**
     * Elide attributes from the given buffer
     *
     * @param  string  $buffer The input buffer to apply transformations to
     * @return string The resulting buffer after applying transformations
     */
    public function apply(string $buffer): string
    {
        return $this->replace([
            '/ method=("get"|get)/' => '',
            '/ disabled=[^ >]*(.*?)/' => ' disabled',
            '/ selected=[^ >]*(.*?)/' => ' selected',
        ], $buffer);
    }
}
