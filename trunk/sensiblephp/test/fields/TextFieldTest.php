<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");
 
class TextFieldTest extends PHPUnit_Framework_TestCase
{
	private $textField;
	
	protected function setUp() {
		$this->textField = new TextField;
	}
	
	public function testGetSafeValue() {
		$this->textField->setValue("I'll \"walk\" the <b>dog</b> now");
		$this->assertEquals("I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now",
			$this->textField->getSafeValue());
	}
	
	public function testGetBreakLineValue() {
		$this->textField->setValue("foo isn't\n bar");
		$this->assertEquals("foo isn't<br />\n bar",
			$this->textField->getBreakLineValue());
	}
	
	public function testGetValue() {
		$this->textField->setValue("I'll \"walk\" the <b>dog</b>\n now");
		$this->assertEquals("I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt;<br />\n now",
			$this->textField->getValue());
	}
	
	public function testOriginalValue() {
		$this->textField->setValue("I'll \"walk\" the <b>dog</b>\n now");
		$this->assertEquals("I'll \"walk\" the <b>dog</b>\n now",
			$this->textField->getOriginalValue());
	}
	
	public function testSetEmptyText() {
		try {
			$this->textField->setValue("");
			$this->fail("Exception expected: set empty string to TextField.");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testProcessingPDOValue() {
		$this->textField->processingPDOValue("classic: Hello, world!");
		$this->assertEquals("classic: Hello, world!", $this->textField->getValue());
	}
	
	public function testCreateTableSqlStmt() {
		$this->assertEquals("text NOT NULL", $this->textField->createTableSqlStmt());
	}
}
?>