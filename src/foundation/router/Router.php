<?php

namespace Bandama\Foundation\Router;

/**
 * Route HTTP request to corresponding callable
 *
 * @package Bandama
 * @subpackage Foundation\Router
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.1 Adding getters for fields
 * @since 1.0.0 Class creation
 */
class Router {
    // Fields
	/**
	 * @var array Collection of routes without name
	 */
	private $routes = array();

	/**
	 * @var array Collection of named routes
	 */
	private $namedRoutes = array();


	// Properties
	/**
	 * Get all routes
	 *
	 * @return array
	 */
	public function getRoutes() {
		return $this->routes;
	}

	/**
	 * Get named routes
	 *
	 * @return array
	 */
	public function getNamedRoutes() {
		return $this->namedRoutes;
	}


    // Constructors
	public function __construct() {
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
	 * Execute a callable of route that matchs the URL
	 *
	 * @param string $url HTTP request URL
	 *
	 * @throws RouterException When HTTP method doesn't exists or no route found
	 *
	 * @return mixed
	 */
	public function route($url) {
		if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
			throw new RouterException("REQUEST_METHOD does not exist : url = $url");
		}

		foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
			$matches = $route->match($url);

			if (is_array($matches)) {
				return $route->execute($matches);
			}
		}

		throw new RouterException("No route matches the URL $url");
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
			throw new RouterException("No route matches this name : $name");
		}

		return $this->namedRoutes[$name]->getUrl($params);
	}


    // Private Methods

	/**
	 * Add route to collection of routes, implements Fluent design pattern
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

		// If the route has a name, add to named routes collection
		if ($name) {
			$this->namedRoutes[$name] = $route;
		}

		return $route;
	}

}
