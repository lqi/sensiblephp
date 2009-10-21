<?php
class DatetimeField extends Fields {
	private $date;
	private $time;
	
	function getFieldType() {
		return "DatetimeField";
	}
	
	function DatetimeField($year = 0, $month = 0, $day = 0, $hour = 0, $minute = 0, $second = 0) {
		$this->setValue($year, $month, $day, $hour, $minute, $second);
	}
	
	function setValue($year, $month, $day, $hour, $minute, $second) {
		if ($year == 0 && $month == 0 && $day == 0 && $hour == 0 && $minute == 0 && $second == 0) {
			$this->date = new DateField;
			$this->time = new TimeField;
		}
		else {
			$this->date = new DateField($year, $month, $day);
			$this->time = new TimeField($hour, $minute, $second);
		}
	}
	
	function getValue() {
		return $this->date->getValue() . " " . $this->time->getValue();
	}
	
	function setYmdHisValue() {
		
	}
}
?>