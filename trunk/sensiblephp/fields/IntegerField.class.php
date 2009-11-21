<?php
class IntegerField extends Fields {
	private $value;
	
	function getFieldType() {
		return "IntegerField";
	}
	
	function setValue($number) {
		if (!is_int($number))
			throw new Exception('Exception: Set illegal input to Integer Field.');
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
}
?>