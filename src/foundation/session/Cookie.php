<?php

namespace Bandama\Foundation\Session;

/**
 * Class for managing cookie variables, implements SessionInterface
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @see SessionInterface
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Cookie implements SessionInterface {
    // Overrides
    /**
     * Get variable from storage
     *
     * @see SessionInterface::get
     */
    public function get($key) {
        return isset($_COOKIE[$key]) ? unserialize($_COOKIE[$key]) : null;
    }

    /**
     * Set variable to storage
     *
     * @see SessionInterface::set
     */
    public function set($key, $value) {
        setcookie($key, serialize($value));
    }

    /**
     * Remove variable from storage
     *
     * @see SessionInterface::delete
     */
    public function delete($key) {
        if (isset($_COOKIE[$key])) {
            unset($_COOKIE[$key]);
            setcookie($key, '', time() - 3600);
        }
    }
}   