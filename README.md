# Mail Tester

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


A package to help with acceptance Email testing. The goal is to add usefull PHPunit assertions in a Trait that you can include when there is a need to test emails that are fired from acceptance testing packages like Laravel Dusk.

## Install

This package assumes that you've already installed Mailcatcher. You can check this [tutorial]('https://serversforhackers.com/setting-up-mailcatcher') on how to install it to your system.

### Via Composer

``` bash
$ composer require drakakisgeo/mailtester
```

### Laravel 5.*
After updating composer, add the ServiceProvider to the providers array in config/app.php
``` php
Drakakisgeo\Mailtester\MailtesterServiceProvider::class,
```

Copy the package config to your local config with the publish command:

``` bash
$ php artisan vendor:publish --provider="Drakakisgeo\Mailtester\MailtesterServiceProvider"
```

## Instructions

Include the **InteractsWithMailCatcher** Trait in your test and make sure that your test extends the Laravel's Testcase class. Immediately you have access to the following methods:

* cleanMessages()
* getLastMessage()
* assertEmailIsSent()
* ...


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [Drakakis George][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/drakakisgeo/mailtester.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/drakakisgeo/mailtester/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/drakakisgeo/mailtester.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/drakakisgeo/mailtester.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/drakakisgeo/mailtester.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/drakakisgeo/mailtester
[link-travis]: https://travis-ci.org/drakakisgeo/mailtester
[link-scrutinizer]: https://scrutinizer-ci.com/g/drakakisgeo/mailtester/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/drakakisgeo/mailtester
[link-downloads]: https://packagist.org/packages/drakakisgeo/mailtester
[link-author]: https://github.com/drakakisgeo
[link-contributors]: ../../contributors
