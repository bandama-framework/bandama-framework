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
 * @version 1.0.2
 * @since 1.0.2 Making getInstance method inheritable
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
    protected $baseUri = '';

    /**
     * @var App Uniq instance of App class
     */
    protected static $_instances = array();


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
     * Register configuration file and application mode, setup application
     *
     * @param array $configFile Application configuration file
     *
     * @return void
     */
    protected function __construct($configFile, $mode) {
        $this->configFile = $configFile;
        $this->mode = $mode;
        $this->container = new Container();
    }


    // Public Methods
    public final function __clone() {
        throw new \Exception('Cloning is not allowed');
    }

    /**
     * Initialize and return App uniq instance
     *
     * @param array $configFile Application configuration file
     *
     * @return App
     */
    public static function getInstance($configFile = null, $mode = self::APP_MODE_PROD) {
        $c = get_called_class();
        if (!isset(self::$_instances[$c])) {
            // Create an instance
            self::$_instances[$c] = new $c($configFile, $mode);
            // Setup application
            self::$_instances[$c]->setup();
        }

        return self::$_instances[$c];
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

        $uri = substr($uri, strlen($this->baseUri));

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
        $instance = Container::newInstance($callable);
        $this->container->set($key, function() use ($instance) {
            return $instance;
        });
    }


    // Private Methods
    /**
     * Setup application following theses steps (implements Template method design pattern)
     * - Register configuration
     * - Register router
     * - Register session object
     * - Register cookie object
     * - Register session flash object
     *
     * @param array $settings Application settings
     *
     * @return void
     */
    protected function setup() {
        // Register application services
        $this->registerConfig();
        // Register router component
        $this->registerRouter();
        // Register session object
        $this->registerSession();
        // Register cookie object
        $this->registerCookie();
        // Register flash object
        $this->registerFlash();
    }

    /**
     * Create and add config in container
     *
     * @return void
     */
    protected function registerConfig() {
        $config = new Configuration($this->configFile);
        $this->container->set('config', function() use ($config) {
                return $config;
        });
    }

    /**
     * Create and add router to container
     *
     * @return void
     */
    protected function registerRouter() {
        $this->container->set('router', function() {
            return new Router();
        });
    }

    /**
     * Create and add session to container
     *
     * @return void
     */
    protected function registerSession() {
        $this->container->set('session', function() {
            $session = new Session();
            $session->start();

            return $session;
        });
    }

    /**
     * Create and add cookie to container
     *
     * @return void
     */
    protected function registerCookie() {
        $this->container->set('cookie', function() {
            return new Cookie();
        });
    }

    /**
     * Create and add session flash object to container
     *
     * @return void
     */
    protected function registerFlash() {
        $container = $this->container;
        $this->container->set('flash', function() use ($container) {
            return new Flash($container->get('session'));
        });
    }
}
