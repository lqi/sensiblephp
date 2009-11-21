<?php

	define("PROJECT_DIR", dirname(getcwd()) . "/");
	define("CORE_DIR", PROJECT_DIR . "core/");
	define("FIELD_DIR", PROJECT_DIR . "core/fields/");
	define("CONFIG_DIR", PROJECT_DIR . "conf/");
	define("MODELS_DIR", PROJECT_DIR . "models/");
	define("VIEWS_DIR", PROJECT_DIR . "views/");
	define("CONTROLLERS_DIR", PROJECT_DIR . "controllers/");
	define("DB_BUSINESS_DIR", PROJECT_DIR . "db/");
	
	set_include_path(
		CORE_DIR . PATH_SEPARATOR .
		FIELD_DIR . PATH_SEPARATOR . 
		CONFIG_DIR . PATH_SEPARATOR .
		CONTROLLERS_DIR . PATH_SEPARATOR . 
		VIEWS_DIR . PATH_SEPARATOR . 
		MODELS_DIR . PATH_SEPARATOR . 
		DB_BUSINESS_DIR . PATH_SEPARATOR .
		get_include_path());
	
	date_default_timezone_set(TIMEZONE);

	function __autoload($className) {
		require("$className.class.php");
	}
	
	function errorHandler($errno, $errstr, $errfile, $errline) {
		if (DEBUG) {
	    echo " <b>Error:</b><br />" .
	 			$errno . "<br />" . 
				$errstr . "<br />" . 
				$errfile . "<br />" .
				$errline . "<br />";
		}
		else {
			exceptionHandler("");
		}
		exit();
	}
	
	function exceptionHandler($exception) {
		if (DEBUG) {
			echo " <b>Exception:</b><br />" . $exception->getMessage() . "<br />";
		}
		else {
			echo "<h1>Service Unavailable.</h1>";
		}
		exit();
	}
	
	set_error_handler("errorHandler");
	set_exception_handler('exceptionHandler');
	
	$router = new Router;
	$router->route();
	
?>