<?php
class Blog {
	private $id;
	private $date;
	private $title;
	private $body;
	
	public function __set($key, $value) {
		if(is_resource($key))
			throw new Exception('Exception: Attribute Not Found.');
		if(is_numeric($value))
			$value = $value;
		elseif(is_null($value))
			$value = 'NULL';
		else
			$value = "$value";
		$this->$key = $value;
	}

	public function __get($key) {
		return $this->$key;
	}
	
}
?>