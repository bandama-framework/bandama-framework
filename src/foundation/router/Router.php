<?php

namespace Bandama\Foundation\Router;

/**
 * Route HTTP request to corresponding callable
 *
 * @package Bandama
 * @subpackage Foundation\Router
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Router {
    // Fields

	/**
	 * @var string HTTP request URL
	 */
	private $url;

	/**
	 * @var array Collection of routes without name
	 */
	private $routes = array();

	/**
	 * @var array Collection of named routes
	 */
	private $namedRoutes = array();


    // Constructors
	public function __construct($url) {
		$this->url = $url;
	}


    // Public Methods

	/**
	 * Add HTTP GET method route
	 *
	 * @see Router::add
	 */
	public function get($path, $callable, $name = null) {
		return $this->add($path, $callable, $name, 'GET');
	}

	/**
	 * Add HTTP POST method route
	 *
	 * @see Router::add
	 */
	public function post($path, $callable, $name = null) {
		return $this->add($path, $callable, $name, 'POST');
	}

	/**
	 * Add HTTP PUT method route
	 *
	 * @see Router::add
	 */
	public function put($path, $callable, $name = null) {
		return $this->add($path, $callable, $name, 'PUT');
	}

	/**
	 * Add HTTP DELETE method route
	 *
	 * @see Router::add
	 */
	public function delete($path, $callable, $name = null) {
		return $this->add($path, $callable, $name, 'DELETE');
	}

	/**
	 * Route HTTP request to callable
	 *
	 * @throws RouterException When HTTP method doesn't exists or no route found
	 *
	 * @return mixed
	 */
	public function route() {
		if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
			throw new RouterException('REQUEST_METHOD does not exist : url = ');
		}

		foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
			if ($route->match($this->url)) {
				return $route->call();
			}
		}

		throw new RouterException('No route matches');
	}

	/**
	 * Generate URL
	 *
	 * @param string $name Name of route
	 * @param array $params Parameters of route
	 *
	 * @return string
	 */
	public function url($name, $params = array()) {
		if (!isset($this->namedRoutes[$name])) {
			throw new RouterException('No route matches this name');
		}

		return $this->namedRoutes[$name]->getUrl($params);
	}


    // Private Methods

	/**
	 * Add route to collection of routes
	 *
	 * @param string $path HTTP request path
	 * @param string $callable Class method or function to call
	 * @param string $name Name of route
	 * @param string $method HTTP method e.g (GET, POST, PUT, DELETE, etc.)
	 *
	 * @return Route
	 */
	private function add($path, $callable, $name, $method) {
		$route = new Route($path, $callable);

		$this->routes[$method][] = $route;

		if (is_string($callable) && $name === null) {
			$name = $callable;
		}

		if ($name) {
			$this->namedRoutes[$name] = $route;
		}

		return $route;
	}

}
