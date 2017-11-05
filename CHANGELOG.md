# Changelog

All Notable changes to `sebastiaanluca/laravel-helpers` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## Unreleased

### Added

- Added logo (by caneco)
- Added `is_guest` helper
- Added `is_logged_in` helper
- Added `user` helper
- Added `me` helper
- Added `create_temporary_file` helper

### Changed

- Added better installation instructions in readme
- Simplified all tests
- Added `carbonize()` example without passing a value

### Removed

- Removed support for PHP 7.0 and below
- Removed support for Laravel 5.4
- Removed deprecated `use Laravelista\Ekko\Ekko;` import
- Removed laravelcollective/html and laravelista/ekko Composer dev dependencies

## 1.0.1 (2017-07-11)

### Fixed

- Fixed method helper example code in readme
- Upgraded Mockery dependency to fix an error on PHP 7.2 (see https://github.com/mockery/mockery/pull/718)

## 1.0.2 (2017-11-05)

### Fixed

- Use the item pipe operator class identifier instead of a hardcoded `$$` string ([#11](https://github.com/sebastiaanluca/laravel-helpers/pull/11))

## 1.0.1 (2017-07-11)

### Fixed

- Fixed method helper readme example

## 1.0.0 (2017-07-10)

### Added

- Set up testing environment and add tests for each feature
- Added support for Laravel 5.5
- Added `sss_if` global helper
- Added a shorthand `constants()` method to the `Constants` trait

### Changed

- Locked down dependencies more strictly, but allow optional use of each helper
- Added type hints where possible
- Tweaked Travis test script
- Renamed global method helpers service provider
- Renamed collection service provider
- `transposeWithKeys` now automatically guesses the row header names and allows you to override them
- Renamed constant helper trait to `Constants`
- Renamed `hasMethod` to `hasMethodOfType` in `MethodHelper`
- Renamed `ReflectionTrait` to `ProvidesClassInfo`
- Renamed `public_method_exists` global helper to `has_public_method`

### Fixed

- Fixed `MethodHelper::hasMethodOfType` throwing exception if third `$type` parameter was not private, protected, or public

### Removed

- Dropped support for Laravel 5.1, 5.2, and 5.3
- Extracted module service provider (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))
- Extracted base Eloquent model (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))
- Extracted queueable job (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))
- Removed `mapWithIntegerKeys` collection macro (fixed in Laravel 5.4.x)
- Removed HTML and form helpers (tip: use Spatie's macroable https://github.com/spatie/laravel-html package instead)
- Removed `is_active_route` global helper (use Ekko's default global helpers instead)

## 0.5.2 (2017-02-14)

### Changed

- Make get constants on ConstantTrait public

## 0.5.1 (2017-02-10)

### Changed

- Add ID to guards in BaseEloquentModel

## 0.5.0 (2017-02-10)

### Added

- Added BaseEloquentModel

## 0.4.0 (2017-02-10)

### Added

- Added QueueableJob

## 0.3.1

### Added

- Added a check for Laravel 5.4's `Illuminate\Session\EncryptedStore::getToken()` that was changed to `token()`.
