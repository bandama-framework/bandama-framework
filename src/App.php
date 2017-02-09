<?php

namespace Bandama;

use Bandama\Foundation\DependencyInjection\Container;
use Bandama\Foundation\Router\Router;
use Bandama\Foundation\Database\Connection;
use Bandama\Foundation\Session\Session;
use Bandama\Foundation\Session\Cookie;
use Bandama\Foundation\Session\Flash;


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
     * @var array Application configuration file
     */
    protected $configFile;

    /**
     * @var Bandama\Foundation\DependecyInjection/Container Dependency injection container
     */
    protected $container = null;

    /**
     * @var App Uniq instance of App class
     */
    protected static $_instance;


    // Properties
    /**
     * Return a dependency injection container
     *
     * @return Bandama\Foundation\DependecyInjection/Container
     */
    public function getContainer() {
        return $this->container;
    }


    // Constructors
    /**
     * Default constructor
     *
     * @param array $configFile Application configuration file
     *
     * @return void
     */
    protected function __construct($configFile) {
        $this->configFile = $configFile;
        $this->setup();
    }


    // Public Methods
    /**
     * Initialize and return App uniq instance
     *
     * @param array $configFile Application configuration file
     *
     * @return App
     */
    public static function getInstance($configFile = null) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($configFile);
        }

        return self::$_instance;
    }

    /**
     * Run Bandama application
     *
     * @return mixed
     */
    public function run() {
        $this->get('router')->route($_GET['url']);
    }

    /**
	 * Get an entry by key from dependency injection container
	 *
	 * @param string $key Key of entry
	 *
	 * @return Callable|Object
	 */
    public function get($key) {
        return $this->container->get($key);
    }


    // Private Methods
    /**
     * Setup application settings
     *
     * @param array $settings Application settings
     *
     * @return void
     */
    protected function setup() {
        $container = new Container();
        $config = new Configuration($this->configFile);

        $container->set('config', function() use ($config) {
                return $config;
        });

        $container->set('session', function() {
            return new Session();
        });

        $container->set('router', function() {
            return new Router();
        });

        $container->set('cookie', function() {
            return new Cookie();
        });
        
        $container->set('flash', function() use ($container) {
            return new Flash($container->get('session'));
        });

        $this->container = $container;
    }
}