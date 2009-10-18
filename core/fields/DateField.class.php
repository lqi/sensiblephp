<?php
/*
http://php.net/manual/en/function.date.php
http://www.php.net/manual/en/function.mktime.php
*/

class DateField extends Fields {
	private $year;
	private $month;
	private $day;
	
	function getFieldType() {
		return "DateField";
	}
	
	function DateField($year = 0, $month = 0, $day = 0) {
		if ($year == 0 && $month == 0 && $day == 0) {
			$this->year = (int) date("Y");
			$this->month = (int) date("n");
			$this->day = (int) date("j");
		}
		else {
			if (!mktime(0, 0, 0, $month, $day, $year))
				throw new Exception("Exception: Illigal input!");
			if (!checkdate($month, $day, $year))
				throw new Exception("Exception: Illigal Date!");
			$this->year = $year;
			$this->month = $month;
			$this->day = $day;
		}
	}
	
	function getYear_Y() {
		return $this->year;
	}
	
	function getMonth_n() {
		return $this->month;
	}
	
	function getDay_j() {
		return $this->day;
	}
	
	function getValue() {
		return date("Y-m-d", mktime(0, 0, 0, $this->month, $this->day, $this->year));
	}
}
?>