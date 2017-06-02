<?php

namespace Bandama\Test;


class FakePerson {
    private $address;

    public function getAddress() {
        return $this->address;
    }

    public function __construct(FakeAddress $address) {
        $this->address = $address;
    }
}
