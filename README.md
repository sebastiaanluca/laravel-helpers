# Laravel Helpers

[![Latest stable release][version-badge]][link-packagist]
[![Software license][license-badge]](LICENSE.md)
[![Build status][travis-badge]][link-travis]
[![Total downloads][downloads-badge]][link-packagist]

[![Read my blog][blog-link-badge]][link-blog]
[![View my other packages and projects][packages-link-badge]][link-packages]
[![Follow @sebastiaanluca on Twitter][twitter-profile-badge]][link-twitter]
[![Share this package on Twitter][twitter-share-badge]][link-twitter-share]

**An extensive set of generic PHP and Laravel-specific helpers.** Each helper is optional and comes with instructions on how to use it.

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
* [Change log](#change-log)
* [Testing](#testing)
* [Contributing](#contributing)
* [Security](#security)
* [Credits](#credits)
* [License](#license)

Table of contents generated with <a href='http://ecotrust-canada.github.io/markdown-toc/'>markdown-toc</a>.

## Requirements

- PHP 7 or higher
- Laravel 5.4 or higher

## How to install

Via Composer:

```bash
composer require sebastiaanluca/laravel-helpers
```

## How to use

### Global methods

#### locale

Get the active locale.

```php
$locale = locale();
```

#### is_active_route

Check if the given route is currently active.

Note: requires the `laravelista/ekko` package ([https://github.com/laravelista/Ekko]()).

```php
$result = is_active_route('auth/login');
```

#### ddd_if

Only debugs a statement given a truth condition.

Note: requires the `raveren/kint` debug package (https://github.com/raveren/kint).

```php
ddd_if(app()->environment() == 'local', $var1, $var2, $var3);
```

#### carbonize

Create a Carbon object from a string.

```php
$time = carbonize('2017-01-18 11:30');
```

#### take (pipe operator)

Create a new piped item from a given value. See the [blog post](https://blog.sebastiaanluca.com/enabling-php-method-chaining-with-a-makeshift-pipe-operator) for more info.

```php
$subdomain = take('https://blog.sebastiaanluca.com/')
               ->pipe('parse_url', PHP_URL_HOST)
               ->pipe('explode', '.', '$$')
               ->pipe('reset')
               ->get();
```

#### rand_bool

Randomly return true or false.

```php
$bool = rand_bool();
```

#### str_wrap

Wrap a string with another string.

```php
$quoted = str_wrap('foo', '"');

// "foo"
```

#### is_assoc_array

Check if an array is associative (as opposed to numeric).

```php
$result = is_assoc_array(['color' => 'blue', 'age' => 31]);

// true
```

#### array_expand

Expand a flat dotted array to a multi-dimensional associative array.

```php
$array = array_expand(['products.desk.price' => 200]);

// ['products' => ['desk' => ['price' => 200]]]
```

#### array_without

Get the array without the given values.

```php
$cars = ['bmw', 'mercedes', 'audi'];
$soldOut = ['audi', 'bmw'];

$inStock = array_without($cars, $soldOut);

// ['mercedes']
```

#### array_hash

Create a unique identifier for a given array.

```php
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

```php
class ValueObject {
    public $property = 'randomvalue';
}

$hash = object_hash(new ValueObject);

// acceaba779657cdaf00e9c93737d778f
```

#### public_method_exists

Check if an object has a given public method.

```php
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

## License

This package operates under the MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer install
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [hello@sebastiaanluca.com][link-author-email] instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-github-profile]
- [All Contributors][link-contributors]

## About

My name is Sebastiaan and I'm a freelance Laravel developer specializing in building custom Laravel applications. Check out my [portfolio][link-portfolio] for more information, [my blog][link-blog] for the latest tips and tricks, and my other [packages][link-github-repositories] to kick-start your next project.

Have a project that could use some guidance? Send me an e-mail at [hello@sebastiaanluca.com][link-author-email]!

[version-badge]: https://poser.pugx.org/sebastiaanluca/laravel-helpers/version
[license-badge]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[travis-badge]: https://img.shields.io/travis/sebastiaanluca/laravel-helpers/master.svg
[downloads-badge]: https://img.shields.io/packagist/dt/sebastiaanluca/laravel-helpers.svg

[blog-link-badge]: https://img.shields.io/badge/link-blog-lightgrey.svg
[packages-link-badge]: https://img.shields.io/badge/link-other_packages-lightgrey.svg
[twitter-profile-badge]: https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social
[twitter-share-badge]: https://img.shields.io/twitter/url/http/shields.io.svg?style=social

[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-helpers
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-helpers
[link-contributors]: ../../contributors

[link-portfolio]: https://www.sebastiaanluca.com
[link-blog]: https://blog.sebastiaanluca.com
[link-packages]: https://github.com/sebastiaanluca?tab=link-github-repositories
[link-twitter]: https://twitter.com/sebastiaanluca
[link-twitter-share]: https://twitter.com/home?status=An%20extensive%20set%20of%20generic%20PHP%20and%20Laravel-specific%20helpers,%20collection%20macros,%20and%20more!%20https%3A//github.com/sebastiaanluca/laravel-helpers%20via%20%40sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-github-repositories]: https://github.com/sebastiaanluca?tab=link-github-repositories
[link-author-email]: mailto:hello@sebastiaanluca.com
