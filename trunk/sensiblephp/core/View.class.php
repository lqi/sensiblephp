<?php
class View {
	private $template;
	private $vars = array();
	
	function setTemplate($template) {
		if(file_exists(VIEWS_DIR . $template . ".php")) {
			$this->template = $template;
			return;
		}
		throw new Exception("Exception: set no exist template file.");
	}
	
	function getTemplateName() {
		return $this->template;
	}
	
	function render() {
		if($this->template) {
			include(VIEWS_DIR . $this->template . ".php");
		}
	}
	
	function setValue($key, $value) {
		$this->vars[$key] = $value;
	}
	
	function getValue($key) {
		if (isset($this->vars[$key]))
			return $this->vars[$key];
		return false;
	}
}
?>