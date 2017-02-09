# Bandama Framework

[![License](https://github.com/jfyoboue/bandama-framwork/blob/develop/LICENSE.md)](https://github.com/jfyoboue/bandama-framwork/blob/develop/LICENSE.md)

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

require 'vendor/autoload.php';

$app = new Slim\App();

$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write("Hello, " . $args['name']);
});

$app->run();
```

You may quickly test this using the built-in PHP server:
```bash
$ php -S localhost:8000
```

Going to http://localhost:8000/hello/world will now display "Hello, world".

For more information on how to configure your web server, see the [Documentation](https://www.slimframework.com/docs/start/web-servers.html).

## Tests

To execute the test suite, you'll need phpunit.

```bash
$ vendor/bin/phpunit
```

## Credits

- [Jean-François YOBOUE](https://github.com/jfyoboue)

## License

The Bandama Framework is licensed under the MIT license. See [License File](LICENSE.md) for more information.