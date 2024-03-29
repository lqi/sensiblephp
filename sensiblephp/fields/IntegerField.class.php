<?php
class IntegerField extends Fields {
	private $value;
	
	function setValue($number) {
		if (!is_int($number))
			throw new InvalidArgumentException('InvalidArgumentException: Set illegal input to Integer Field.');
		$this->value = $number;
	}
	
	function processingPDOValue($value) {
		$this->setValue((int) $value);
	}
	
	function getValue() {
		return $this->getOriginalValue();
	}
	
	function getOriginalValue() {
		return $this->value;
	}
	
	function createTableSqlStmt() {
		return "int(11) NOT NULL";
	}
}
?>