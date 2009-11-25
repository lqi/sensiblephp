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
	
	public function testBlogCommentListAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/blogcommentlist'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('commentArray'));
		$mockAdminController->blogcommentlistAction();
	}
	
	public function testDictListAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/dictlist'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('dictArray'));
		$mockAdminController->dictlistAction();
	}
	
	public function testDictaddAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/dictform'));
		$mockAdminController->dictaddAction();
	}
	
	
	
	/*
	function dicteditAction() {
		$id = (int) $this->fetchGet("id");
		$this->setTemplate("admin/dicteditform");

		$dictDb = new DictionaryDb;
		$this->setValue("dict", $dictDb->get($id));
	}
	*/
}
?>