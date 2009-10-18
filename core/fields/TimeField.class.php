<?php
class TimeField extends Fields {
	private $hour;
	private $minute;
	private $second;
	
	function getFieldType() {
		return "TimeField";
	}
	
	function TimeField($hour = 0, $minute = 0, $second = 0) {
		$this->setValue($hour, $minute, $second);
	}
	
	function setValue($hour, $minute, $second) {
		if (!mktime($hour, $minute, $second, 1, 1, 1970))
			throw new Exception("Exception: Illigal input!");
		if ($hour < 0 || $hour > 23 || $minute < 0 || $minute > 59 || $second < 0 || $second > 59)
			throw new Exception("Exception: Illigal time!");
		$this->hour = $hour;
		$this->minute = $minute;
		$this->second = $second;
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
	
}
?>