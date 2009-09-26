<?php
class Controller {
	private $view;

	function Controller() {
		$this->view = new View;
	}
	
	function go() {
		$this->view->render();
	}

	function setTemplate($template) {
		$this->view->setTemplate($template);
	}
	
	function redirect($controller, $module) {
		if(strcmp($module, "index"))
			header("Location: /$controller/$module");
		else
			header("Location: /$controller");
	}
	
	function fetchGet($key) {
		if (isset($_GET[$key]))
			return $_GET[$key];
		return false;
	}
	
	function fetchPost($key) {
		if (isset($_POST[$key]))
			return $_POST[$key];
		return false;
	}
	
	function fetchCookie($key) {
		if (isset($_COOKIE[$key]))
			return $_COOKIE[$key];
		return false;
	}
	
	function setValue($key, $value) {
		$this->view->setValue($key, $value);
	}
}
?>