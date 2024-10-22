# Laravel SpamProtect

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yannkuesthardt/laravel-spamprotect?style=flat-square)](https://packagist.org/packages/yannkuesthardt/laravel-spamprotect)
[![Total Downloads](https://img.shields.io/packagist/dt/yannkuesthardt/laravel-spamprotect?style=flat-square)](https://packagist.org/packages/yannkuesthardt/laravel-spamprotect)
[![License](https://img.shields.io/packagist/l/yannkuesthardt/laravel-spamprotect?style=flat-square)](https://github.com/yannkuesthardt/Laravel-SpamProtect/blob/main/LICENSE.md)
[![GitHub Build Status](https://img.shields.io/github/actions/workflow/status/yannkuesthardt/Laravel-SpamProtect/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/yannkuesthardt/Laravel-SpamProtect)

Laravel SpamProtect is a simple package, that encrypts email addresses and phone numbers to protect them against unwanted crawlers and spam.

It encrypts the target of your link and uses JS to decrypt it on the client side. This way, the email address is not visible in the HTML source code and can't be crawled by bots reading hrefs. 

Additionally, some common chars used in e-mail addresses and phone numbers are replaced with HTML entities to make it even harder for bots to crawl.

```html
<a href="#" data-spamprotect-token="eyJjdCI6Ijky...">
    hello@example.com
</a>
```

***Security Note:** Do not use this extension to pass sensitive data to the frontend. The encryption is only meant to
stop crawlers and can easily be circumvented by a human.*

- [Installation](#installation)
- [Upgrade](#upgrade)
- [Usage](#usage)
- [Customization](#customization)
- [Testing](#testing)
- [Changelog](#changelog)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)

## Installation
<a name="installation"></a>

### Requirements

- PHP 8.1 or higher
- [Laravel](https://github.com/laravel/framework) 10.0 or higher

### Getting Started

You can install the package via composer:

```bash
composer require yannkuesthardt/laravel-spamprotect
```

Run the installation command to generate a new encryption key and clear necessary caches.

```bash
php artisan spamprotect:install
```

Add the following two blade directives somewhere in your HTML body tag.

```blade
@spamprotectKey
@spamprotectJs
```

***Hint:** Optionally you can override the default path to the JavaScript file:* `@spamprotectJs('your/custom/path/to/spamprotect/spamprotect.js')`

## Upgrade
<a name="upgrade"></a>
### Upgrade from v1 to v2
If you used v1 in the past, you needed to publish our JavaScript to be accessible via `@spamprotectJs`. We have now
added routing to the package, so you can just use `@spamprotectJs` without publishing our JavaScript first. If you
have set a custom path via the blade directive or the config, remove it to get the default JavaScript via route. You
may have to republish the config file, depending on your setup.

Additionally, you needed to install CryptoJS and require it in your own JavaScript first. As CryptoJS has been
discontinued and most browsers offer native support with tools such as crypto, we have rebuilt this extension
to work with native JavaScript. For this to work either switch to our default JavaScript using the new route or
republish the JavaScript file yourself. If not used anywhere else in your project you can remove CryptoJS.

## Usage
<a name="usage"></a>
### E-Mail Address
To encrypt an email address use the following blade component:

```html
<x-encrypt-email email="hello@example.com"/>
```

This will result in the following HTML code:

```html
<a href="#" data-spamprotect-token="aVN2anJHTHJL...">
    hello@example.com
</a>
```

### Phone Number
To encrypt a phone number use the following blade component:

```html
<x-encrypt-phone phone="+1234567890"/>
```

This will result in the following HTML code:

```html
<a href="#" data-spamprotect-token="xaVBiZU9rbUR...">
    +1 234 567890
</a>
```

### Custom Text
You can also use a custom text for the link:

```html
<x-encrypt-email email="hello@example.com">
    My Cutom Text
</x-encrypt-email>
```

This will result in the following HTML code:

```html
<a href="#" data-spamprotect-token="eyJjdCI6Ilk4...">
    My Custom Text
</a>
```

### Attributes
You can add HTML attributes (e.g. class, id, etc.) to the generated code by passing them to the components.

```html
<x-encrypt-email class="my-class" id="my-id" ...
```

This will result in the following HTML code:

```html
<a class="my-class" id="my-id" ...
```

## Customization
<a name="customization"></a>

You can generate a new encryption key using:

```bash
php artisan spamprotect:key
```

You can publish the config using:

```bash
php artisan vendor:publish --tag="laravel-spamprotect-config"
```

In the config you can customize the URL used for the default JavaScript or override the path completely. 

You can publish the assets (javascript) using:

```bash
php artisan vendor:publish --tag="laravel-spamprotect-assets"
```

You can publish the views using

```bash
php artisan vendor:publish --tag="laravel-spamprotect-views"
```
## Contributing
<a name="contributing"></a>
Feel free to suggest changes, ask for new features or fix bugs yourself. We're sure there are a lot of improvements
that could be made, and we would be very happy to merge useful pull requests. Thanks!

### Testing
<a name="testing"></a>

**PHPUnit**
```bash
composer test
```

**PHPStan**
```bash
composer phpstan
```

### Security Vulnerabilities
<a name="security-vulnerabilities"></a>

Please review [our security policy](https://github.com/yannkuesthardt/Laravel-SpamProtect/security/policy) on how to report security vulnerabilities.


## Changelog
<a name="changelog"></a>

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License
<a name="license"></a>

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
