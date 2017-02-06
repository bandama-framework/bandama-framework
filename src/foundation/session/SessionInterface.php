<?php

namespace Bandama\Foundation\Session;

/**
 * Interface for managing storageable values
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
interface SessionInterface {
    /**
     * Get a value from the storage
     *
     * @param string $key Key of the value
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Set variable into storage
     *
     * @param string $key Key of the value
     * @param mixed $value Value of the value
     *
     * @return void
     */
    public function set($key, $value);

    /**
     * Remove a value from storage
     *
     * @return void
     */
    public function delete($key);
}