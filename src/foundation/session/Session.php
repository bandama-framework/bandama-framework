<?php

namespace Bandama\Foundation\Session;

/**
 * Class for managing session variables, implements SessionInterface
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @see SessionInterface
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.2
 * @since 1.0.2 Refactoring code and adding setName, setId, setHandler, startSession, started and destroySession methods
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
     * @return bool
     */
    public function start($name = null, $id = null, \SessionHandlerInterface $handler = null) {
        if (!$this->getId()) {
            if ($name !== null) {
                $this->setName($name);
            }

            if ($id !== null) {
                $this->setId($id);
            }

            if ($handler !== null) {
                $this->setHandler($handler);
            }

            return $this->startSession();
        }
    }

    /**
     * Check if the session is started for current user
     *
     * @return bool
     */
    public function started() {
        $id = $this->getId();

        return $id != null && !empty($id);
    }

    /**
     * Destroy current session
     *
     * @return void
     */
    public function destroy() {
        if ($this->getId()) {
            // Clear all session variables
            $_SESSION = array();

            // Delete session cookie
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie($this->getName(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Destroy session
            $this->destroySession();
        }
    }


    // Private Methods
    /**
     * Define new session name and return old session name
     *
     * @return string
     */
    private function setName($name) {
        return session_name($name);
    }

    /**
     * Define session id
     *
     * @return void
     */
    private function setId($id) {
        session_id($id);
    }

    /**
     * Register session handler
     *
     * @return void
     */
    private function setHandler(\SessionHandlerInterface $handler) {
        session_set_save_handler($handler, true);
    }

    /**
     * Start new session
     *
     * @return bool
     */
    private function startSession() {
        return session_start();
    }

    /**
     * Destroy current session
     *
     * @return bool
     */
    private function destroySession() {
        return session_destroy();
    }
}
