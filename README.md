# Bandama Framework

[![Latest Stable Version](https://poser.pugx.org/bandama/framework/v/stable)](https://packagist.org/packages/bandama/framework)
[![Build Status](https://travis-ci.org/bandama-framework/bandama-framework.svg?branch=master)](https://travis-ci.org/bandama-framework/bandama-framework)
[![Total Downloads](https://poser.pugx.org/bandama/framework/downloads)](https://packagist.org/packages/bandama/framework)
[![License](https://poser.pugx.org/bandama/framework/license)](https://packagist.org/packages/bandama/framework)

Bandama is a PHP micro-framework to create Web Applications and Web APIs


## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install Bandama Framework.

```bash
$ composer require bandama/framework "1.2.*"
```

This will install Bandama Framework and all required dependencies. Bandama Framework requires PHP 5.5 or newer.

You can also install Bandama Framework by [downloading it](https://github.com/bandama-framework/bandama-framework/archive/master.zip)


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
* Translator


## Tests

Unit tests use [Kahlan](https://github.com/kahlan/kahlan). To execute the tests, type

```bash
$ php vendor/bin/kahlan --reporter=verbose --coverage=4
```

## Change log

* 1.2.3
    - Allow registration of many types of flash messages
* 1.2.2
    - Bug fixed when deleting base URI
* 1.2.1
    - Adding registerComponents method to application bootstrap methods (setup method)
* 1.2.0
    - Adding translator component
    - Using [Kahlan](https://github.com/kahlan/kahlan) for unit tests
* 1.1.2
    - Making getInstance method of App class inheritable
    - Adding test index.php in root directory
    - Remove index.php entry in .gitignore file
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
