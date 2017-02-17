<?php

namespace Bandama\Foundation\Session;

/**
 * Class for managing session variables, implements SessionInterface
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @see SessionInterface
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.1
 * @since 1.0.1 Adding optional param $name, $id, session handler to constructor, adding getName, getId methods
 * @since 1.0.0 Class creation
 */
class Session implements SessionInterface {
    // Constructors
    /**
     * Constructor
     *
     * @param string $name Name of session
     *
     * @return void
     */
    public function __construct($name = null, $id = null, \SessionHandlerInterface $handler = null) {
        if (!session_id()) {
            if ($name !== null) {
                session_name($name);
            }

            if ($id !== null) {
                session_id($id);
            }

            if ($handler !== null) {
                session_set_save_handler($handler, true);
            }

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
    public function set($key, $value, $params = array()) {
        $_SESSION[$key] = $value;
    }

    /**
     * @see SessionInterface::delete
     */
    public function delete($key) {
        unset($_SESSION[$key]);
    }

    // Public Methods
    /**
     * Return current name of session
     *
     * @return string
     */
    public function getName() {
        return session_name();
    }

    /**
     * Return current session id
     *
     * @return string
     */
    public function getId() {
        return session_id();
    }
}
