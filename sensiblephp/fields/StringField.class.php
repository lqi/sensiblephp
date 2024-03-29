<?php
class StringField extends Fields {
	private $value;
	private $maxLength;
	
	function StringField($length = 255) {
		$this->maxLength = $length;
	}
	
	function getMaxLength() {
		return $this->maxLength;
	}
	
	function setValue($value) {
		if (strlen($value) == 0)
			throw new InvalidArgumentException('InvalidArgumentException: Empty value when setting StringField.');
		if (strlen($value) > $this->maxLength)
			throw new InvalidArgumentException('InvalidArgumentException: More characters than max length.');
		$this->value = $value;
	}
	
	function getValue() {
		return $this->getSafeValue();
	}
	
	function getSafeValue() {
		return $this->safeValue($this->value);
	}
	
	function getOriginalValue() {
		return $this->value;
	}

	function processingPDOValue($value) {
		$this->setValue($value);
	}
	
	function createTableSqlStmt() {
		return "varchar(" . $this->getMaxLength() . ") NOT NULL";
	}
}
?>