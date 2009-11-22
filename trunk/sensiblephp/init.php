<?php

	define("PROJECT_DIR", dirname(dirname(__file__)) . "/");
	define("SENSIBLE_PHP_DIR", PROJECT_DIR . "sensiblephp/");
	define("CORE_DIR", SENSIBLE_PHP_DIR . "core/");
	define("FIELD_DIR", SENSIBLE_PHP_DIR . "fields/");
	define("ADMIN_BIN_DIR", SENSIBLE_PHP_DIR . "admin/");
	define("CONFIG_DIR", PROJECT_DIR . "conf/");
	define("MODELS_DIR", PROJECT_DIR . "models/");
	define("VIEWS_DIR", PROJECT_DIR . "views/");
	define("CONTROLLERS_DIR", PROJECT_DIR . "controllers/");
	define("DB_BUSINESS_DIR", PROJECT_DIR . "db/");
	
	set_include_path(
		CORE_DIR . PATH_SEPARATOR .
		FIELD_DIR . PATH_SEPARATOR .
		ADMIN_BIN_DIR . PATH_SEPARATOR .
		CONFIG_DIR . PATH_SEPARATOR .
		CONTROLLERS_DIR . PATH_SEPARATOR . 
		VIEWS_DIR . PATH_SEPARATOR . 
		MODELS_DIR . PATH_SEPARATOR . 
		DB_BUSINESS_DIR . PATH_SEPARATOR .
		get_include_path());
	
	function getDebugModel() {
		$generalSettings = new Settings;
		return ($generalSettings->debug != null) ? $generalSettings->debug : false;
	}
	
	function getTimezone() {
		$generalSettings = new Settings;
		return ($generalSettings->timezone != null) ? $generalSettings->timezone : "America/Los_Angeles";
	}
	
	function errorHandler($errno, $errstr, $errfile, $errline) {
		if (getDebugModel()) {
	    echo " <b>Error:</b><br />" .
	 			$errno . "<br />" . 
				$errstr . "<br />" . 
				$errfile . "<br />" .
				"Error line: " . $errline . "<br />";
		}
		else {
			exceptionHandler("");
		}
		exit();
	}
	
	function exceptionHandler($exception) {
		if (getDebugModel()) {
			echo " <b>Exception:</b><br />" . $exception->getMessage() . "<br />";
		}
		else {
			echo "<h1>Service Unavailable.</h1>";
		}
		exit();
	}

	function __autoload($className) {
		require("$className.class.php");
	}	

	date_default_timezone_set(getTimezone());
	
	set_error_handler("errorHandler");
	set_exception_handler('exceptionHandler');
	
	function init() {
		$router = new Router;
		$router->route();
	}
	
?>