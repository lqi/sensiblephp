<?php
class Dictionary {
	private $id;
	private $term;
	private $definition;
	
	public function __construct() {
		$this->id = new IntegerField;
		$this->term = new StringField;
		$this->definition = new TextField;
	}
	
	public function __set($key, $value) {
		if(is_resource($key))
			throw new Exception('Exception: Attribute Not Found.');
		$this->$key = $value;
	}

	public function __get($key) {
		return $this->$key;
	}
}
?>