<?php
require_once 'init.php';
 
class ViewTest extends PHPUnit_Framework_TestCase
{
	private $view;
	
	protected function setUp() {
		$this->view = new View;
	}
	
	function testSetTemplate() {
		$this->view->setTemplate("homepage");
		$this->assertEquals("homepage", $this->view->getTemplateName());
	}
	
	function testSetNoExistTemplate() {
		try {
			$this->view->setTemplate("home");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Set no exist template.");
	}
	
	function testSetValue() {
		$this->view->setValue("hello", "world");
		$this->assertEquals("world", $this->view->getValue("hello"));
	}
	
	function testGetValueFromNoExistKey() {
		$this->view->setValue("hello", "world");
		try {
			$this->view->getValue("world");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: get value from no exist key.");
	}
}	
?>