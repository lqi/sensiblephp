<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");
 
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
		$this->fail("Exception expected: Set no existing template.");
	}
	
	function testSetValue() {
		$this->view->setValue("hello", "world");
		$this->assertEquals("world", $this->view->getValue("hello"));
	}
	
	function testGetValueFromNoExistKey() {
		$this->view->setValue("hello", "world");
		$this->assertFalse($this->view->getValue("world"));
	}
}	
?>