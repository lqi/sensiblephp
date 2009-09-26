<?php
class BlogController extends Controller {
	function indexAction() {
		$this->setTemplate("index");
	}
	
	function formAction() {
		$this->setTemplate("form");
	}
	
	function postAction() {
		$inputValue = $this->fetchPost("inputField");
		$this->setTemplate("post");
		$this->setValue("inputValue", $inputValue);
	}
	
	function redirectAction() {
		$this->redirect("Blog", "index");
	}
}

?>