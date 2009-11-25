<?php
require_once(dirname(dirname(__file__)) . "/sensiblephp/init.php");

class AdminControllerTest extends PHPUnit_Framework_TestCase {
	public function testGetAllBlogComments() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/index'));
		$mockAdminController->indexAction();
	}
	
	public function testBloglistAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/bloglist'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('blogArray'));
		$mockAdminController->bloglistAction();
	}
	
	public function testBlogaddAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/blogform'));
		$mockAdminController->blogaddAction();
	}
	/*
	public function testBloginsertAction() {
		$mockBlogDb = $this->getMock('BlogDb', array('save'));
		$mockBlogDb->expects($this->any())->method('save')->will($this->returnValue(true));
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('bloglist'));
		$mockAdminController->bloginsertAction();
	}
	
	/*
	function bloginsertAction() {
		$title = $this->fetchPost("title");
		$body = $this->fetchPost("body");
		
		$blog = new Blog;
		$blog->date->setValue();
		$blog->title->setValue($title);
		$blog->body->setValue($body);
		
		$blogDb = new BlogDb;
		if($blogDb->save($blog)) {
			$this->redirect("Admin", "bloglist");
		}
	}
	*/
}
?>