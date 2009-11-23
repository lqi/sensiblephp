<?php
require_once(dirname(dirname(dirname(__file__))) . "/init.php");
 
class DatetimeFieldTest extends PHPUnit_Framework_TestCase
{
	private $datetimeField;
	
	protected function setUp() {
		$this->datetimeField = new DatetimeField;
	}
	
	public function testSetDatetimeOfDefineDatetime() {
		$this->datetimeField = new DatetimeField(2008, 8, 8, 20, 8, 8);
		$this->assertEquals(date("Y-m-d H:i:s", mktime(20, 8, 8, 8, 8, 2008)), $this->datetimeField->getValue());
	}
	
	public function testSetDatetimeOfToday() {
		$this->assertEquals(date("Y-m-d H:i:s"), $this->datetimeField->getValue());
	}
	
	public function testSetDatetimeofDefaultDatetime() {
		$this->datetimeField->setValue(0, 0, 0, 0, 0, 0);
		$this->assertEquals(date("Y-m-d H:i:s"), $this->datetimeField->getValue());
	}
	
	public function testSetErrorLetterData() {
		try {
			$this->datetimeField = new DatetimeField("abc", 0, 0, 0, 0, 0);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception exptected: Input error - letter data!");
	}

	public function testSetErrorNumbericData() {
		try {
			$this->datetimeField = new DatetimeField(-1, 0, 0, 0, 0, 0);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception exptected: Illegal input in datetimefield!");
	}
	
	public function testProcessingPROValue() {
		$now = "2009-11-22 20:03:22";
		$this->datetimeField->processingPDOValue($now);
		$this->assertEquals("2009-11-22 20:03:22", $this->datetimeField->getValue());
	}
	
	public function testProcessingErrorPROValue() {
		$errorDate = "2009-12-32 20:30:60";
		try {
			$this->datetimeField->processingPDOValue($errorDate);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Suffer error datetime when processing PRO value!");
	}
	
	public function testCreateTableSqlStmt() {
		$this->assertEquals("datetime NOT NULL", $this->datetimeField->createTableSqlStmt());
	}
	
	public function testGetYearByDefineDate() {
		$this->datetimeField = new DatetimeField(2009, 1, 2, 0, 0, 0);
		$this->assertEquals(2009, $this->datetimeField->getYear_Y());
	}

	public function testGetMonthByDefineDate() {
		$this->datetimeField = new DatetimeField(2009, 1, 2, 0, 0, 0);
		$this->assertEquals(1, $this->datetimeField->getMonth_n());
	}

	public function testGetDayByDefineDate() {
		$this->datetimeField = new DatetimeField(2009, 1, 2, 0, 0, 0);
		$this->assertEquals(2, $this->datetimeField->getDay_j());
	}
	
	public function testGetYearOfToday() {
		$this->assertEquals((int) date("Y"), $this->datetimeField->getYear_Y());
	}
	
	public function testGetMonthOfToday() {
		$this->assertEquals((int) date("n"), $this->datetimeField->getMonth_n());
	}
	
	public function testGetDayOfToday() {
		$this->assertEquals((int) date("j"), $this->datetimeField->getDay_j());
	}

	public function testGetYearOfTodayByDefault() {
		$this->datetimeField = new DatetimeField(0, 0, 0, 0, 0, 0);
		$this->assertEquals((int) date("Y"), $this->datetimeField->getYear_Y());
	}

	public function testGetMonthOfTodayByDefault() {
		$this->datetimeField = new DatetimeField(0, 0, 0, 0, 0, 0);
		$this->assertEquals((int) date("n"), $this->datetimeField->getMonth_n());
	}

	public function testGetDayOfTodayByDefault() {
		$this->datetimeField = new DatetimeField(0, 0, 0, 0, 0, 0);
		$this->assertEquals((int) date("j"), $this->datetimeField->getDay_j());
	}
	
	public function testSetTimeHour() {
		$this->datetimeField = new DatetimeField(2009, 11, 22, 12, 6, 26);
		$this->assertEquals(12, $this->datetimeField->getHour_G());
	}
	
	public function testSetTimeMinute() {
		$this->datetimeField = new DatetimeField(2009, 11, 22, 12, 6, 26);
		$this->assertEquals(6, $this->datetimeField->getMinute_org());
	}

	public function testSetTimeSecond() {
		$this->datetimeField = new DatetimeField(2009, 11, 22, 12, 6, 26);
		$this->assertEquals(26, $this->datetimeField->getSecond_org());
	}

	public function testSetDefaultTimeHour() {
		$this->datetimeField = new DatetimeField(0, 0, 0, 0, 0, 0);
		$this->assertEquals(date("H"), $this->datetimeField->getHour_G());
	}
	
	public function testSetDefaultTimeMinute() {
		$this->datetimeField = new DatetimeField(0, 0, 0, 0, 0, 0);
		$this->assertEquals(date("i"), $this->datetimeField->getMinute_org());
	}

	public function testSetDefaultTimeSecond() {
		$this->datetimeField = new DatetimeField(0, 0, 0, 0, 0, 0);
		$this->assertEquals(date("s"), $this->datetimeField->getSecond_org());
	}

	public function testSetTimeHourOfNow() {
		$this->assertEquals(date("H"), $this->datetimeField->getHour_G());
	}

	public function testSetTimeMinuteOfNow() {
		$this->assertEquals(date("i"), $this->datetimeField->getMinute_org());
	}

	public function testSetTimeSecondOfNow() {
		$this->assertEquals(date("s"), $this->datetimeField->getSecond_org());
	}
}