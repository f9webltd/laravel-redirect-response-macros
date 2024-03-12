![](https://banners.beyondco.de/Laravel%20Redirect%20Response%20Macros.png?theme=light&packageManager=composer+require&packageName=f9webltd%2Flaravel-redirect-response-macros&pattern=brickWall&style=style_1&description=Some+super+useful+redirect+response+macros+to+simplify+your+Laravel+application&md=1&showWatermark=0&fontSize=100px&images=code)


[![Packagist Version](https://img.shields.io/packagist/v/f9webltd/laravel-redirect-response-macros?style=flat-square)](https://packagist.org/packages/f9webltd/laravel-redirect-response-macros)
[![Run Tests](https://github.com/f9webltd/laravel-redirect-response-macros/actions/workflows/run-tests.yml/badge.svg?branch=master)](https://github.com/f9webltd/laravel-redirect-response-macros/actions/workflows/run-tests.yml)
[![StyleCI Status](https://github.styleci.io/repos/278581318/shield)](https://github.styleci.io/repos/278581318)
[![Packagist License](https://img.shields.io/packagist/l/f9webltd/laravel-redirect-response-macros?style=flat-square)](https://packagist.org/packages/f9webltd/laravel-redirect-response-macros)

# Laravel Redirect Response Macros

Some super useful redirect response macros to simplify your Laravel application.

## Requirements

- PHP `^8.0`
- Laravel `^8.12`, `^9.0`, `^10.0` or `^11.0`

### Legacy Support

For legacy PHP / Laravel support, use package version [`1.1.6`](https://github.com/f9webltd/laravel-redirect-response-macros/tree/1.1.6)

## Installation

``` bash
composer require f9webltd/laravel-redirect-response-macros
```

The package will automatically register itself.

Optionally publish language files by running: `php artisan vendor:publish` and selecting the appropriate package.

## Documentation

This package allows for concise controller redirections by setting default flash data. It works as Laravels `RedirectResponse` class is "macroable".

For example the packages allows:

``` php
public function store(FormRequest $request)
{
    // create record ...
    return redirect()->route('posts.index')->created();
}
```

... instead of:

``` php
public function store(FormRequest $request)
{
    // create record ...
    return redirect()->route('posts.index')->with('success', 'The record was successfully created');
}
```

The former is of course much more concise and readable.

The package specifies several custom `RedirectResponse` macros that can be used on any of the native Laravel helpers that return the redirect response object.

The following methods are available.

#### `success()`

Flash message key: `success`  
Pass a message string to the macros.

``` php
public function update(FormRequest $request, $id)
{
    return back()->success('Everything is great!');
}
```

#### `info()`

Flash message key: `info`  
Pass a message string to the macros.

``` php
public function update(FormRequest $request, $id)
{
    return back()->info('Some information ...');
}
```

#### `danger()`

Flash message key: `danger`  
Pass a message string to the macros.

``` php
public function update(FormRequest $request, $id)
{
    return back()->danger('That action just is impossible!');
}
```

#### `warning()`

Flash message key: `warning`  
Pass a message string to the macros.

``` php
public function update(FormRequest $request, $id)
{
    return back()->warning('This could be risky ...');
}
```

There are further helper method available, that set the same type of flash data, but in a more readable manner:

#### `created()`

Flash message key: `success`  
Default message: `The record was successfully created`

``` php
public function store(FormRequest $request)
{
    // create record ...
    return redirect()->route('posts.index')->created();
}
```

Alternatively pass a url to display an message with a link to view the created record:

``` php
public function store(FormRequest $request)
{
    // create record ...
    return redirect()->route('posts.index')->created(
      route('posts.edit', $post)
    );
}
```

The flashed message will now be: `The record was successfully created. <a href="/posts/1/edit" class="alert-link">View inserted record</a>`.

#### `updated()`

Flash message key: `success`  
Default message: `The record was successfully updated`

``` php
public function update(FormRequest $requestm int $id)
{
    // update record ...
    return back()->updated();
}
```

To set a custom message, pass the desired text to the `updated()` function.

#### `deleted()`

Flash message key: `success`  
Default message: `The record was successfully deleted`

``` php
public function update(Post $post)
{
    $posts->delete();

    return redirect()->route('posts.index')->deleted();
}
```

To set a custom message, pass the desired text to the `deleted()` function.

#### `error()`

Flash message key: `error`  
Specific message text should be passed.

``` php
public function index()
{
    // code ...
    return redirect()->route('dashboard')->error('You cannot do this thing!');
}
```

The function can detect the presence of exception object and call `getMessage()` as required:

``` php
public function index()
{
    try {
        $service->run();
    } catch (Exception $e) {
        return redirect()->route('dashboard')->error($e)
    }
}
```

#### `errorNotFound()`

Works in the same way as the `error()` macro and is intended to make controllers more concise. 

The default message is `Sorry, the record could not be found.`.

#### `authorized()`

Flash message key: `success`  
Default message: `Welcome back, you have been securely logged in`

A custom message can optionally be provided.

#### `unAuthorized()`

Works in the same way as the `error()` macro and is intended to make controllers more concise. 

The default message is `You do not have permission to perform that action`.

## IDE Autocompletion within PHPStorm

Autocompletion of "macroable" classes with PHPStorm currently difficult, which is a shame given how useful macroable classes actually are.

At present, the following process will trigger autocompletion in PHPStorm:

- Copy [resources/_ide_helper_macros.php](resources/_ide_helper_macros.php) to a location within your project to allow PHP storm to index the additional class methods
- Optionally add `_ide_helper_macros.php` to your `.gitignore` file

## Contribution

Any ideas are welcome. Feel free to submit any issues or pull requests.

## Testing

``` bash
composer test
```

## Security

If you discover any security related issues, please email rob@f9web.co.uk instead of using the issue tracker.

## Credits

- [Rob Allport](https://github.com/ultrono) for [F9 Web Ltd.](https://www.f9web.co.uk)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

