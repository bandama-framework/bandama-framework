<?php

namespace Bandama\Foundation\Router;

/**
 * Reprepent a route
 *
 * @package Bandama
 * @subpackage Foundation\Router
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.1
 * @since 1.0.1 Adding getters methods for fields
 * @since 1.0.0 Class creation
 */
class Route {
    // Fields
	/**
	 * @var string HTTP URL path
	 */
	private $path;

	/**
	 * @var string Function or Method of controller to call
	 */
	private $callable;

	/**
	 * Route path parameters conditions
	 *
	 * @var array
	 */
	private $params = array();


	// Properties
	/**
	 * Get path
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Get callable
	 *
	 * @return Callable|string
	 */
	public function getCallable() {
		return $this->callable;
	}

	/**
	 * Get params
	 *
	 * @return array
	 */
	public function getParams() {
		return $this->params;
	}


    // Constructors
	/**
	 * Constructor
	 *
	 * @param string $path HTTP request path
	 * @param string $callable Function or Method of controller to call
	 *
	 * @return void
	 */
	public function __construct($path, $callable) {
		// Remove the start and end slash of path
		$this->path = trim($path, '/');
		$this->callable = $callable;
	}


    // Public Methods

	/**
	 * Add constraint to route parameter, implements Fluent design pattern
	 *
	 * @param string $param URI parameter name
	 * @param string $regex Regular expression to apply to parameter
	 *
	 * @return Router
	 */
	public function with($param, $regex) {
		$this->params[$param] = str_replace('(', '(?:', $regex);
		return $this;
	}

	/**
	 * Test if the current route matches the URL
	 *
	 * @param string $url
	 *
	 * @return boolean|mixed
	 */
	public function match($url) {
		// Remove the start and end slash of URL
		$url = trim($url, '/');
		// Replace path parameters (:parameter) by
		$path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
		// Define the regex patterb with the new path after replaced the parameters of path
		$regex = "#^$path$#i";

		// Check if the url matchs the path
		if (!preg_match($regex, $url, $matches)) {
			return false;
		}

		// Keep only the parameters
		array_shift($matches);

		return $matches;
	}

	/**
	 * Execute the callable of route
	 *
	 * @param array $matches URL parameters
	 *
	 * @return mixed
	 */
	public function execute($matches) {
		if (is_string($this->callable)) { // If the callable is a string, call the action of controller
			$params = explode('#', $this->callable);

            if (count($params) == 2) {
                $controllerPrefix = $params[0];
                $controllerPrefix = str_replace(':', '\\', $controllerPrefix);

    			$controller = $controllerPrefix."Controller";

    			$controller = new $controller();
    			$action = $params[1].'Action';

    			return call_user_func_array(array($controller, $action), $matches);


    			return $controller->$action();

            } else {
                throw new RouterException('Invalid controller name '.$this->callable);
            }

		} else { // If the callable is a function, execute the function
			return call_user_func_array($this->callable, $matches);
		}
	}

	/**
	 * Generate the URL with the parameters
	 *
	 * @param array $params Route parameters
	 *
	 * @return string
	 */
	public function getUrl($params) {
		$path = $this->path;

		foreach ($params as $k => $v) {
			$path = str_replace(":$k", $v, $path);
		}

		return $path;
	}


    // Private Methods
	/**
	 * Return regular expression in parameters conditions (params) of path parameter names or if not
	 * defined in parameters conditions return the parameter value
	 *
	 * @param array $match Array of matches parameters
	 *
	 * @return string
	 */
	private function paramMatch($match) {
		if (isset($this->params[$match[1]])) {
			return '('.$this->params[$match[1]].')';
		}

		return '([^/]+)';
	}

}
