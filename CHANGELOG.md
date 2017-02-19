# Changelog

All Notable changes to `sebastiaanluca/laravel-helpers` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

##  Unreleased

### Added

- Set up testing

### Changed

- Stricter dependencies
- Upgrade to PHPUnit 6

### Removed

- Module service provider (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))
- Base Eloquent model (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))
- Queueable job (moved to [laravel-resource-flow](https://github.com/sebastiaanluca/laravel-resource-flow))

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
