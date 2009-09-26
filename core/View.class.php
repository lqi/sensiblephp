<?php
class View {
	private $template;
	private $vars = array();
	
	function setTemplate($template) {
		$this->template = $template;
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