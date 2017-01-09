# Laravel Helpers

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A set of Laravel-specific helpers. Use each class/trait or register each service provider when needed. Each helper is optional.

## Install

Via Composer

``` bash
$ composer require sebastiaanluca/laravel-helpers
```

## Usage

#### locale

Get the active locale.

``` php
$locale = locale();
```

#### carbonize

Create a Carbon object from a string.

``` php
$time = carbonize('2017-01-18 11:30');
```

#### isActiveRoute

Check if the given route is currently active.
It requires installation of `laravelista/ekko`.

``` php
$result = isActiveRoute('auth/login');
```

#### take

Create a new piped item from a given value.
see the [blog post](https://blog.sebastiaanluca.com/enabling-php-method-chaining-with-a-makeshift-pipe-operator)

``` php
$subdomain = take('https://blog.sebastiaanluca.com/')
               ->pipe('parse_url', PHP_URL_HOST)
               ->pipe('explode', '.', '$$')
               ->pipe('reset')
               ->get();
```

#### rand_bool

Randomly return true or false.

``` php
$bool = rand_bool();
```

#### str_wrap

Wrap a string with another string.

``` php
$quoted = str_wrap('foo', '"');  

// "foo"
```

#### is_assoc_array

Check if an array is associative. (As opposed to numeric.)

``` php
$result = is_assoc_array(['color' => 'blue', 'age' => 31]);  

// true
```

#### public_method_exists

Check if an object has a given public method.

``` php
$car = new Car();
if (public_method_exists($car, 'honk')) {
    $car->honk();
}
```

#### array_expand

Expand a flat dotted array to a multi-dimensional associative array.

``` php
$array = array_expand(['products.desk.price' => 200]);

// ['products' => ['desk' => ['price' => 200]]]
```

#### array_without

Get the array without the given values.

``` php
$cars = ['bmw', 'mercedes', 'audi'];
$soldOut = ['audi', 'bmw'];

$inStock = array_without($cars, $soldOut);

// ['mercedes']
```

#### ddd_if

Only debugs a statement given a truth condition.
Note: Requires a custom `ddd` method.

``` php
ddd_if(app()->environment() == 'local', $var1, $var2, $var3);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hello@sebastiaanluca.com instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sebastiaanluca/laravel-helpers.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sebastiaanluca/laravel-helpers/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sebastiaanluca/laravel-helpers.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sebastiaanluca/laravel-helpers.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sebastiaanluca/laravel-helpers.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-helpers
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-helpers
[link-scrutinizer]: https://scrutinizer-ci.com/g/sebastiaanluca/laravel-helpers/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sebastiaanluca/laravel-helpers
[link-downloads]: https://packagist.org/packages/sebastiaanluca/laravel-helpers
[link-author]: https://github.com/:author_username
[link-contributors]: ../../contributors
