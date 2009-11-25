<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");

class MockView extends View {
	private $goCalledFlag;
	private $templateName;
	
	function MockView() {
		$this->goCalledFlag = false;
	}
	
	function render() {
		$this->goCalledFlag = true;
	}
	
	function getGoCalledFlag() {
		return $this->goCalledFlag;
	}
	
	function setTemplate($name) {
		$this->templateName = $name;
	}
	
	function getTemplateName() {
		return $this->templateName;
	}
}

class MockController extends Controller {
	function MockController() {
		$mockView = new MockView;
		$this->setView($mockView);
	}
	
	function setGetValue($array) {
		$_GET = $array;
	}
	
	function setPostValue($array) {
		$_POST = $array;
	}
	
	function setCookieValue($array) {
		$_COOKIE = $array;
	}
	
	function getValue($key) {
		return $this->getView()->getValue($key);
	}
	
	function renderWell() {
		return $this->getView()->getGoCalledFlag();
	}
	
	function getTemplateName() {
		return $this->getView()->getTemplateName();
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
	
	public function testSetSingleValue() {
		$this->controller->setValue("hello", "world");
		$this->assertEquals("world", $this->controller->getValue("hello"));
	}
	
	public function testSetMoreValues() {
		$this->controller->setValue("hello", "world");
		$this->controller->setValue("foo", "bar");
		$this->assertEquals("bar", $this->controller->getValue("foo"));
	}
	
	public function testGo() {
		$this->controller->go();
		$this->assertTrue($this->controller->renderWell());
	}
	
	public function testSetTemplate() {
		$this->controller->setTemplate("template");
		$this->assertEquals("template", $this->controller->getTemplateName());
	}
}
?>