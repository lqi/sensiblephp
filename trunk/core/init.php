<?php

	define("PROJECT_DIR", dirname(getcwd()) . "/");
	define("CORE_DIR", PROJECT_DIR . "core/");
	define("CONFIG_DIR", PROJECT_DIR . "conf/");
	define("MODELS_DIR", PROJECT_DIR . "models/");
	define("VIEWS_DIR", PROJECT_DIR . "views/");
	define("CONTROLLERS_DIR", PROJECT_DIR . "controllers/");
	define("DB_BUSINESS_DIR", PROJECT_DIR . "db/");
	
	set_include_path(
		CORE_DIR . PATH_SEPARATOR . 
		CONTROLLERS_DIR . PATH_SEPARATOR . 
		VIEWS_DIR . PATH_SEPARATOR . 
		MODELS_DIR . PATH_SEPARATOR . 
		DB_BUSINESS_DIR . PATH_SEPARATOR .
		get_include_path());

	function __autoload($className) {
		require("$className.class.php");
	}
	
	new Route;
	
?>