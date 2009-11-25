<?php
require_once(dirname(dirname(__file__)) . "/sensiblephp/init.php");

class HomeControllerTest extends PHPUnit_Framework_TestCase {
	public function testIndexAction() {
		$mockHomeController = $this->getMock('HomepageController', array('setTemplate'));
		$mockHomeController->expects($this->once())->method('setTemplate')->with($this->equalTo('homepage'));
		$mockHomeController->indexAction();
	}
}
?>