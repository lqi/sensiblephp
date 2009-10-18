<?php
class Blog {
	private $id;
	private $date;
	private $title;
	private $body;
	
	public function __construct() {
		$this->id = new IntegerField;
		$this->date = new DatetimeField;
		$this->title = new StringField;
		$this->body = new TextField;
	}
	
	public function __set($key, $value) {
		if(is_resource($key))
			throw new Exception('Exception: Attribute Not Found.');
		$key = $value;
	}

	public function __get($key) {
		return $this->$key;
	}
	
}
?>