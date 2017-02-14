<?php

namespace Bandama\Test;

class FakeController extends \Bandama\Foundation\Controller\Controller {

    public function indexAction() {
        return 'home';
    }

    public function helloAction($name) {
        return "Hello $name";
    }

}
