# Bandama Framework

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/jfyoboue/bandama-framwork/blob/develop/LICENSE.md)
[![Coverage Status](https://coveralls.io/repos/github/jfyoboue/bandama-framework/badge.svg)](https://coveralls.io/github/jfyoboue/bandama-framework)

Bandama is a PHP micro-framework to create Web Applications and Web APIs

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Bandama.

```bash
$ composer require bandama/framework "^1.0"
```

This will install Bandama and all required dependencies. Bandama requires PHP 5.3.2 or newer.

## Usage

Create an index.php file with the following contents:

```php
<?php

require(__DIR__.'/vendor/autoload.php');


$app = Bandama\App::getInstance(null, Bandama\App::APP_MODE_DEV);
$router = $app->get('router');

$router->get('/hello/:name', function($name) {
    echo "<pre> Hello, $name";
});

$app->run();
```

You may quickly test this using the built-in PHP server:
```bash
$ php -S localhost:8008
```

Going to http://localhost:8008/hello/world will now display "Hello, world".


## Tests

To execute the test suite, you'll need phpunit.

```bash
$ vendor/bin/phpunit
```

## Credits

- [Jean-François YOBOUE](https://github.com/jfyoboue)

## License

The Bandama Framework is licensed under the MIT license. See [License File](LICENSE.md) for more information.