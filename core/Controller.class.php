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

}
?>