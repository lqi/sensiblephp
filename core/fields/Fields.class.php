<?php
class Fields {
	function safeValue($value) {
		return htmlentities($value);
	}
	
	function breakLineValue($value) {
		return nl2br($value);
	}
}