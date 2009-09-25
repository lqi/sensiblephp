<?php
class BlogController extends Controller {
	function indexAction() {
		$this->setTemplate("postlist");
	}
	
	function postAction() {
		$this->setTemplate("post");
	}
	
	function redirectAction() {
		$this->redirect("Blog", "index");
	}
}

?>