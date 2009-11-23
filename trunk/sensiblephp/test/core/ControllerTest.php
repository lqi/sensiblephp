<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");

class MockController extends Controller {
	function setGetValue($array) {
		$_GET = $array;
	}
	
	function setPostValue($array) {
		$_POST = $array;
	}
	
	function setCookieValue($array) {
		$_COOKIE = $array;
	}
}

class ControllerTest extends PHPUnit_Framework_TestCase
{
	private $controller;
	
	protected function setUp() {
		$this->controller = new MockController;
	}
	
	public function testCanary() {
		$this->assertTrue(true);
	}
	
    public function testFetchGetValue() {
       	$this->controller->setGetValue($this->initTestArray());
		$this->assertEquals(1, $this->controller->fetchGet("a"));
		$this->assertEquals(2, $this->controller->fetchGet("b"));
	}
	
	public function testFetchGetValueWithErrorKey() {
		$this->controller->setGetValue($this->initTestArray());
		$this->assertFalse($this->controller->fetchGet("c"));
	}
	
	public function testFetchPostValue() {
       	$this->controller->setPostValue($this->initTestArray());
		$this->assertEquals(1, $this->controller->fetchPost("a"));
		$this->assertEquals(2, $this->controller->fetchPost("b"));
	}
	
	public function testFetchPostValueWithErrorKey() {
		$this->controller->setPostValue($this->initTestArray());
		$this->assertFalse($this->controller->fetchPost("c"));
	}
	
	public function testFetchCookieValue() {
       	$this->controller->setCookieValue($this->initTestArray());
		$this->assertEquals(1, $this->controller->fetchCookie("a"));
		$this->assertEquals(2, $this->controller->fetchCookie("b"));
	}
	
	public function testFetchCookieValueWithErrorKey() {
		$this->controller->setCookieValue($this->initTestArray());
		$this->assertFalse($this->controller->fetchCookie("c"));
	}
	
	private function initTestArray() {
		$testArray = array();
		$testArray["a"] = 1;
		$testArray["b"] = 2;
		return $testArray;
	}
}
?>