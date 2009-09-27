<?php
class BlogController extends Controller {
	function indexAction() {
		$this->setTemplate("index");
	}
	
	function formAction() {
		$this->setTemplate("form");
	}
	
	function postAction() {
		$inputValue = $this->fetchPost("getFromPOST");
		$this->setTemplate("post");
		$this->setValue("getFromPOST", $inputValue);
		$this->setValue("getFromGET", $this->fetchGet("getFromGET"));
	}
	
	function redirectAction() {
		$this->redirect("Blog", "index");
	}
	
	function blogAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("blog");
		$blogDb = new BlogDb;
		$blog = $blogDb->getPostById($id);
		$this->setValue("blog", $blog);
	}
}

?>