<?php

class Route {
	function Route() {
		$path = parse_url(
		     (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://" .  
		     $_SERVER["HTTP_HOST"] .    
		     $_SERVER["REQUEST_URI"]
		);

		$temp = explode("/", substr($path["path"], 1));
		$controller = (@$temp[0]) ? $temp[0] : "Blog";
		$module = strtolower((@$temp[1]) ? $temp[1] : "index");

		$class = $controller . "Controller";
		$controller = new $class;
		$method = "{$module}Action";
		$controller->$method();
		$controller->go();		
	}
	
}

?>