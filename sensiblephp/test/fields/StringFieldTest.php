<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");
 
class StringFieldTest extends PHPUnit_Framework_TestCase
{
	private $stringField;
	
	protected function setUp() {
		$this->stringField = new StringField;
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
			$this->fail('Exception exptected: Empty value.');
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testSetMoreCharactersThanMaxLength() {
		$this->stringField = new StringField(3);
		try {
			$this->stringField->setValue("1234");
			$this->fail('Exception expected: More characters than max length.');
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testProcessingPDOValue() {
		$this->stringField->processingPDOValue("Busy building Google Chrome OS!");
		$this->assertEquals("Busy building Google Chrome OS!", $this->stringField->getValue());
	}
	
	public function testCreateTableSqlStmt() {
		$correctSqlStmt = "varchar(255) NOT NULL";
		$this->assertEquals($correctSqlStmt, $this->stringField->createTableSqlStmt());
	}
	
	public function testCreateTableSqlStmtWithDefinedMaxStringLength() {
		$this->stringField = new StringField(9);
		$correctSqlStmt = "varchar(9) NOT NULL";
		$this->assertEquals($correctSqlStmt, $this->stringField->createTableSqlStmt());
	}
}
?>