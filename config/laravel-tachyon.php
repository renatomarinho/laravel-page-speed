<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Laravel Tachyon
    |--------------------------------------------------------------------------
    |
    | Set this field to false to disable the Laravel Tachyon service.
    | You would probably replace that in your local configuration to get a readable output.
    |
    */
    'enable' => env('LARAVEL_TACHYON_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Skip Routes
    |--------------------------------------------------------------------------
    |
    | Skip Routes paths to exclude.
    | You can use * as wildcard.
    |
    */
    'skip' => [
        '*.xml',
        '*.less',
        '*.pdf',
        '*.doc',
        '*.txt',
        '*.ico',
        '*.rss',
        '*.zip',
        '*.mp3',
        '*.rar',
        '*.exe',
        '*.wmv',
        '*.doc',
        '*.avi',
        '*.ppt',
        '*.mpg',
        '*.mpeg',
        '*.tif',
        '*.wav',
        '*.mov',
        '*.psd',
        '*.ai',
        '*.xls',
        '*.mp4',
        '*.m4a',
        '*.swf',
        '*.dat',
        '*.dmg',
        '*.iso',
        '*.flv',
        '*.m4v',
        '*.torrent',
    ],
];
