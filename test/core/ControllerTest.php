<?php
require_once '../init.php';
 
class ControllerTest extends PHPUnit_Framework_TestCase
{
	private $controller;
	
	protected function setUp() {
		$this->controller = new Controller;
	}
	
	public function testCanary() {
		$this->assertTrue(true);
	}
	
    public function testFetchValueFromArray() {
       	$testArray = $this->initTestArray();
		$this->assertEquals(1, $this->controller->fetchValueFromArray($testArray, "a"));
		$this->assertEquals(2, $this->controller->fetchValueFromArray($testArray, "b"));
	}
	
	public function testFetchValueFromArrayWithErrorKey() {
		$testArray = $this->initTestArray();
		$this->assertFalse($this->controller->fetchValueFromArray($testArray, "c"));
	}
	
	private function initTestArray() {
		$testArray = array();
		$testArray["a"] = 1;
		$testArray["b"] = 2;
		return $testArray;
	}
}
?>