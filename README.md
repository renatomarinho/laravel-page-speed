<p align="center">
    <a href="https://supportukrainenow.org#gh-light-mode-only">
        <img src="./.github/assets/support-ukraine-light.svg" alt="Support Ukraine">
    </a>
    <a href="https://supportukrainenow.org#gh-dark-mode-only">
        <img src="./.github/assets/support-ukraine-dark.svg" alt="Support Ukraine">
    </a>
</p>

<br>

<h1 align="center">
    <a href="https://github.com/ideal-creative-lab/laravel-tachyon#gh-light-mode-only">
        <img src="./.github/assets/laravel-tachyon-light.svg" alt="Laravel Tachyon">
    </a>
    <a href="https://github.com/ideal-creative-lab/laravel-tachyon#gh-dark-mode-only">
        <img src="./.github/assets/laravel-tachyon-dark.svg" alt="Laravel Tachyon">
    </a>
</h1>

<p align="center">
    <i align="center"></i>
</p>

<h4 align="center">
    <img src="http://poser.pugx.org/ideal-creative-lab/laravel-tachyon/v?style=for-the-badge" alt="Latest Stable Version">
    <img src="http://poser.pugx.org/ideal-creative-lab/laravel-tachyon/require/php?style=for-the-badge" alt="PHP Version Require">
    <img src="http://poser.pugx.org/ideal-creative-lab/laravel-tachyon/license?style=for-the-badge" alt="License">
</h4>

## Introduction

Laravel Tachyon is a powerful package designed to optimize the performance of your Laravel applications by minifying HTML output on demand. With over 35% optimization, it helps improve page load speed and overall user experience.

## Getting Started

### Requirements
- **[PHP 8.0+](https://php.net/releases/)**
- **[Laravel 9.0+](https://github.com/laravel/laravel)**
### Installation

You can install the package via composer:

```zsh
composer require ideal-creative-lab/laravel-tachyon
```

This package supports Laravel [Package Discovery][link-package-discovery].

#### Publish configuration file

To customize the package settings, you can publish the configuration file with the following command:

```zsh
php artisan vendor:publish --provider="IdealCreativeLab\LaravelTachyon\ServiceProvider"
```

### Middleware Registration

To enable the package functionality, make sure to register the provided middlewares in the kernel of your Laravel application. Here's an example of how to do it:

```php
// app/Http/Kernel.php

protected $middleware = [
    ...
    \IdealCreativeLab\LaravelTachyon\Middleware\InlineCss::class,
    \IdealCreativeLab\LaravelTachyon\Middleware\ElideAttributes::class,
    \IdealCreativeLab\LaravelTachyon\Middleware\InsertDNSPrefetch::class,
    \IdealCreativeLab\LaravelTachyon\Middleware\RemoveQuotes::class,
    \IdealCreativeLab\LaravelTachyon\Middleware\CollapseWhitespace::class,
    \IdealCreativeLab\LaravelTachyon\Middleware\DeferJavascript::class,
]
```

## Middlewares Details

- `RemoveComments::class`: Removes HTML, JS, and CSS comments from the output to reduce the transfer size of HTML files.
- `CollapseWhitespace::class`: Reduces the size of HTML files by removing unnecessary white space. **It automatically calls the `RemoveComments::class` middleware before executing.**
- ``RemoveQuotes::class`: Removes unnecessary quotes from HTML attributes, resulting in a reduced byte count on most pages.
- `ElideAttributes::class`: Reduces the transfer size of HTML files by removing attributes from tags if their values match the default attribute values.
- `InsertDNSPrefetch::class`': Includes `<link rel="dns-prefetch" href="//www.example.com">` tags in the HTML `<head>` section to enable DNS prefetching, reducing DNS lookup time and improving page load times.
- `TrimUrls::class`: Trims URLs by making them relative to the base URL of the page. This can help reduce the size of URLs and may improve performance.
  - **⚠️ Note: Use this middleware with care, as it can cause problems if the wrong base URL is used.**
- `InlineCss::class`: Transforms the inline `style` attribute of HTML tags into classes by moving the CSS into the `<head>` section, improving page rendering and reducing the number of browser requests.
- `DeferJavascript::class`: Defers the execution of JavaScript code in HTML, prioritizing the rendering of critical content before executing JavaScript.
  - If necessary cancel deferring in some script, use `data-tachyon-no-defer` as script attribute to cancel deferring.

### \IdealCreativeLab\LaravelTachyon\Middleware\RemoveComments::class

The **RemoveComments::class** filter eliminates HTML, JS and CSS comments.
The filter reduces the transfer size of HTML files by removing the comments. Depending on the HTML file, this filter can significantly reduce the number of bytes transmitted on the network.

### \IdealCreativeLab\LaravelTachyon\Middleware\CollapseWhitespace::class

The **CollapseWhitespace::class** filter reduces bytes transmitted in an HTML file by removing unnecessary whitespace.
This middleware invoke **RemoveComments::class** filter before executation.

> **Note**: Do not register the "RemoveComments::class" filter with it. Because it will be called automatically by "CollapseWhitespace::class"

### \IdealCreativeLab\LaravelTachyon\Middleware\RemoveQuotes::class

The **RemoveQuotes::class** filter eliminates unnecessary quotation marks from HTML attributes. While required by the various HTML specifications, browsers permit their omission when the value of an attribute is composed of a certain subset of characters (alphanumerics and some punctuation characters).

Quote removal produces a modest savings in byte count on most pages.

### \IdealCreativeLab\LaravelTachyon\Middleware\ElideAttributes::class

The **ElideAttributes::class** filter reduces the transfer size of HTML files by removing attributes from tags when the specified value is equal to the default value for that attribute. This can save a modest number of bytes, and may make the document more compressible by canonicalizing the affected tags.

### \IdealCreativeLab\LaravelTachyon\Middleware\InsertDNSPrefetch::class

The **InsertDNSPrefetch::class** filter Injects <link rel="dns-prefetch" href="//www.example.com"> tags in the HEAD to enable the browser to do DNS prefetching.

DNS resolution time varies from <1ms for locally cached results, to hundreds of milliseconds due to the cascading nature of DNS. This can contribute significantly towards total page load time. This filter reduces DNS lookup time by providing hints to the browser at the beginning of the HTML, which allows the browser to pre-resolve DNS for resources on the page.

 ### ⚠️ \IdealCreativeLab\LaravelTachyon\Middleware\TrimUrls::class,

The **TrimUrls::class** filter trims URLs by resolving them by making them relative to the base URL for the page.

> **Warning**: **TrimUrls::class** is considered **medium risk**. It can cause problems if it uses the wrong base URL. This can happen, for example, if you serve HTML that will be pasted verbatim into other HTML pages. If URLs are trimmed on the first page, they will be incorrect for the page they are inserted into. In this case, just disable the middleware.

### \IdealCreativeLab\LaravelTachyon\Middleware\InlineCss::class

The **InlineCss::class** filter transforms the inline "style" attribute of tags into classes by moving the CSS to the header.

### \IdealCreativeLab\LaravelTachyon\Middleware\DeferJavascript::class

Defers the execution of javascript in the HTML.

> If necessary cancel deferring in some script, use `data-tachyon-no-defer` as script attribute to cancel deferring.

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
