<?php
class BooleanField extends Fields {
	private $value;
	
	function setValue($trueOrFalse) {
		if (!is_bool($trueOrFalse))
			throw new InvalidArgumentException('InvalidArgumentException: Set illegal input to Boolean Field.');
		$this->value = $trueOrFalse;
	}
	
	function processingPDOValue($value) {
		$this->setValue((bool) $value);
	}
	
	function getValue() {
		return $this->getOriginalValue();
	}
	
	function getOriginalValue() {
		return $this->value;
	}
	
	function createTableSqlStmt() {
		return "boolean NOT NULL";
	}
}
?>