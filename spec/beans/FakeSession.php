<?php

namespace Bandama\Test;


class FakeSession implements \Bandama\Foundation\Session\SessionInterface {
    // Fields
    private $variables;


    // Constructors
    public function __construct() {
        $this->variables = array();
    }


    // Overrides
    public function get($key) {
        if (array_key_exists($key, $this->variables)) {
            return $this->variables[$key];
        }

        return null;
    }

    public function set($key, $value, $params = array()) {
        $this->variables[$key] = $value;
    }

    public function delete($key) {
        if (array_key_exists($key, $this->variables)) {
            unset($this->variables[$key]);
        }
    }
}