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
	    echo "<b>Error:</b><br />\n" .
				"Error No. " . $errno . "<br />\n" . 
				"Error information: " . $errstr . "<br />\n" . 
				"Error file: " . $errfile . "<br />\n" .
				"Error line: " . $errline . "<br />\n" .
				"<hr />\n" .
				"Reading this means your debug model is on, change it to false in the Settings file, you will get a standard error message.<br />\n";
		}
		else {
			exceptionHandler("");
		}
		exit();
	}
	
	function exceptionHandler($exception) {
		if (getDebugModel()) {
			echo "<b>Exception:</b><br />\n" . $exception->getMessage() . "<br />\n" .
					"<hr />\n" .
					"Reading this means your debug model is on, change it to false in the Settings file, you will get a standard error message.<br />\n";
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