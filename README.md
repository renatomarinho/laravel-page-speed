# Laravel Blade Minify

### Simple package to minify HTML on demand and reduces more than 35% file size.

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
