<?php

namespace Bandama;

use Bandama\Foundation\DependencyInjection\Container;
use Bandama\Foundation\Router\Router;
use Bandama\Foundation\Database\Connection;
use Bandama\Foundation\Session\Session;
use Bandama\Foundation\Session\Cookie;

/**
 * Implements Bandama application logic, implements Singleton design pattern
 *
 * @package Bandama
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class App {
    // Fields
    /**
     * @var array Application settings
     */
    private $settings;

    /**
     * @var Bandama\Foundation\DependecyInjection/Container Dependency injection container
     */
    private $container = null;


    // Constructors
    /**
     * Default constructor
     *
     * @return void
     */
    public function __construct() {
    }


    // Public Methods
    /**
     * Run Bandama application
     *
     * @return mixed
     */
    public function run() {
        $this->router->route($_GET['url']);
    }


    // Private Methods
    /**
     * Setup application settings
     *
     * @param array $settings Application settings
     *
     * @return void
     */
    private function setup($settings = null) {
        $this->settings = $settings;

        if ($this->settings != null && is_array($this->settings)) {

        } else {
            $this->container = new Container();

            $this->container->set('config', function() {
                new Config();
            });

            $this->container->set('router', function() {
                new Router();
            });
            
            $this->container->set('session', function() {
                return new Session();
            });

            $this->container->set('cookie', function() {
                return new Cookie();
            });
        }
    }
}