<?php

declare(strict_types=1);

namespace DotNinth\LaravelTachyon\Middleware;

use DotNinth\LaravelTachyon\Entities\HtmlSpecs;

class RemoveQuotes extends PageSpeed
{
    /**
     * Remove quotes from attribute values in the given buffer
     *
     * @param  string  $buffer The input buffer to apply transformations to
     * @return string The resulting buffer after applying transformations
     */
    public function apply(string $buffer): string
    {
        $buffer = $this->replaceInsideHtmlTags(HtmlSpecs::voidElements(), '/\/>/', '>', $buffer);

        return $this->replace([
            '/ src="(.\S*?)"/' => ' src=$1',
            '/ width="(.\S*?)"/' => ' width=$1',
            '/ height="(.\S*?)"/' => ' height=$1',
            '/ name="(.\S*?)"/' => ' name=$1',
            '/ charset="(.\S*?)"/' => ' charset=$1',
            '/ align="(.\S*?)"/' => ' align=$1',
            '/ border="(.\S*?)"/' => ' border=$1',
            '/ crossorigin="(.\S*?)"/' => ' crossorigin=$1',
            '/ type="(.\S*?)"/' => ' type=$1',
        ], $buffer);
    }
}
