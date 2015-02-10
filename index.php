<?php

//error_reporting(E_ALL);

function autoload($class) {
	$file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

	if (is_file($file)) {
		require ($file);
	} else {
		return;
	}
}

spl_autoload_register('autoload');

if (key_exists("WINDIR", $_SERVER)) {
	$requestUri = str_replace("/Web2", "", $_SERVER["REQUEST_URI"]);
	$url = "http://localhost/Web2/";
} else {
	$requestUri = $_SERVER["REQUEST_URI"];
	$url = "http://codebox.lionelguissani.fr/";
}
$requestMethod = $_SERVER["REQUEST_METHOD"];

//var_dump($requestUri, $requestMethod);

use Library\Router;
use Library\Route;

$doc = new DOMDocument("1.0", "UTF-8");
$doc->load(__DIR__ . "/routes.xml");
$router = new Router();

foreach ($doc->getElementsByTagName("route") as $domRoute) {
	$route = new Route($domRoute);
	$router->addRoute($route);
}

$vars = array();
$matchedRoute = $router->getMatchedRoute($requestUri, $requestMethod, $vars);
if ($matchedRoute !== null) {
	$controllerName = "Library\\Controller\\" . $matchedRoute->getModule() . "Controller";
	$action = $matchedRoute->getAction() . "Action";
	$controller = new $controllerName();
	$return = call_user_func_array(array($controller, $action), $vars);

	if (is_null($return)) {
		exit;
	} else {
		exit($return);
	}
} else {
	header('HTTP/1.0 404 Not Found');
	require("404.php");
}
