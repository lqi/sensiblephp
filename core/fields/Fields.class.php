<?php
abstract class Fields {
	abstract function getFieldType();
	abstract function getValue();
	abstract function processingPDOValue($value);
	
	function safeValue($value) {
		return htmlentities($value);
	}
	
	function breakLineValue($value) {
		return nl2br($value);
	}
}