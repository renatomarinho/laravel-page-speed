<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Blade Minify HTML
    |--------------------------------------------------------------------------    |
    */

    'zlib' => false, // Needs enable zlib module: http://php.net/manual/en/zlib.configuration.php

    'remove' => [
        'comment' => true,
        'breakline' => true,
        'whitespaces' => true,
    ]
];