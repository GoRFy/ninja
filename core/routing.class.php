<?php
class routing{
	public static function setRouting()
	{
		$uri = $_SERVER['REQUEST_URI'];

		$explode_uri = explode("?", $uri);
		$uri = $explode_uri[0];

		$uri = trim(str_replace("ninja","",$uri),"/");

		$explode_uri = explode("/", $uri);

		$controller = (!empty($explode_uri[0]))?$explode_uri[0]:"index";
		$action = (!empty($explode_uri[1]))?$explode_uri[1]:"index";

		unset($explode_uri[0]);
		unset($explode_uri[1]);
		$args = array_merge($explode_uri, $_REQUEST);
		$_SESSION['controller'] = $controller;
		return ["controller" => $controller, "action" => $action, "args" => $args];
	}
}
