<?php
require_once 'init.php';

class FieldsMock extends Fields {
	function getFieldType() {}
	function getValue() {}
}

class FieldsTest extends PHPUnit_Framework_TestCase
{
	private $fields;
	
	protected function setUp() {
		$this->fields = new FieldsMock;
	}
	
	public function testGetSafeValue() {
		$this->assertEquals("I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now",
			$this->fields->safeValue("I'll \"walk\" the <b>dog</b> now"));
	}
	
	public function testGetBreakLineValue() {
		$this->assertEquals("foo isn't<br />\n bar",
			$this->fields->breakLineValue("foo isn't\n bar"));
	}
}
?>