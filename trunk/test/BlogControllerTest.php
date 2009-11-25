<?php
require_once(dirname(dirname(__file__)) . "/sensiblephp/init.php");

class BlogControllerTest extends PHPUnit_Framework_TestCase {
	public function testIndexAction() {
		$mockBlogController = $this->getMock('BlogController', array('setTemplate', 'setValue'));
		$mockBlogController->expects($this->once())->method('setTemplate')->with($this->equalTo('blog/index'));
		$mockBlogController->expects($this->once())->method('setValue')->with($this->equalTo('blogArray'));
		$mockBlogController->indexAction();
	}
}
?>