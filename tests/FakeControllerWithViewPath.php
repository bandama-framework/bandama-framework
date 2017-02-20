<?php

namespace Bandama\Test;


class FakeControllerWithViewPath extends \Bandama\Foundation\Controller\Controller {
    public function __construct() {
        parent::__construct();

        $this->viewPath = __DIR__.'/views';
    }

    public function indexAction() {
        $this->render('home:fake-view-without-variable.php');
    }

    public function helloAction($name) {
        $this->render('home:fake-view-with-variable.php', array('name' => $name));
    }
}
