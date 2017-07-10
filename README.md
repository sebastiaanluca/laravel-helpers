# Laravel Helpers

[![Latest stable release][version-badge]][link-packagist]
[![Software license][license-badge]](LICENSE.md)
[![Build status][travis-badge]][link-travis]
[![Total downloads][downloads-badge]][link-packagist]

[![Read my blog][blog-link-badge]][link-blog]
[![View my other packages and projects][packages-link-badge]][link-packages]
[![Follow @sebastiaanluca on Twitter][twitter-profile-badge]][link-twitter]
[![Share this package on Twitter][twitter-share-badge]][link-twitter-share]

**An extensive set of generic PHP and Laravel-specific helpers.**

Each helper is optional and comes with instructions on how to use it.

## Table of contents

* [Requirements](#requirements)
* [How to install](#how-to-install)
* [How to use](#how-to-use)
    + [Global helper functions](#global-helper-functions)
        - [rand\_bool](#rand--bool)
        - [str\_wrap](#str--wrap)
        - [is\_assoc\_array](#is--assoc--array)
        - [array\_expand](#array--expand)
        - [array\_without](#array--without)
        - [array\_pull\_value](#array--pull--value)
        - [array\_pull\_values](#array--pull--values)
        - [array\_hash](#array--hash)
        - [object\_hash](#object--hash)
        - [has_public_method](#has-public-method)
        - [carbonize](#carbonize)
        - [take (pipe operator)](#take--pipe-operator-)
        - [locale](#locale)
        - [sss](#sss)
        - [ddd](#ddd)
        - [sss\_if](#sss--if)
        - [ddd\_if](#ddd--if)
    + [Collection macros](#collection-macros)
        - [Carbonize](#carbonize)
        - [Between](#between)
        - [transformKeys](#transformkeys)
        - [transpose](#transpose)
        - [transposeWithKeys](#transposewithkeys)
        - [d](#d)
        - [ddd](#ddd-1)
    + [Class helpers](#class-helpers)
        - [Constants trait](#constants-trait)
        - [ProvidesClassInfo trait](#providesclassinfo-trait)
        - [MethodHelper](#methodhelper)
    + [Database table reader](#database-table-reader)
        - [Loading a table's information](#loading-a-table-s-information)
        - [getConnection](#getconnection)
        - [setConnection](#setconnection)
        - [table](#table)
        - [rawFields](#rawfields)
        - [fields](#fields)
        - [guarded](#guarded)
        - [fillable](#fillable)
        - [casts](#casts)
        - [dates](#dates)
        - [nullable](#nullable)
        - [hasField](#hasfield)
        - [usesTimestamps](#usestimestamps)
        - [usesSoftDelete](#usessoftdelete)
* [License](#license)
* [Change log](#change-log)
* [Testing](#testing)
* [Contributing](#contributing)
* [Security](#security)
* [Credits](#credits)
* [About](#about)

Table of contents generated with <a href='http://ecotrust-canada.github.io/markdown-toc/'>markdown-toc</a>.

## Requirements

- PHP 7 or higher
- Laravel 5.4 or higher

## How to install

Via Composer:

```bash
composer require sebastiaanluca/laravel-helpers
```

To use the global helper functions or enable the collection macros, add the corresponding service provider to your `config/app.php` file:

```php
'providers' => [

    SebastiaanLuca\Helpers\Methods\GlobalHelpersServiceProvider::class,
    SebastiaanLuca\Helpers\Collections\CollectionMacrosServiceProvider::class,
    
]
```

Other helpers are standalone and do not need to be activated beforehand.

## How to use

### Global helper functions

#### rand\_bool

Randomly return `true` or `false`.

```php
rand_bool();

// true
```

#### str\_wrap

Wrap a string with another string.

```php
str_wrap('foo', '*');

// "*foo*"
```

#### is\_assoc\_array

Check if an array is associative.

Performs a simple check to determine if the given array's keys are numeric, start at 0, and count up to the amount of values it has.

```php
is_assoc_array(['color' => 'blue', 'age' => 31]);

// true
```

```php
is_assoc_array([0 => 'blue', 7 => 31]);

// true
```

```php
is_assoc_array(['blue', 31]);

// false
```

```php
is_assoc_array([0 => 'blue', 1 => 31]);

// false
```

#### array\_expand

Expand a flat dotted array into a multi-dimensional associative array.

If a key is encountered that is already present and the existing value is an array, each new value will be added to that array. If it's not an array, each new value will override the existing one.

```php
array_expand(['products.desk.price' => 200]);

/*
[
    "products" => [
        "desk" => [
            "price" => 200,
        ],
    ],
]
*/
```

#### array\_without

Get the array without the given values.

Accepts either an array or a value as parameter to remove.

```php
$cars = ['bmw', 'mercedes', 'audi'];
$soldOut = ['audi', 'bmw'];

$inStock = array_without($cars, $soldOut);

// ["mercedes"]
```

```php
array_without(['one', 'two', 'three'], 'two');

// ["one", "three"]
```

#### array\_pull\_value

Pull a single value from a given array.

Returns the given value if it was successfully removed from the source array or `null` if it was not found.

```php
$source = ['A', 'B', 'C'];

$removed = array_pull_value($source, 'C');

// $removed = "C"
// $source = ["A", "B"]
```

#### array\_pull\_values

Pull an array of values from a given array.

Returns the values that were successfully removed from the source array or an empty array if none were found.

```php
$source = ['A', 'B', 'C'];
$removed = array_pull_values($source, ['A', 'B']);

// $removed = ["A", "B"]
// $source = ["C"]
```

#### array\_hash

Create a unique string identifier for an array.

The identifier will be entirely unique for each combination of keys and values.

```php
array_hash([1, 2, 3]);

// "262bbc0aa0dc62a93e350f1f7df792b9"
```

```php
array_hash(['hash' => 'me']);

// "f712e79b502bda09a970e2d4d47e3f88"
```

#### object\_hash

Create a unique string identifier for an object.

Similar to [array_hash](#array_hash), this uses `serialize` to *stringify* all public properties first. The identifier will be entirely unique based on the object class, properties, and its values.

```php
class ValueObject {
    public $property = 'randomvalue';
}

object_hash(new ValueObject);

// "f39eaea7a1cf45f5a0c813d71b5f2f57"
```

#### has_public_method

Check if a class has a certain public method.

```php
class Hitchhiker {
    public function answer() {
        return 42;
    }
}

has_public_method(Hitchhiker::class, 'answer');

// true

has_public_method(new Hitchhiker, 'answer');

// true
```

#### carbonize

Create a Carbon datetime object from a string.

Requires the [nesbot/carbon](https://github.com/briannesbitt/Carbon) package.

```php
carbonize('2017-01-18 11:30');

/*
Carbon\Carbon {
    "date": "2017-01-18 11:30:00.000000",
    "timezone_type": 3,
    "timezone": "UTC",
}
*/
```

#### take (pipe operator)

Create a new pipe item from a given value.

Allows you to chain method calls any way you see fit. See the [enabling PHP method chaining with a makeshift pipe operator](https://blog.sebastiaanluca.com/enabling-php-method-chaining-with-a-makeshift-pipe-operator) blog post for more info.

```php
take('https://blog.sebastiaanluca.com/')
    ->pipe('parse_url', PHP_URL_HOST)
    ->pipe('explode', '.', '$$')
    ->pipe('reset')
    ->get();

// "blog"
```

#### locale

Get the active app locale or the fallback locale if it's missing or not set.

Requires the [laravel/framework](https://github.com/laravel/framework) package.

```php
locale();

// "en"
```

#### sss

Display structured debug information about one or more values **in plain text** using Kint and halt script execution afterwards. Accepts multiple arguments to dump.

Output will be identical to `ddd` when used in a command line interface. In a browser, it'll display plain, but structured text.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

```php
sss('string');

/*
┌─────────────────────────────────────────┐
│ literal                                 │
└─────────────────────────────────────────┘
string (6) "string"
═══════════════════════════════════════════
Called from .../src/MyClass.php:42
*/

sss('string', 0.42, ['array']);

/*
┌─────────────────────────────────────────┐
│ literal                                 │
└─────────────────────────────────────────┘
string (6) "string"
┌─────────────────────────────────────────┐
│ literal                                 │
└─────────────────────────────────────────┘
double 0.42
┌─────────────────────────────────────────┐
│ literal                                 │
└─────────────────────────────────────────┘
array (1) [
    0 => string (5) "array"
]
═══════════════════════════════════════════
Called from .../src/MyClass.php:42
*/
```

#### ddd

Display structured debug information about one or more values using Kint and halt script execution afterwards. Accepts multiple arguments to dump. Output will be identical to `sss` when used in a command line interface. In a browser, it'll display an interactive, structured tree-view.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

See the [sss helper](#sss) for example output.

#### sss\_if

Display structured debug information about one or more values **in plain text** using Kint and halt script execution afterwards, but only if the condition is truthy. Does nothing if falsy. Accepts multiple arguments to dump.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

```php
sss_if($user->last_name, 'User has a last name', $user->last_name);
```

See the [sss helper](#sss) for example output.

#### ddd\_if

Display structured debug information about one or more values using Kint and halt script execution afterwards, but only if the condition is truthy. Does nothing if falsy. Accepts multiple arguments to dump.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

```php
ddd_if(app()->environment('local'), 'Debugging in a local environment!');
```

See the [ddd helper](#ddd) for example output.

### Collection macros

#### Carbonize

Create Carbon instances from items in a collection.

Requires the [nesbot/carbon](https://github.com/briannesbitt/Carbon) package.

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

#### Between

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

#### transformKeys

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

#### transpose

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

#### transposeWithKeys

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

You can also pass some row header names if you don't want them to be automatically guessed. You'd then call the macro with `transposeWithKeys(['myID', 'row2'])` and the resulting rows would be `myID` and `row2 instead of `id` and `name` respectively.

#### d

Display structured debug information on the collection using Kint. Can be called multiple times during a collection's method chain and outputs debug information at each point of use. Continues script execution afterwards.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

```php
collect([
    'id' => 6,
    'name' => 'Sebastiaan',
])
->d()
->put('role', 'author')
->d();
```

See the [sss helper](#sss) for example output.

#### ddd

Display structured debug information on the collection using Kint. Halts script execution afterwards, so it can only be called once during a collection's method chain.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

```php
collect([
    'id' => 6,
    'name' => 'Sebastiaan',
])
->d()
->put('role', 'author')
->ddd();
```

See the [sss helper](#sss) for example output.

### Class helpers

#### Constants trait

The primary use of the `Constants` trait is to enable you to store all constants of a specific type in a single class or value object and have it return those with a single call.

This can be useful for instance when your database uses integers to store states, but you want to use descriptive strings throughout your code. It also allows you to refactor these constants at any time without having to waste time searching your code for any raw values (and probably miss a few, introducing new bugs along the way).

```php
<?php

use SebastiaanLuca\Helpers\Classes\Constants;

class UserStates
{
    use Constants;

    const REGISTERED = 'registered';
    const ACTIVATED = 'activated';
    const DISABLED = 'disabled';
}

UserStates::constants();

// or

(new UserStates)->constants();

/*
[
    "REGISTERED" => "registered",
    "ACTIVATED" => "activated",
    "DISABLED" => "disabled",
]
*/
```

#### ProvidesClassInfo trait

The `ProvidesClassInfo` trait provides an easy-to-use `getClassDirectory()` helper method that returns the directory of the current class.

```php
<?php

namespace Kyle\Helpers;

use SebastiaanLuca\Helpers\Classes\ProvidesClassInfo;

class MyClass
{
    use ProvidesClassInfo;

    public function __construct()
    {
        var_dump($this->getClassDirectory());
    }
}

// "/Users/Kyle/Projects/laravel-helpers"
```

#### MethodHelper

A static class helper to help you figure out the visibility/accessibility of an object's methods.

```php
<?php

class SomeClass
{
    protected function aPrivateMethod() : string
    {
        return 'private';
    }

    protected function aProtectedMethod() : string
    {
        return 'protected';
    }

    protected function aPublicMethod() : string
    {
        return 'public';
    }
}

MethodHelper::hasMethodOfType($class, 'aPrivateMethod', 'private');

// true

MethodHelper::hasProtectedMethod($class, 'aProtectedMethod');

// true

MethodHelper::hasPublicMethod($class, 'aPublicMethod');

// true

MethodHelper::hasProtectedMethod($class, 'aPrivateMethod');

// false

MethodHelper::hasPublicMethod($class, 'invalidMethod');

// false
```

### Database table reader

Gives you detailed information about a given table, especially in the context of a Laravel Eloquent model.

Note that this has only been tested with MySQL databases, although it might work with others too as it uses a raw `describe` statement to get a table's information. Uses the default database connection by default when resolved from the DI container, but you can set your own before calling `read`.

Note: unless otherwise specified, call each method __after reading__ the table to allow for it to return something.

Requires the [illuminate/database](https://github.com/illuminate/database) package.

#### Loading a table's information

Create a new reader to set up its internal database manager and connection:

```php
$reader = app(\SebastiaanLuca\Helpers\Database\TableReader::class);
```

Then read the table:

```php
$reader->read('users');
```

#### getConnection

Get the database connection used to read the table.

#### setConnection

Set the database connection used to read the table. Do this __before__ reading the table.

```php
app(\SebastiaanLuca\Helpers\Database\TableReader::class)
    ->setConnection($connection)
    ->read('users');
```

#### table

Get the table name that was read.

#### rawFields

Get all the table's fields and additional raw information as an array.

#### fields

Get a simple list of all the table's column names.

#### guarded

Get a simple list of all the table's guarded fields.

Compares the table's columns with a default list and returns matches.

Currently supported:

- `id`
- `password`
- `password_hash`
- `created_at`
- `updated_at`
- `deleted_at`

#### fillable

Get all mass-assignable attributes.

Compares default fillable fields with the ones in the table.

#### casts

Get all attributes that can be casted to native types.

Matches table column types with their native counterparts.

Currently supported:

- `int` to `integer`
- `tinyint(1)` to `boolean`
- `json` to `array`

#### dates

Get all attributes that can be converted to Carbon DateTime instances.

Currently supported:

- `timestamp`
- `datetime`
- `date`
- `time`
- `year`

#### nullable

Get all attributes that can be `NULL`.

#### hasField

Check if the table has a given column.

#### usesTimestamps

Check if the table uses Eloquent timestamps (`created_at` and `updated_at`).

#### usesSoftDelete

Check if the table uses Eloquent soft deletes (`deleted_at`).

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
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-twitter]: https://twitter.com/sebastiaanluca
[link-twitter-share]: https://twitter.com/home?status=An%20extensive%20set%20of%20generic%20PHP%20and%20Laravel-specific%20helpers,%20collection%20macros,%20and%20more!%20https%3A//github.com/sebastiaanluca/laravel-helpers%20via%20%40sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-github-repositories]: https://github.com/sebastiaanluca?tab=link-github-repositories
[link-author-email]: mailto:hello@sebastiaanluca.com
