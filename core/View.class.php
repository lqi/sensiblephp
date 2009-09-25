<?php
class View {
	private $template;
	
	function setTemplate($template) {
		$this->template = $template;
	}
	
	function render() {
		if($this->template) {
			include(VIEWS_DIR . $this->template . ".php");
		}		
	}
}
?>