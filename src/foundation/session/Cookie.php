<?php

namespace Bandama\Foundation\Session;

/**
 * Class for managing cookie variables, implements SessionInterface
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @see SessionInterface
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.1
 * @since 1.0.1 Implementing $params parameters of set method
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
     * @var string $key Key
     * @var mixed $value Value
     * @var array $params Parameters (expire, path, domain, secure, httponly)
     *
     * @see SessionInterface::set
     */
    public function set($key, $value, $params = array()) {
        $expire = 0;
        $path = null;
        $domain = null;
        $secure = false;
        $httponly = false;

        if (isset($params['expire'])) {
            $expire = $params['expire'];
        }
        if (isset($params['path'])) {
            $path = $params['path'];
        }
        if (isset($params['domain'])) {
            $domain = $params['domain'];
        }
        if (isset($params['secure'])) {
            $secure = $params['secure'];
        }
        if (isset($params['httponly'])) {
            $httponly = $params['httponly'];
        }

        setcookie($key, serialize($value), $expire, $path, $domain, $secure, bool $httponly);
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
