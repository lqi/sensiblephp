<?php
class TextField extends Fields {
	private $value;
	
	function getFieldType() {
		return "TextField";
	}
	
	function getSafeType() {
		return htmlentities($this->value);
	}
	
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
	
//getAbbrValue() for String and Text
}