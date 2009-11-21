<?php

class Router {	
	function route() {
		$path = parse_url(
		     (isset($_SERVER["HTTPS"]) ? "https" : "http") . "://" .  
		     $_SERVER["HTTP_HOST"] .    
		     $_SERVER["REQUEST_URI"]
		);

		$parsePathString = explode("/", substr($path["path"], 1));
		$controller = (@$parsePathString[0]) ? $parsePathString[0] : "Homepage";
		if (sizeof($parsePathString) > 1) {
			$module = strtolower($parsePathString[1]);
		}
		else {
			$module = "index";
		}
		

		$class = $controller . "Controller";
		$controller = new $class;
		$method = "{$module}Action";
		$controller->$method();
		$controller->go();		
	}
	
}

?>