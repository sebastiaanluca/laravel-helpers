# Laravel Helpers

[![Latest stable release][version-badge]][link-packagist]
[![Software license][license-badge]](LICENSE.md)
[![Build status][travis-badge]][link-travis]
[![Total downloads][downloads-badge]][link-packagist]

[![Read my blog][blog-link-badge]][link-blog]
[![View my other packages and projects][packages-link-badge]][link-packages]
[![Follow @sebastiaanluca on Twitter][twitter-profile-badge]][link-twitter]
[![Share this package on Twitter][twitter-share-badge]][link-twitter-share]

*An extensive set of generic PHP and Laravel-specific helpers.**

Each helper is optional and comes with instructions on how to use it.

## Table of contents

TODO

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

#### rand_bool

Randomly return `true` or `false`.

```php
$boolean = rand_bool();

// true
```

#### str_wrap

Wrap a string with another string.

```php
$quoted = str_wrap('foo', '*');

// "*foo*"
```

#### is_assoc_array

Check if an array is associative.

Performs a simple check to determine if the given array's keys are numeric, start at 0, and count up to the amount of values it has.

```php
$assoc = is_assoc_array(['color' => 'blue', 'age' => 31]);

// true
```

```php
$sequential = is_assoc_array([0 => 'blue', 7 => 31]);

// true
```

```php
$sequential = is_assoc_array(['blue', 31]);

// false
```

```php
$sequential = is_assoc_array([0 => 'blue', 1 => 31]);

// false
```

#### array_expand

Expand a flat dotted array into a multi-dimensional associative array.

If a key is encountered that is already present and the existing value is an array, each new value will be added to that array. If it's not an array, each new value will override the existing one.

```php
$array = array_expand(['products.desk.price' => 200]);

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

#### array_without

Get the array without the given values.

Accepts either an array or a value as parameter to remove.

```php
$cars = ['bmw', 'mercedes', 'audi'];
$soldOut = ['audi', 'bmw'];

$inStock = array_without($cars, $soldOut);

// ["mercedes"]
```

```php
$sequence = array_without(['one', 'two', 'three'], 'two');

// ["one", "three"]
```

### array_pull_value

Pull a single value from a given array.

Returns the given value if it was successfully removed from the source array or `null` if it was not found.

```php
$source = ['A', 'B', 'C'];
$pulled = array_pull_value($source, 'C');

// "C"

// $source = ["A", "B"];
```

### array_pull_values

Pull an array of values from a given array.

Returns the values that were successfully removed from the source array or an empty array if none were found.

```php
$source = ['A', 'B', 'C'];
$pulled = array_pull_values($source, ['A', 'B']);

// ["A", "B"]

// $source = ["C"];
```

#### array_hash

Create a unique string identifier for an array.

The identifier will be entirely unique for each combination of keys and values.

```php
$hash1 = array_hash([1, 2, 3]);

// "262bbc0aa0dc62a93e350f1f7df792b9"
```

```php
$hash2 = array_hash(['hash' => 'me']);

// "f712e79b502bda09a970e2d4d47e3f88"
```

#### object_hash

Create a unique string identifier for an object.

Similar to [array_hash](#array_hash), this uses `serialize` to *stringify* all public properties first. The identifier will be entirely unique based on the object class, properties, and its values.

```php
class ValueObject {
    public $property = 'randomvalue';
}

$hash = object_hash(new ValueObject);

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

$hash = has_public_method(Hitchhiker::class, 'answer');

// true

$hash = has_public_method(new Hitchhiker, 'answer');

// true
```

#### carbonize

Create a Carbon datetime object from a string.

```php
$time = carbonize('2017-01-18 11:30');

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
$subdomain = take('https://blog.sebastiaanluca.com/')
               ->pipe('parse_url', PHP_URL_HOST)
               ->pipe('explode', '.', '$$')
               ->pipe('reset')
               ->get();

// "blog"
```

#### locale

Get the active app locale or the fallback locale if it's missing or not set.

```php
$locale = locale();

// "en"
```

#### sss

Display structured debug information about one or more values **in plain text** using Kint and halt script execution afterwards. Accepts multiple arguments to dump.

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

Output will be identical to `ddd` when used in a command line interface. In a browser, it'll display plain, but structured text.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

#### ddd

Display structured debug information about one or more values using Kint and halt script execution afterwards. Accepts multiple arguments to dump. Output will be identical to `sss` when used in a command line interface. In a browser, it'll display an interactive, structured tree-view.

See the [sss helper](#sss) for example output.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

#### sss_if

Display structured debug information about one or more values **in plain text** using Kint and halt script execution afterwards, but only if the condition is truthy. Does nothing if falsy. Accepts multiple arguments to dump.

```php
sss_if($user->last_name, 'User has a last name', $user->last_name);
```

See the [sss helper](#sss) for example output.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

#### ddd_if

Display structured debug information about one or more values using Kint and halt script execution afterwards, but only if the condition is truthy. Does nothing if falsy. Accepts multiple arguments to dump.

```php
ddd_if(app()->environment('local'), 'Debugging in a local environment!');
```

See the [ddd helper](#ddd) for example output.

Requires the [kint-php/kint](https://github.com/raveren/kint) package.

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

Note: uses default database connection when resolved from the DI container using `app(TableReader::class);`.

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
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-twitter]: https://twitter.com/sebastiaanluca
[link-twitter-share]: https://twitter.com/home?status=An%20extensive%20set%20of%20generic%20PHP%20and%20Laravel-specific%20helpers,%20collection%20macros,%20and%20more!%20https%3A//github.com/sebastiaanluca/laravel-helpers%20via%20%40sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-github-repositories]: https://github.com/sebastiaanluca?tab=link-github-repositories
[link-author-email]: mailto:hello@sebastiaanluca.com
