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
