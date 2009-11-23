<?php
class TextField extends Fields {
	private $value;
	
	function setValue($value) {
		if (strlen($value) == 0)
			throw new Exception('Exception: Empty value.');
		$this->value = $value;
	}
	
	function getValue() {
		return $this->breakLineValue($this->safeValue($this->value));
	}
	
	function getSafeValue() {
		return $this->safeValue($this->value);
	}
	
	function getBreakLineValue() {
		return $this->breakLineValue($this->value);
	}
	
	function getOriginalValue() {
		return $this->value;
	}
	
	function processingPDOValue($value) {
		$this->setValue($value);
	}
	
	function createTableSqlStmt() {
		return "text NOT NULL";
	}
	
//getAbbrValue() for String and Text
}