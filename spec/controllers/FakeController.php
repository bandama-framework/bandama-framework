<?php

namespace Bandama\Test;

class FakeController extends \Bandama\Foundation\Controller\Controller {

    public function indexAction() {
        echo 'Hello world';
    }

    public function helloAction($name) {
        echo "Hello $name";
    }

}
