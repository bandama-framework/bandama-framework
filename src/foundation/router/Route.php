<?php

namespace Bandama\Foundation\Router;

/**
 * Reprepent an route
 *
 * @package Bandama
 * @subpackage Foundation\Router
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Route {
    // Fields

	/**
	 * @var string HTTP request path
	 */
	private $path;

	/**
	 * @var string Function or Method of controller to call
	 */
	private $callable;

	/**
	 * @var array
	 */
	private $matches = array();
	private $params = array();


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
		$this->path = trim($path, '/');
		$this->callable = $callable;
	}


    // Public Methods

	/**
	 * Add constraint to route
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
	 *
	 * @param string $url
	 *
	 * @return boolean
	 */
	public function match($url) {
		$url = trim($url, '/');
		$path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);

		$regex = "#^$path$#i";

		if (!preg_match($regex, $url, $matches)) {
			return false;
		}

		array_shift($matches);
		$this->matches = $matches;

		return true;
	}

	/**
	 * @return mixed
	 */
	public function call() {
		if (is_string($this->callable)) {
			$params = explode('#', $this->callable);

            if (count($params) == 2) {
                $controllerPrefix = $params[0];
                $controllerPrefix = str_replace(':', '\\', $controllerPrefix);

    			$controller = $controllerPrefix."Controller";

    			$controller = new $controller();
    			$action = $params[1].'Action';

    			return call_user_func_array(array($controller, $action), $this->matches);


    			return $controller->$action();

            } else {
                throw new RouterException('Invalid controller name '.$this->callable);
            }

		} else {
			return call_user_func_array($this->callable, $this->matches);
		}
	}

	/**
	 * @param array $params
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
	 * @param array $match
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
