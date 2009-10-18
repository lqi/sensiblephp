<?php
require_once 'init.php';
 
class TimeFieldTest extends PHPUnit_Framework_TestCase
{
	private $timeField;
	
	protected function setUp() {
		$this->timeField = new TimeField;
	}
	
	public function testGetType() {
		$this->assertEquals("TimeField", $this->timeField->getFieldType());
	}
	
	public function testSetTime() {
		$this->timeField = new TimeField(12, 6, 26);
		$this->assertEquals(12, $this->timeField->getHour_G());
		$this->assertEquals(6, $this->timeField->getMinute_org());
		$this->assertEquals(26, $this->timeField->getSecond_org());
	}
	
	public function testSetDefaultMidnightTime() {
		$this->assertEquals(0, $this->timeField->getHour_G());
		$this->assertEquals(0, $this->timeField->getMinute_org());
		$this->assertEquals(0, $this->timeField->getSecond_org());
	}
	
	public function testErrorInput() {
		try {
			$this->timeField = new TimeField("abc", 'd', 100);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Error Input!");
	}
	
	public function testErrorTimeInput() {
		try {
			$this->timeField = new TimeField(24, 60, -1);
		}
		catch (Exception $ex) {
			return;
		}
		$this->fail("Exception expected: Error Time!");
	}
	
	public function testGetValue() {
		$this->timeField = new TimeField(23, 0, 26);
		$this->assertEquals("23:00:26", $this->timeField->getValue());
	}
}