<?php
abstract class Controller {
	private $view;

	function Controller() {
		$newView = new View;
		$this->setView($newView);
	}
	
	protected function setView($newView) {
		$this->view = $newView;
	}
	
	protected function getView() {
		return $this->view;
	}
	
	function go() {
		$this->getView()->render();
	}

	function setTemplate($template) {
		$this->getView()->setTemplate($template);
	}
	
	function redirect($controller, $module) {
		if(strcmp($module, "index"))
			header("Location: /$controller/$module");
		else
			header("Location: /$controller");
	}
	
	private function parseValueFromHTTPHeaderObject($array, $key) {
		if (isset($array[$key]))
			return $array[$key];
		return false;
	}
	
	function fetchGet($key) {
		return $this->parseValueFromHTTPHeaderObject($_GET, $key);
	}
	
	function fetchPost($key) {
		return $this->parseValueFromHTTPHeaderObject($_POST, $key);
	}
	
	function fetchCookie($key) {
		return $this->parseValueFromHTTPHeaderObject($_COOKIE, $key);
	}
	
	function setValue($key, $value) {
		$this->getView()->setValue($key, $value);
	}
}
?>