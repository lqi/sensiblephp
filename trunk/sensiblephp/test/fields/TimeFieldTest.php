<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");
 
class TimeFieldTest extends PHPUnit_Framework_TestCase
{
	private $timeField;
	
	protected function setUp() {
		$this->timeField = new TimeField;
	}
	
	public function testSetTimeHour() {
		$this->timeField = new TimeField(12, 6, 26);
		$this->assertEquals(12, $this->timeField->getHour_G());
	}
	
	public function testSetTimeMinute() {
		$this->timeField = new TimeField(12, 6, 26);
		$this->assertEquals(6, $this->timeField->getMinute_org());
	}

	public function testSetTimeSecond() {
		$this->timeField = new TimeField(12, 6, 26);
		$this->assertEquals(26, $this->timeField->getSecond_org());
	}

	public function testSetDefaultTimeHour() {
		$this->timeField = new TimeField(0, 0, 0);
		$this->assertEquals(date("H"), $this->timeField->getHour_G());
	}
	
	public function testSetDefaultTimeMinute() {
		$this->timeField = new TimeField(0, 0, 0);
		$this->assertEquals(date("i"), $this->timeField->getMinute_org());
	}

	public function testSetDefaultTimeSecond() {
		$this->timeField = new TimeField(0, 0, 0);
		$this->assertEquals(date("s"), $this->timeField->getSecond_org());
	}

	public function testSetTimeHourOfNow() {
		$this->assertEquals(date("H"), $this->timeField->getHour_G());
	}

	public function testSetTimeMinuteOfNow() {
		$this->assertEquals(date("i"), $this->timeField->getMinute_org());
	}

	public function testSetTimeSecondOfNow() {
		$this->assertEquals(date("s"), $this->timeField->getSecond_org());
	}

	public function testErrorInput() {
		try {
			$this->timeField = new TimeField("abc", 'd', 100);
			$this->fail("Exception expected: Error Input!");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testErrorTimeInput() {
		try {
			$this->timeField = new TimeField(24, 60, -1);
			$this->fail("Exception expected: Error Time!");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testGetValue() {
		$this->timeField = new TimeField(23, 0, 26);
		$this->assertEquals("23:00:26", $this->timeField->getValue());
	}
	
	public function testGetValueOfNow() {
		$this->timeField = new TimeField();
		$this->assertEquals(date("H:i:s"), $this->timeField->getValue());
	}
	
	public function testGetDefaultValue() {
		$this->timeField = new TimeField(0, 0, 0);
		$this->assertEquals(date("H:i:s"), $this->timeField->getValue());
	}
	
	public function testProcessingPROValue() {
		$now = "20:21:22";
		$this->timeField->processingPDOValue($now);
		$this->assertEquals("20:21:22", $this->timeField->getValue());
	}
	
	public function testProcessingErrorPROValue() {
		$errorTime = "20:21:60";
		try {
			$this->timeField->processingPDOValue($errorTime);
			$this->fail("Exception expected: Suffer error time when processing PRO value!");
		}
		catch (InvalidArgumentException $ex) {
			return;
		}
	}
	
	public function testCreateTableSqlStmt() {
		$this->assertEquals("time NOT NULL", $this->timeField->createTableSqlStmt());
	}
}
