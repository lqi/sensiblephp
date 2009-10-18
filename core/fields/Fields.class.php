<?php
abstract class Fields {
	abstract function getFieldType();
	abstract function getValue();
	
	function safeValue($value) {
		return htmlentities($value);
	}
	
	function breakLineValue($value) {
		return nl2br($value);
	}
}