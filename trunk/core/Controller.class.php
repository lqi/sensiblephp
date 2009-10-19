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
	
	function fetchValueFromArray($array, $key) {
		if (isset($array[$key]))
			return $array[$key];
		return false;
	}
	
	function fetchGet($key) {
		return $this->fetchValueFromArray($_GET, $key);
	}
	
	function fetchPost($key) {
		return $this->fetchValueFromArray($_POST, $key);
	}
	
	function fetchCookie($key) {
		return $this->fetchValueFromArray($_COOKIE, $key);
	}
	
	function setValue($key, $value) {
		$this->view->setValue($key, $value);
	}
}
?>