<?php

class Container {
	static protected $services = array();

	static public function set($name, $service) {
		if (!is_object($service)) {
			throw new \InvalidArgumentException("Only objects can be registered with the container.");
		}
		if (!in_array($service, self::$services, true)) {
			self::$services[$name] = $service;
		}
		return $this;
	}

	static public function get($name, array $params = array()) {
		if (!isset(self::$services[$name])) {
			throw new \RuntimeException("The service $name has not been registered with the container.");
		}
		$service = self::$services[$name];
		return !$service instanceof \Closure ? $service : call_user_func_array($service, $params);
	}

	static public function has($name) {
		return isset(self::$services[$name]);
	}

	static public function remove($name) {
		if (isset(self::$services[$name])) {
			unset(self::$services[$name]);
		}
		return $this;
	}

	static public function clear() {
		self::$services = array();
	}
}
