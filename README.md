# Laravel Blade Minify

[![Laravel 5.3](https://img.shields.io/badge/Laravel-5.3-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Laravel 5.5](https://img.shields.io/badge/Laravel-5.5-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Total Downloads](https://poser.pugx.org/renatomarinho/laravel-blade-minify/downloads)](https://packagist.org/packages/renatomarinho/laravel-blade-minify)

### Simple package to minify HTML output on demand which results on a 35%+ optimization.

## Instalation is easy

You can install the package via composer:

```bash
$ composer require renatomarinho/laravel-blade-minify
```

Next, the \RenatoMarinho\LaravelBladeMinify\Middleware\Minify::class - middleware must be registered in the kernel:

```php
//app/Http/Kernel.php

protected $middleware = [
    ...
    \RenatoMarinho\LaravelBladeMinify\Middleware\Minify::class
]
```


#### Before

![Before of Laravel Blade Minify](https://i.imgur.com/cN3MWYh.png)

#### After

![After of Laravel Blade Minify](https://i.imgur.com/IKWKLkL.png)


License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
