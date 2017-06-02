<?php

namespace Bandama\Test;


class FakeParametrizedConstructor {
    private $id;
    private $name;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function __construct($id = 0, $name = '') {
        $this->id = $id;
        $this->name = $name;
    }
}
