<?php

namespace Bandama\Foundation\Session;

/**
 * Class for managing session variables, implements SessionInterface
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @see SessionInterface
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Session implements SessionInterface {
    // Constructors
    /**
     * Default constructor
     *
     * @return void
     */
    public function __construct() {
        if (!session_id()) {
            session_start();
        }
    }


    // Overrides
    /**
     * @see SessionInterface::get
     */
    public function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    /**
     * @see SessionInterface::set
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * @see SessionInterface::delete
     */
    public function delete($key) {
        unset($_SESSION[$key]);
    }
}