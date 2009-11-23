<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");

class MockFields extends Fields {
	function getValue() {}
	function processingPDOValue($value) {}
	function createTableSqlStmt() {}
}

class FieldsTest extends PHPUnit_Framework_TestCase
{
	private $fields;
	
	protected function setUp() {
		$this->fields = new MockFields;
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