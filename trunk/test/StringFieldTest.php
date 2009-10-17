<?php
require_once 'init.php';
 
class StringFieldTest extends PHPUnit_Framework_TestCase
{
	private $stringField;
	
	protected function setUp() {
		$this->stringField = new StringField;
	}
	
	public function testGetType() {
		$this->assertEquals("StringField", $this->stringField->getFieldType());
	}
	
	public function testMaxLength() {
		$this->stringField = new StringField(9);
		$this->assertEquals(9, $this->stringField->getMaxLength());
	}
	
	public function testDefaultMaxLength() {
		$this->stringField = new StringField;
		$this->assertEquals(255, $this->stringField->getMaxLength());
	}
	
	public function testGetSafeValue() {
		$this->stringField->setValue("I'll \"walk\" the <b>dog</b> now");
		$this->assertEquals("I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now",
			$this->stringField->getSafeValue());
	}
	
	public function testGetOriginalValue() {
		$this->stringField->setValue("I'll \"walk\" the <b>dog</b> now");
		$this->assertEquals("I'll \"walk\" the <b>dog</b> now",
			$this->stringField->getOriginalValue());
	}
	
	public function testSetEmptyValue() {
		try {
			$this->stringField->setValue("");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail('Exception exptected: Empty value.');
	}
	
	public function testSetMoreCharactersThanMaxLength() {
		$this->stringField = new StringField(3);
		try {
			$this->stringField->setValue("1234");
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail('Exception expected: More characters than max length.');
	}
}
?>