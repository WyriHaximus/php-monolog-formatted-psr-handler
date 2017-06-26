# Formatted [PSR-3](http://www.php-fig.org/psr/psr-3/) handler for Monolog

[![Linux Build Status](https://travis-ci.org/WyriHaximus/php-monolog-formatted-psr-handler.png)](https://travis-ci.org/WyriHaximus/php-monolog-formatted-psr-handler)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/monolog-formatted-psr-handler/v/stable.png)](https://packagist.org/packages/WyriHaximus/monolog-formatted-psr-handler)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/monolog-formatted-psr-handler/downloads.png)](https://packagist.org/packages/WyriHaximus/monolog-formatted-psr-handler/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/php-monolog-formatted-psr-handler/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/php-monolog-formatted-psr-handler/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/monolog-formatted-psr-handler/license.png)](https://packagist.org/packages/wyrihaximus/monolog-formatted-psr-handler)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WyriHaximus/php-monolog-formatted-psr-handler/badge.svg)](https://travis-ci.org/WyriHaximus/php-monolog-formatted-psr-handler)

### Installation ###

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/monolog-formatted-psr-handler 
```

## Difference with Monolog's PsrHandler ##

Where Monolog's `PsrHandler` uses the `message` from `$record`, this handlers uses `formatted` and falls back to `message`.

## Usage ##

```php
$psrHandler = new PsrLogger(); // Your desired PSR-3 logger
$handler = new FormattedPsrHandler($psrHandler);
$handler->setFormatter(new Formatter()); // Your desired formatter
$monolog->pushHandler($handler);
```

## Contributing ##

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License ##

Copyright 2017 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
