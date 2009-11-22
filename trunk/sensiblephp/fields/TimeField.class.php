<?php
class TimeField extends Fields {
	private $hour;
	private $minute;
	private $second;
	
	function TimeField($hour = 0, $minute = 0, $second = 0) {
		$this->setValue($hour, $minute, $second);
	}
	
	function setValue($hour = 0, $minute = 0, $second = 0) {
		if ($hour == 0 && $minute == 0 && $second == 0) {
			$this->hour = (int) date("H");
			$this->minute = (int) date("i");
			$this->second = (int) date("s");
		}
		else {
			if (!mktime($hour, $minute, $second, 1, 1, 1970))
				throw new Exception("Exception: Illigal input!");
			if ($hour < 0 || $hour > 23 || $minute < 0 || $minute > 59 || $second < 0 || $second > 59)
				throw new Exception("Exception: Illigal time!");
			$this->hour = (int) $hour;
			$this->minute = (int) $minute;
			$this->second = (int) $second;
		}
	}
	
	function getHour_G() {
		return $this->hour;
	}
	
	function getMinute_org() {
		return $this->minute;
	}
	
	function getSecond_org() {
		return $this->second;
	}
	
	function getValue() {
		return date("H:i:s", mktime($this->hour, $this->minute, $this->second, 1, 1, 1970));
	}

	function processingPDOValue($value) {
		$hour = substr($value, 0, 2);
		$minute = substr($value, 3, 2);
		$second = substr($value, 6, 2);
		$this->setValue($hour, $minute, $second);
	}
	
	function createTableSqlStmt() {
		return "time NOT NULL";
	}
}
?>