# Laravel Helpers

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

[![Follow me on Twitter](https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social)](https://twitter.com/sebastiaanluca)
[![Share this package on Twitter](https://img.shields.io/twitter/url/http/shields.io.svg?style=social)](https://twitter.com/home?status=https%3A//github.com/sebastiaanluca/php-stub-generator%20via%20%40sebastiaanluca)

A set of Laravel-specific helpers. Use each class/trait or register each service provider when needed. Each helper is optional.

## Table of contents

* [Requirements](#requirements)
* [Install](#install)
* [Usage](#usage)
    + [Global methods](#global-methods)
      - [locale](#locale)
      - [is_active_route](#is_active_route)
      - [ddd_if](#ddd_if)
      - [carbonize](#carbonize-1)
      - [take (pipe operator)](#take-pipe-operator)
      - [rand_bool](#rand_bool)
      - [str_wrap](#str_wrap)
      - [is_assoc_array](#is_assoc_array)
      - [array_expand](#array_expand)
      - [array_without](#array_without)
      - [array_hash](#array_hash)
      - [object_hash](#object_hash)
      - [public_method_exists](#public_method_exists)
    + [Collection macros](#collection-macros)
      - [Carbonize](#carbonize)
      - [Between](#between)
      - [Methodize](#methodize)
      - [mapWithIntegerKeys](#mapwithintegerkeys)
      - [d](#d)
      - [ddd](#ddd)
      - [transformKeys](#transformkeys)
    + [Classes](#classes)
      - [Constant trait](#constant-trait)
      - [Reflection trait](#reflection-trait)
      - [Method helper](#method-helper)
    + [Database](#database)
      - [Table reader](#table-reader)
    + [Blade helpers](#blade-helpers)
      - [Form date field](#form-date-field)
      - [Bootstrap form errors](#bootstrap-form-errors)
* [Change log](#change-log)
* [Testing](#testing)
* [Contributing](#contributing)
* [Security](#security)
* [Credits](#credits)
* [License](#license)

Table of contents generated with <a href='http://ecotrust-canada.github.io/markdown-toc/'>markdown-toc</a>.

## Requirements

- PHP 7 or higher
- Laravel 5.1 or higher

## Install

Via Composer:

``` bash
composer require sebastiaanluca/laravel-helpers
```

## Usage

### Global methods

#### locale

Get the active locale.

``` php
$locale = locale();
```

#### is_active_route

Check if the given route is currently active.

Note: requires the `laravelista/ekko` package ([https://github.com/laravelista/Ekko]()).

``` php
$result = is_active_route('auth/login');
```

#### ddd_if

Only debugs a statement given a truth condition.

Note: requires the `raveren/kint` debug package (https://github.com/raveren/kint).

``` php
ddd_if(app()->environment() == 'local', $var1, $var2, $var3);
```

#### carbonize

Create a Carbon object from a string.

``` php
$time = carbonize('2017-01-18 11:30');
```

#### take (pipe operator)

Create a new piped item from a given value. See the [blog post](https://blog.sebastiaanluca.com/enabling-php-method-chaining-with-a-makeshift-pipe-operator) for more info.

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

Check if an array is associative (as opposed to numeric).

``` php
$result = is_assoc_array(['color' => 'blue', 'age' => 31]);

// true
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

#### array_hash

Create a unique identifier for a given array.

``` php
$myArray = [
    'akey' => 'somevalue',
    'anotherkey' => 'anothervalue',
];

$hash = array_hash($myArray);

// 80435ac6242e902754a268b6cb4b4c9a

$anotherArray = [
    'keylessvalue',
    'abc',
];

$hash = array_hash($anotherArray);

// 9611ce5a1ab6b60e73e33942a8cf0272
```

#### object_hash

Create a unique identifier for a given object. Similar to [array_hash](#array_hash), this uses `serialize` to stringify all public properties first.

``` php
class ValueObject {
    public $property = 'randomvalue';
}

$hash = object_hash(new ValueObject);

// acceaba779657cdaf00e9c93737d778f
```

#### public_method_exists

Check if an object has a given public method.

``` php
$car = new Car();

if (public_method_exists($car, 'honk')) {
    $car->honk();
}
```

### Collection macros

#### Carbonize

#### Between

#### Methodize

#### mapWithIntegerKeys

#### d

#### ddd

#### transformKeys

#### transpose

#### transposeWithKeys

Flip a collection of rows and values per column so that the columns become rows and the rows become columns.

Before:

|   | id | name  |
|---|----|-------|
| A | 1  | James |
| B | 2  | Joe   |
| C | 3  | Jonas |

After:

|      | A     | B   | C     |
|------|-------|-----|-------|
| id   | 1     | 2   | 3     |
| name | James | Joe | Jonas |

How to use:

```php
collect([
    'A' => [
        'id' => 1,
        'name' => 'James',
    ],
    'B' => [
        'id' => 2,
        'name' => 'Joe',
    ],
    'C' => [
        'id' => 3,
        'name' => 'Jonas',
    ],
])->transposeWithKeys()

// Output (inside a new collection):
//    [
//        'id' => [
//            'A' => 1,
//            'B' => 2,
//            'C' => 3,
//        ],
//        'name' => [
//            'A' => 'James',
//            'B' => 'Joe',
//            'C' => 'Jonas',
//        ],
//    ]
```

You can also pass some row header names if you don't want them to be automatically guessed. You'd then call the macro with `transposeWithKeys(['myID', 'row2'])` and the resulting rows would be `myID` and `row2 instead of `id` and `name` respectively. 

### Classes

#### Constant trait

#### Reflection trait

#### Method helper

### Database

#### Table reader

##### Fill missing attributes

### Blade helpers

#### Form date field

#### Bootstrap form errors

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer install
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@sebastiaanluca.com instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-author]
- [All Contributors][link-contributors]

## About

My name is Sebastiaan and I'm a freelance back-end developer specializing in building high-end, custom Laravel applications. Check out my [portfolio][author-portfolio] for more information and my other [packages](https://github.com/sebastiaanluca?tab=repositories) to kick-start your next project. Have a project that could use some guidance? Send me an e-mail at [hello@sebastiaanluca.com][author-email]!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sebastiaanluca/laravel-helpers.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sebastiaanluca/laravel-helpers/master.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sebastiaanluca/laravel-helpers.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-helpers
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-helpers
[link-downloads]: https://packagist.org/packages/sebastiaanluca/laravel-helpers
[link-contributors]: ../../contributors
[link-author]: https://github.com/sebastiaanluca
[author-portfolio]: http://www.sebastiaanluca.com
[author-email]: mailto:hello@sebastiaanluca.com
