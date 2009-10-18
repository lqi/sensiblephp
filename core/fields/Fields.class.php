<?php
abstract class Fields {
	abstract function getFieldType();
	
	function safeValue($value) {
		return htmlentities($value);
	}
	
	function breakLineValue($value) {
		return nl2br($value);
	}
}