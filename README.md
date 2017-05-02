# Bandama Framework

[![Latest Stable Version](https://poser.pugx.org/bandama/framework/v/stable)](https://packagist.org/packages/bandama/framework)
[![Build Status](https://travis-ci.org/jfyoboue/bandama-framework.svg?branch=master)](https://travis-ci.org/jfyoboue/bandama-framework)
[![Total Downloads](https://poser.pugx.org/bandama/framework/downloads)](https://packagist.org/packages/bandama/framework)
[![License](https://poser.pugx.org/bandama/framework/license)](https://packagist.org/packages/bandama/framework)

Bandama is a PHP micro-framework to create Web Applications and Web APIs


## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Bandama.

```bash
$ composer require bandama/framework "1.1.*"
```

This will install Bandama and all required dependencies. Bandama requires PHP 5.4 or newer.


## Usage

There is an index.php file in root directory with the following contents:

```php
<?php

require(__DIR__.'/vendor/autoload.php');


$app = Bandama\App::getInstance(null, Bandama\App::APP_MODE_DEV);
$router = $app->get('router');

$router->get('/', function() {
    echo "<pre>Bandama Framework</pre>";
});

$router->get('/hello/:name', function($name) {
    echo "<pre> Hello, $name";
});

$app->run();
```

You may quickly test this using the built-in PHP server:
```bash
$ php -S localhost:8008
```

Going to http://localhost:8008 will now display "Bandama Framework".

Going to http://localhost:8008/hello/world will now display "Hello, world".


## Components

* Router
* Session
* PDO Session Handler
* Cookie
* Controller
* Dependency Injection Container
* Database Connection
* Query Builder


## Tests

To execute the test suite, you'll need phpunit. If you are phpunit installed globally on your computer, type

```bash
$ phpunit
```

Else, run

```bash
$ php bin/phpunit
```

## Change log

* 1.1.1
    - Removing user_id column in sessions table
* 1.1.0
    - Moving application setup method of App class from constructor to getInstance method
* 1.0.10
    - Improvement of App setup method
* 1.0.9
    - Bug fixed in App class
* 1.0.8
    - Adding base URI Management in App class
* 1.0.7
    - Bug fixed in render method of Controller class
* 1.0.6
    - Adding static method newInstance to container class
    - Adding addService method to App class
* 1.0.5
    - Adding PDO Session Handler for relationnal database session management

## Credits

- [Jean-François YOBOUE](https://github.com/jfyoboue)

## License

The Bandama Framework is licensed under the MIT license. See [License File](LICENSE.md) for more information.
