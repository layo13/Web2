<?php

namespace Library;

class Router {
	private $routes;
	
	public function __construct() {
		$this->routes = array();
	}
	
	public function getMatchedRoute($requestUri, $requestMethod, &$vars) {
		foreach($this->routes as $route) {
			$isMatched = $route->isMatched($requestUri, $requestMethod, $vars);
			if ($isMatched == true) {
				return $route;
			}
		}
		return null;
	}
	
	/**
	 * 
	 * @param Route $route
	 */
	public function addRoute(Route $route) {
		$this->routes[] = $route;
	}
	/**
	 * 
	 * @return array
	 */
	public function getRoutes() {
		return $this->routes;
	}
}