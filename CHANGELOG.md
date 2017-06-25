# Changelog

All Notable changes to `sebastiaanluca/laravel-helpers` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

##  Unreleased (1.0.0)

### Added

- Set up testing environment and add tests for each feature
- Added support for Laravel 5.5

### Changed

- Locked down dependencies more strictly, but allow optional use of each helper
- Tweaked Travis test script

### Removed

- Dropped support for Laravel 5.1, 5.2, and 5.3
- Extracted module service provider (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))
- Extracted base Eloquent model (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))
- Extracted queueable job (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))

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
