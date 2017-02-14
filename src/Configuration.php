<?php

namespace Bandama;


/**
 * Configuration class
 *
 * @package Bandama
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.1
 * @since 1.0.1 Adding getters for properties
 * @since 1.0.0 Class creation
 */
class Configuration {
    // Fields
    /**
     * @var array Configuration settings
     */
    private $settings = array();


    // Properties
    /**
     * Return configuration parameters
     *
     * @return array;
     */
    public function getSettings() {
        return $this->settings;
    }


    // Constructors
    /**
     * Default constructor
     *
     * @return void
     */
    public function __construct($configFile) {
        if ($configFile != null && !empty($configFile)) {
            $this->settings = require($configFile);
        }
    }


    // Public Methods
    /**
     * Get configuration parameter by key if exists else return null
     *
     * @return mixed
     */
    public function get($key) {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }

        return null;
    }
}
