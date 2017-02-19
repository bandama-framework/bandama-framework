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
 * @since 1.0.1 Adding getName, getId, start, destroy methods
 * @since 1.0.0 Class creation
 */
class Session implements SessionInterface {
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
        $_SESSION[$key] = null;
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

    /**
     * Start a new session
     *
     * @param string $name Name of session
     * @param string $id Session id
     * @param \SessionHandlerInterface Session handler
     *
     * @return void
     */
    public function start($name = null, $id = null, \SessionHandlerInterface $handler = null) {
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

    /**
     * Destroy current session
     *
     * @return void
     */
    public function destroy() {
        // Clear all session variables
        $_SESSION = array();

        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy session
        session_destroy();
    }
}
