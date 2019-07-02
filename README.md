<p align="center">
<img title="Laravel Helpers" src="https://raw.githubusercontent.com/sebastiaanluca/laravel-helpers/develop/logo.png"></img>
</p>

<p align="center">
<a href="https://packagist.org/packages/sebastiaanluca/laravel-helpers"><img src="https://img.shields.io/packagist/v/sebastiaanluca/laravel-helpers.svg?label=stable" alt="Latest stable release"></img></a>
<a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="Software license"></img></a>
<a href="https://travis-ci.org/sebastiaanluca/laravel-helpers"><img src="https://img.shields.io/travis/sebastiaanluca/laravel-helpers/master.svg" alt="Build status"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca/laravel-helpers"><img src="https://img.shields.io/packagist/dt/sebastiaanluca/laravel-helpers.svg" alt="Total downloads"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca/laravel-helpers"><img src="https://img.shields.io/github/stars/sebastiaanluca/laravel-helpers.svg?color=brightgreen" alt="Total downloads"></img></a>
</p>

<p align="center">
<a href="https://blog.sebastiaanluca.com"><img src="https://img.shields.io/badge/link-blog-lightgrey.svg" alt="Read my blog"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca"><img src="https://img.shields.io/badge/link-other_packages-lightgrey.svg" alt="View my other packages and projects"></img></a>
<a href="https://twitter.com/sebastiaanluca"><img src="https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social" alt="Follow @sebastiaanluca on Twitter"></img></a>
<a href="https://twitter.com/home?status=https://twitter.com/intent/tweet?text=Check%20out%20this%20extensive%20set%20of%20Laravel%20framework%20helper%20functions%20and%20collection%20macros!%20Via%20@sebastiaanluca%20https://github.com/sebastiaanluca/laravel-helpers"><img src="https://img.shields.io/twitter/url/http/shields.io.svg?style=social" alt="Share this package on Twitter"></img></a>
</p>

<p align="center">
<strong>An extensive set of Laravel framework helper functions and collection macros.</strong>
</p>

## Table of contents

- [Requirements](#requirements)
- [How to install](#how-to-install)
- [Upgrading from 1.x](#upgrading-from-1x)
- [Framework helper functions](#framework-helper-functions)
    - [locale](#locale)
    - [is_guest](#is_guest)
    - [is\_logged\_in](#is_logged_in)
    - [me](#me)
    - [user](#user)
- [Collection macros](#collection-macros)
    - [Carbonize](#carbonize)
    - [Between](#between)
    - [transformKeys](#transformkeys)
    - [transpose](#transpose)
    - [transposeWithKeys](#transposewithkeys)
    - [d](#d)
    - [ddd](#ddd)
- [License](#license)
- [Change log](#change-log)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [About](#about)

## Requirements

- PHP 7.2 or higher
- Laravel 5.8 or higher

## How to install

Just add the package to your project using Composer and Laravel will auto-discover it:

```bash
composer require sebastiaanluca/laravel-helpers
```

If you want to use the collection debug macros, install the [kint-php/kint](https://github.com/raveren/kint) package as a dev dependency:

```bash
composer require kint-php/kint --dev
```

## Upgrading from 1.x

All essential generic PHP helpers have been extracted to their own [sebastiaanluca/php-helpers](https://github.com/sebastiaanluca/php-helpers) package and some other helpers have been removed in anticipation of their own package. In effect and from now on, Laravel Helpers will only contain helpers for the Laravel framework.

In addition, the minimum requirements have been upgraded to PHP 7.2 and Laravel 5.6.

[See the changelog](CHANGELOG.md#200-2018-07-22) for more information.

## Framework helper functions

### locale

Get the active app locale or the fallback locale if it's missing or not set.

```php
locale();

// "en"
```

### is_guest

Determine if the current user is a guest.

The opposite of [is_logged_in](#is_logged_in).

```php
// When not authenticated
is_guest();

// true

// When authenticated as a user
is_guest();

// false
```

### is\_logged\_in

Determine if the current user is authenticated.

The opposite of [is_guest](#is_guest).

```php
// When not authenticated
is_logged_in();

// false

// When authenticated as a user
is_logged_in();

// true
```

### user

Get the currently authenticated user (if there is one).

When logged in, returns your user model or object that implements `\Illuminate\Contracts\Auth\Authenticatable`.

```php
// When not authenticated
user();

// null

// When authenticated as a user
user();

// Illuminate\Foundation\Auth\User {}
```

### me

Get the currently authenticated user (if there is one).

When logged in, returns your user model or object that implements `\Illuminate\Contracts\Auth\Authenticatable`.

An alternative for [user](#user).

```php
// When not authenticated
me();

// null

// When authenticated as a user
me();

// Illuminate\Foundation\Auth\User {}
```

## Collection macros

### carbonize

Create Carbon instances from items in a collection.

```php
collect([
    'yesterday',
    'tomorrow',
    '2017-07-01',
])->carbonize();

/*
Illuminate\Support\Collection {
    all: [
        Carbon\Carbon {
            "date": "2017-07-09 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC",
        },
        Carbon\Carbon {
            "date": "2017-07-11 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC",
        },
        Carbon\Carbon {
            "date": "2017-07-01 00:00:00.000000",
            "timezone_type": 3,
            "timezone": "UTC",
        },
    ],
}
*/
```

### between

Reduce each collection item to the value found between a given start and end string.

The second parameter is optional and falls back to the start string if `null`.

```php
collect([
    '"value1"',
    '"value2"',
    '"value3"',
])->between('"', '"');

/*
Illuminate\Support\Collection {
    all: [
        "value1",
        "value2",
        "value3",
    ],
}
*/
```

### transformKeys

Perform an operation on the collection's keys.

The callable operation can either be a globally available method or a closure.

```php
collect([
    'a' => 'value',
    'b' => 'value',
    'c' => 'value',
])->transformKeys('strtoupper');

/*
Illuminate\Support\Collection {
    all: [
        "A" => "value",
        "B" => "value",
        "C" => "value",
    ],
}
*/
```

```php
collect([
    'a' => 'value',
    'b' => 'value',
    'c' => 'value',
])->transformKeys(function (string $key) {
    return 'prefix-' . $key;
});

/*
Illuminate\Support\Collection {
    all: [
        "prefix-a" => "value",
        "prefix-b" => "value",
        "prefix-c" => "value",
    ],
}
*/
```

### transpose

Transpose (flip) a collection matrix (array of arrays) so its columns become rows and its rows become columns.

```php
collect([
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9],
])->transpose();

/*
Illuminate\Support\Collection {
    all: [
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
    ],
}
*/
```

### transposeWithKeys

Flip a collection of rows and values per column so its columns become rows and its rows become columns.

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
])->transposeWithKeys();

/*
Illuminate\Support\Collection {
    all: [
        "id" => [
            "A" => 1,
            "B" => 2,
            "C" => 3,
        ],
        "name" => [
            "A" => "James",
            "B" => "Joe",
            "C" => "Jonas",
        ],
    ],
}
*/
```

You can also pass some row header names if you don't want them to be automatically guessed. You'd then call the macro with `transposeWithKeys(['myID', 'row2'])` and the resulting rows would be `myID` and `row2` instead of `id` and `name` respectively.

### d

Display structured debug information on the collection using Kint. Can be called multiple times during a collection's method chain and outputs debug information at each point of use. Continues script execution afterwards.

Explicitly requires the [kint-php/kint](https://github.com/raveren/kint) package.

```php
collect([
    'id' => 6,
    'name' => 'Sebastiaan',
])
->d()
->put('role', 'author')
->d();
```

### ddd

Display structured debug information on the collection using Kint. Halts script execution afterwards, so it can only be called once during a collection's method chain.

Explicitly requires the [kint-php/kint](https://github.com/raveren/kint) package.

```php
collect([
    'id' => 6,
    'name' => 'Sebastiaan',
])
->d()
->put('role', 'author')
->ddd();
```

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

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [hello@sebastiaanluca.com][link-author-email] instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-github-profile]
- Logo by [Vitor Caneco](https://github.com/caneco)
- [All Contributors][link-contributors]

## About

My name is Sebastiaan and I'm a freelance Laravel developer specializing in building custom Laravel applications. Check out my [portfolio][link-portfolio] for more information, [my blog][link-blog] for the latest tips and tricks, and my other [packages][link-packages] to kick-start your next project.

Have a project that could use some guidance? Send me an e-mail at [hello@sebastiaanluca.com][link-author-email]!

[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-helpers
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-helpers
[link-contributors]: ../../contributors

[link-portfolio]: https://www.sebastiaanluca.com
[link-blog]: https://blog.sebastiaanluca.com
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-author-email]: mailto:hello@sebastiaanluca.com
