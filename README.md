# Laravel Tachyon

Simple package to minify HTML output on demand which results in a 35%+ optimization. Laravel Page Speed was created by [Renato Marinho][link-author], and currently maintained by [João Roberto P. Borges][link-maintainer], [Lucas Mesquita Borges][link-maintainer-2] and [Renato Marinho][link-author].

## Installation

> **Requires:**
- **[PHP 8.0+](https://php.net/releases/)**
- **[Laravel 9.0+](https://github.com/laravel/laravel)**

You can install the package via composer:

```sh
composer require dotninth/laravel-tachyon
```

This package supports Laravel [Package Discovery][link-package-discovery].

### Publish configuration file

 `php artisan vendor:publish --provider="DotNinth\LaravelTachyon\ServiceProvider"`

## Do not forget to register middlewares

Next, the `\DotNinth\LaravelTachyon\Middleware\CollapseWhitespace::class` and other middleware must be registered in the kernel, for example:

```php
//app/Http/Kernel.php

protected $middleware = [
    ...
    \DotNinth\LaravelTachyon\Middleware\InlineCss::class,
    \DotNinth\LaravelTachyon\Middleware\ElideAttributes::class,
    \DotNinth\LaravelTachyon\Middleware\InsertDNSPrefetch::class,
    // \DotNinth\LaravelTachyon\Middleware\RemoveComments::class,
    // \DotNinth\LaravelTachyon\Middleware\TrimUrls::class, 
    \DotNinth\LaravelTachyon\Middleware\RemoveQuotes::class,
    \DotNinth\LaravelTachyon\Middleware\CollapseWhitespace::class, // Note: This middleware invokes "RemoveComments::class" before it runs.
    \DotNinth\LaravelTachyon\Middleware\DeferJavascript::class,
]
```

## Middlewares Details

### \DotNinth\LaravelTachyon\Middleware\RemoveComments::class

The **RemoveComments::class** filter eliminates HTML, JS and CSS comments.
The filter reduces the transfer size of HTML files by removing the comments. Depending on the HTML file, this filter can significantly reduce the number of bytes transmitted on the network.

### \DotNinth\LaravelTachyon\Middleware\CollapseWhitespace::class

The **CollapseWhitespace::class** filter reduces bytes transmitted in an HTML file by removing unnecessary whitespace.
This middleware invoke **RemoveComments::class** filter before executation.

> **Note**: Do not register the "RemoveComments::class" filter with it. Because it will be called automatically by "CollapseWhitespace::class"

### \DotNinth\LaravelTachyon\Middleware\RemoveQuotes::class

The **RemoveQuotes::class** filter eliminates unnecessary quotation marks from HTML attributes. While required by the various HTML specifications, browsers permit their omission when the value of an attribute is composed of a certain subset of characters (alphanumerics and some punctuation characters).

Quote removal produces a modest savings in byte count on most pages.

### \DotNinth\LaravelTachyon\Middleware\ElideAttributes::class

The **ElideAttributes::class** filter reduces the transfer size of HTML files by removing attributes from tags when the specified value is equal to the default value for that attribute. This can save a modest number of bytes, and may make the document more compressible by canonicalizing the affected tags.

### \DotNinth\LaravelTachyon\Middleware\InsertDNSPrefetch::class

The **InsertDNSPrefetch::class** filter Injects <link rel="dns-prefetch" href="//www.example.com"> tags in the HEAD to enable the browser to do DNS prefetching.

DNS resolution time varies from <1ms for locally cached results, to hundreds of milliseconds due to the cascading nature of DNS. This can contribute significantly towards total page load time. This filter reduces DNS lookup time by providing hints to the browser at the beginning of the HTML, which allows the browser to pre-resolve DNS for resources on the page.

 ### ⚠️ \DotNinth\LaravelTachyon\Middleware\TrimUrls::class,

The **TrimUrls::class** filter trims URLs by resolving them by making them relative to the base URL for the page.

> **Warning**: **TrimUrls::class** is considered **medium risk**. It can cause problems if it uses the wrong base URL. This can happen, for example, if you serve HTML that will be pasted verbatim into other HTML pages. If URLs are trimmed on the first page, they will be incorrect for the page they are inserted into. In this case, just disable the middleware.

### \DotNinth\LaravelTachyon\Middleware\InlineCss::class

The **InlineCss::class** filter transforms the inline "style" attribute of tags into classes by moving the CSS to the header.

### \DotNinth\LaravelTachyon\Middleware\DeferJavascript::class

Defers the execution of javascript in the HTML.

> If necessary cancel deferring in some script, use `data-pagespeed-no-defer` as script attribute to cancel deferring.

<hr>

## Configuration

After installing package, you may need to configure some options.

### Disable Service

You would probably like to set up the local environment to get a readable output.

```php
//config/laravel-tachyon.php

//Set this field to false to disable the Laravel Tachyon service.
'enable' => env('LARAVEL_TACHYON_ENABLE', true),
```
### Skip routes

You would probably like to configure the package to skip some routes.

```php
//config/laravel-tachyon.php

//You can use * as wildcard.
'skip' => [
    '*.pdf', //Ignore all routes with final .pdf
    '*/downloads/*',//Ignore all routes that contain 'downloads'
    'assets/*', // Ignore all routes with the 'assets' prefix
];
```

By default this field comes configured with some options, so feel free to configure according to your needs...

> *Notice*: This package skip automatically 'binary' and 'streamed' responses. See [File Downloads][link-file-download].

## Testing

```sh
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-file-download]: https://laravel.com/docs/10.x/responses#file-downloads
[link-package-discovery]: https://laravel.com/docs/10.x/packages#package-discovery
