<?php
class TimeField extends Fields {
	private $hour;
	private $minute;
	private $second;
	
	function TimeField($hour = 0, $minute = 0, $second = 0) {
		$this->setValue($hour, $minute, $second);
	}
	
	function setValue($hour = 0, $minute = 0, $second = 0) {
		if (is_int($hour) && is_int($minute) && is_int($second)) {
			if (!mktime($hour, $minute, $second, 1, 1, 1970))
				throw new InvalidArgumentException("InvalidArgumentException: Illigal input!");
			if ($hour < 0 || $hour > 23 || $minute < 0 || $minute > 59 || $second < 0 || $second > 59)
				throw new InvalidArgumentException("InvalidArgumentException: Illigal time!");
			if ($hour == 0 && $minute == 0 && $second == 0) {
				$this->hour = (int) date("H");
				$this->minute = (int) date("i");
				$this->second = (int) date("s");
			}
			else {
				$this->hour = (int) $hour;
				$this->minute = (int) $minute;
				$this->second = (int) $second;
			}
		}
		else {
			throw new InvalidArgumentException("Exception: Illigal input: set letter to TimeField.");
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
		return $this->getOriginalValue();
	}
	
	function getOriginalValue() {
		return date("H:i:s", mktime($this->hour, $this->minute, $this->second, 1, 1, 1970));
	}

	function processingPDOValue($value) {
		$hour = (int) substr($value, 0, 2);
		$minute = (int) substr($value, 3, 2);
		$second = (int) substr($value, 6, 2);
		$this->setValue($hour, $minute, $second);
	}
	
	function createTableSqlStmt() {
		return "time NOT NULL";
	}
}
?>