# Changelog

All notable changes to `laravel-spamprotect` will be documented in this file.

## v2.0.1
- Fixed error causing duplicate click events when using livewire navigation ([#4](https://github.com/yannkuesthardt/Laravel-SpamProtect/pull/4))

## v2.0.0
*Please read the upgrade guide in the [README](README.md#upgrade-from-v1-to-v2) for details on upgrading.*
- Completely reworked encryption to replace CryptoJS with vanilla JavaScript
- Added routing support to make publishing JavaScript before usage unnecessary
- Ended active support for PHP 7.4 & 8.0 and Laravel 8 & 9

## v1.2.1
- Added support for Livewire v3 navigation

## v1.2.0
- Added support for HTML code as link text (e.g. icons with <i> tag)

## v1.1.1
- Fixed error in README.md instructions

## v1.1.0
- Add actual PHPUnit tests for encryption service
- Removed PHPUnit example test
- Added more configuration options
- Updated README.md

## v1.0.1
- Fixed error in Tests and GitHub Actions
- Replaced PEST with PHPUnit

## v1.0.0
- Provides encryption components for e-mail addresses and phone numbers
