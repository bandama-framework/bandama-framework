<?php

namespace Bandama\Foundation\DependencyInjection;

use \ReflectionClass;
use \Exception;

/**
 * Dependency Injection Container class
 *
 * @package Bandama
 * @subpackage Foundation\DependencyInjection
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Container {
    // Fields
	/**
	 * @var array Associative array (string, Callable) of classes. Assume uniq instance
	 */
	private $registry;

	/**
	 * @var array Associative array (string, Callable) of classes. Assume new instance each get
	 */
	private $factories;

	/**
	 * @var array Associative array (string, Object) of classes.
	 */
	private $instances;


	// Properties
	/**
	 * Get registry
	 *
	 * @return array
	 */
	public function getRegistry() {
		return $this->registry;
	}

	/**
	 * Get factories
	 *
	 * @return array
	 */
	public function getFactories() {
		return $this->factories;
	}

	/**
	 * Get instances
	 *
	 * @return array
	 */
	public function getInstances() {
		return $this->instances;
	}


    // Constructors

	/**
	 * Default constructor
	 *
	 * @return void
	 */
    public function __construct() {
        $this->registry = array();
        $this->factories = array();
        $this->instances = array();
    }


    // Public Methods

	/**
	 * Add new entry in registries. Assume the same instance of key is returned if exist
	 *
	 * @param string $key Key of entry
	 * @param Callable $resolver Callable of entry
	 *
	 * @return void
	 */
	public function set($key, Callable $resolver) {
		$this->registry[$key] = $resolver;
	}

	/**
	 * Add new entry in factories. Assume a new instance of key is returned at each get
	 *
	 * @param string $key Key of entry
	 * @param Callable $resolver Callable of entry
	 *
	 * @return void
	 */
	public function setFactory($key, Callable $resolver) {
		$this->factories[$key] = $resolver;
	}

	/**
	 * Add new entry in instances.
	 *
	 * @param string $key Key of entry
	 * @param Callable $resolver Callable of entry
	 *
	 * @return void
	 */
	public function setInstance($instance) {
		$reflection = new ReflectionClass($instance);
		$name = str_replace('\\', ':', $reflection->getName());
		$this->instances[$name] = $instance;
	}

	/**
	 * Get an entry by key
	 *
	 * @param string $key Key of entry
	 *
	 * @return Callable|Object
	 */
	public function get($key) {
		// If the key is in factories the return new instance of class
		if (isset($this->factories[$key])) {
			return $this->factories[$key]();
		}

		// If the key is not in instances
		if (!isset($this->instances[$key])) {
			// If the key is in registry, instanciate the corresponding class and add it in instances
			if (isset($this->registry[$key])) {
				$this->instances[$key] = $this->registry[$key]();
			} else {
				// If the key is not in registry, instanciate the corresponding class and add it in instances
				$className = str_replace(':', '\\', $key);
				$reflectedClass = new ReflectionClass($className);

				if ($reflectedClass->isInstantiable()) {
					$constructor = $reflectedClass->getConstructor();

					if ($constructor) {
						$parameters = $constructor->getParameters();
						$constructorParameters = array();

						foreach ($parameters as $parameter) {
							if ($parameter->getClass()) {
								$constructorParameters[] = $this->get($parameter->getClass()->getName());
							} else {
								$constructorParameters[] = $parameter->getDefaultValue();
							}
						}

						$this->instances[$key] = $reflectedClass->newInstanceArgs($constructorParameters);
					} else {
						$this->instances[$key] = $reflectedClass->newInstance();
					}

				} else {
					throw new Exception($key." is not instantiable Class");
				}
			}
		}

		return $this->instances[$key];
	}

}
