<?php
/*
http://php.net/manual/en/function.date.php
http://www.php.net/manual/en/function.mktime.php
*/

class DateField extends Fields {
	private $year;
	private $month;
	private $day;
	
	function DateField($year = 0, $month = 0, $day = 0) {
		$this->setValue($year, $month, $day);
	}
	
	function setValue($year = 0, $month = 0, $day = 0) {
		if (is_int($year) && is_int($month) && is_int($day)) {
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
				$this->year = (int) $year;
				$this->month = (int) $month;
				$this->day = (int) $day;
			}
		}
		else {
			throw new Exception("Exception: Illigal input: set letter to DateField.");
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
	
	function processingPDOValue($value) {
		$year = (int) substr($value, 0, 4);
		$month = (int) substr($value, 5, 2);
		$day = (int) substr($value, 8, 2);
		$this->setValue($year, $month, $day);
	}
	
	function createTableSqlStmt() {
		return "date NOT NULL";
	}
}
?>