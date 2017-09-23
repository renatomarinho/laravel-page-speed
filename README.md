# Laravel Page Speed

[![Laravel 5.3](https://img.shields.io/badge/Laravel-5.3-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Laravel 5.5](https://img.shields.io/badge/Laravel-5.5-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Total Downloads](https://poser.pugx.org/renatomarinho/laravel-page-speed/downloads)](https://packagist.org/packages/renatomarinho/laravel-page-speed)

### Simple package to minify HTML output on demand which results on a 35%+ optimization.

## Installation is easy

You can install the package via composer:

```bash
$ composer require renatomarinho/laravel-page-speed
```

Next, the \RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace::class and others - middleware must be registered in the kernel:

```php
//app/Http/Kernel.php

protected $middleware = [
    ...
    \RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace::class,
    \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments::class,
    \RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls::class,
    \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes::class,
]
```

#### Before

![Before of Laravel Page Speed](https://i.imgur.com/cN3MWYh.png)

#### After

![After of Laravel Page Speed](https://i.imgur.com/IKWKLkL.png)

## Roadmap : Filters

<table>
    <tr>
        <td><strong>Name</strong></td>
        <td><strong>Description</strong></td>
        <td><strong>Available</strong></td>
    <tr>
    <tr>
        <td>remove_quotes</td>
        <td>Removes unnecessary quotes in HTML tags</td>
        <td>YES</td>
    <tr>
    <tr>
        <td>trim_urls</td>
        <td>Removes unnecessary prefixes from URLs</td>
        <td>YES</td>
    <tr>
    <tr>
        <td>collapse_whitespace</td>
        <td>Removes unnecessary whitespace in HTML</td>
        <td>YES</td>
    <tr>
    <tr>
        <td>remove_comments</td>
        <td>Removes HTML comments</td>
        <td>YES</td>
    <tr>
    <tr>
        <td>combine_css</td>
        <td>Combines multiple CSS files into one</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>combine_heads</td>
        <td>Combines multiple <head> elements into one</td>
        <td>NO</td>
    <tr> 
    <tr>
        <td>combine_javascript</td>
        <td>Combines multiple JavaScript files into one</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>dedup_inlined_images</td>
        <td>Replaces repeated inlined images with JavaScript that loads the data from the first instance of the image</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>defer_javascript</td>
        <td>Defers the execution of javascript in the HTML</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>elide_attributes</td>
        <td>Removes unnecessary attributes in HTML tags</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>pedantic</td>
        <td>Adds default type attributes to script and style tags that are missing them</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>extend_cache</td>
        <td>Improves cacheability</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>fallback_rewrite_css_urls</td>
        <td>Rewrite URLs in CSS even if CSS is not parseable</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>flatten_css_imports</td>
        <td>Flattens @import rules in CSS by replacing the rule with the contents of the imported resource</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>hint_preload_subresources</td>
        <td>Inserts link: headers to preload CSS and JavaScript resources</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>inline_css</td>
        <td>Inlines small external CSS files</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>inline_google_font_css</td>
        <td>Inlines small font-loading CSS from Google Fonts API</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>inline_import_to_link</td>
        <td>Inlines style tags comprising only CSS @imports by converting them to an equivalent link</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>inline_javascript</td>
        <td>Inlines small external Javascript files</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>inline_preview_images</td>
        <td>Delays original images; serves inlined, low-quality placeholder images until originals are loaded</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>insert_dns_prefetch</td>
        <td>Injects <link rel="dns-prefetch" href="//www.example.com"> tags in the HEAD to enable the browser to do DNS prefetching</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>insert_ga</td>
        <td>Inserts Google Analytics javascript snippet</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>lazyload_images</td>
        <td>Loads images when they become visible in the client viewport</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>local_storage_cache</td>
        <td>Loads inlined CSS and image resources into HTML5 local storage whence the client fetches them subsequently rather than the server sending them again</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>make_show_ads_async</td>
        <td>Converts synchronous Google AdSense tags to asynchronous format</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>make_google_analytics_async</td>
        <td>Converts synchronous Google Analytics code to load asynchronously</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>move_css_above_scripts</td>
        <td>Moves CSS Above Scripts</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>move_css_to_head</td>
        <td>Moves CSS into the <head> element</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>outline_css</td>
        <td>Moves large inline <style> tags into external files for cacheability</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>outline_javascript</td>
        <td>Moves large inline <script> tags into external files for cacheability</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>prioritize_critical_css</td>
        <td>Instruments the page, inlines its critical CSS at the top, and lazily loads the rest</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>resize_mobile_images</td>
        <td>Just like inline_preview_images, but uses smaller placeholder images for mobile browsers</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>resize_rendered_image_dimensions</td>
        <td>Resize images to rendered dimensions</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>responsive_images</td>
        <td>Serve responsive images using the srcset attribute</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>rewrite_css</td>
        <td>Minifies CSS</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>rewrite_images</td>
        <td>Rescales, and compresses images; inlines small ones</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>rewrite_javascript</td>
        <td>Minifies Javascript</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>rewrite_style_attributes</td>
        <td>Rewrite the CSS in style attributes by applying the configured rewrite_css filter to it</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>rewrite_style_attributes_with_url</td>
        <td>Rewrite the CSS in style attributes by applying the configured rewrite_css filter to it, but only if the attribute contains the text 'url('</td>
        <td>NO</td>
    <tr>
    <tr>
        <td>sprite_images</td>
        <td>Sprites images</td>
        <td>NO</td>
    <tr>
    
</table>

<hr />

## Inspiration 

#### Mod Page Speed (https://www.modpagespeed.com/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
