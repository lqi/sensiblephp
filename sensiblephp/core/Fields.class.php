<?php
abstract class Fields {
	abstract function getValue();
	abstract function processingPDOValue($value);
	abstract function createTableSqlStmt();
	
	function safeValue($value) {
		return htmlentities($value);
	}
	
	function breakLineValue($value) {
		return nl2br($value);
	}
}