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
 * @version 1.0.1
 * @since 1.0.1 Adding addService method
 * @since 1.0.0 Class creation
 */
class App {
    // Fields
    /**
     * @var string Application execution mode (development, preproduction, production)
     */
    protected $mode;


    /**
     * @var array Application configuration file
     */
    protected $configFile;

    /**
     * @var Bandama\Foundation\DependecyInjection/Container Dependency injection container
     */
    protected $container = null;

    /**
     * @var string Base URI of application URLs
     */
    protected $baseUri = '/';

    /**
     * @var App Uniq instance of App class
     */
    protected static $_instance;


    // Constants
    const APP_MODE_DEV = 'dev';
    const APP_MODE_PREPROD = 'preprod';
    const APP_MODE_PROD = 'prod';


    // Properties
    /**
     * Return a dependency injection container
     *
     * @return Bandama\Foundation\DependecyInjection/Container
     */
    public function getContainer() {
        return $this->container;
    }

    /**
     * Return application execution mode
     *
     * @return string
     */
    public function getMode() {
        return $this->mode;
    }

    /**
     * Return path to application configuration file
     *
     * @return string
     */
    public function getConfigFile() {
        return $this->configFile;
    }


    // Constructors
    /**
     * Default constructor
     *
     * @param array $configFile Application configuration file
     *
     * @return void
     */
    protected function __construct($configFile, $mode) {
        $this->configFile = $configFile;
        $this->mode = $mode;
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
    public static function getInstance($configFile = null, $mode = self::APP_MODE_PROD) {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($configFile, $mode);
        }

        return self::$_instance;
    }

    /**
     * Run Bandama application
     *
     * @return mixed
     */
    public function run() {
        // Start session
        $session = $this->get('session');
        $session->start();

        // Route the request
        $uri = '';
        if (strcmp($this->mode, self::APP_MODE_DEV) == 0) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            $uri = $_GET['url'];
        }

        $uri = substr($uri, $this->baseUri);

        $this->get('router')->route($uri);
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

    /**
     * Add an instance of class in container with custom key
     *
     * @return void
     */
    public function addService($key, $callable) {
        $container = $this->container;
        $instance = Container::newInstance($callable);
        $this->container->set($key, function() use ($instance) {
            return $instance;
        });
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
            $session = new Session();
            $session->start();

            return $session;
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
