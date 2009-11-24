<?php
class DatetimeField extends Fields {
	private $date;
	private $time;
	
	function DatetimeField($year = 0, $month = 0, $day = 0, $hour = 0, $minute = 0, $second = 0) {
		$this->setValue($year, $month, $day, $hour, $minute, $second);
	}
	
	function setValue($year = 0, $month = 0, $day = 0, $hour = 0, $minute = 0, $second = 0) {
		if (is_int($year) && is_int($month) && is_int($day) && is_int($hour) && is_int($minute) && is_int($second)) {
			if ($year == 0 && $month == 0 && $day == 0 && $hour == 0 && $minute == 0 && $second == 0) {
				$this->date = new DateField;
				$this->time = new TimeField;
			}
			else {
				$this->date = new DateField($year, $month, $day);
				$this->time = new TimeField($hour, $minute, $second);
			}
		}
		else {
			throw new InvalidArgumentException("InvalidArgumentException: Illigal input: set letter to DatetimeField.");
		}
	}
	
	function getValue() {
		return $this->date->getValue() . " " . $this->time->getValue();
	}
	
	function processingPDOValue($value) {
		$this->date->processingPDOValue(substr($value, 0, 10));
		$this->time->processingPDOValue(substr($value, 11, 19));
	}
	
	function createTableSqlStmt() {
		return "datetime NOT NULL";
	}
	
	function getDateValue() {
		return $this->date->getValue();
	}
	
	function getTimeValue() {
		return $this->time->getValue();
	}
	
	function getYear_Y() {
		return $this->date->getYear_Y();
	}
	
	function getMonth_n() {
		return $this->date->getMonth_n();
	}
	
	function getDay_j() {
		return $this->date->getDay_j();
	}
	
	function getHour_G() {
		return $this->time->getHour_G();
	}
	
	function getMinute_org() {
		return $this->time->getMinute_org();
	}
	
	function getSecond_org() {
		return $this->time->getSecond_org();
	}
}
?>