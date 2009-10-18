<?php
class BlogComment {
	private $id;
	private $blog_id;
	private $date;
	private $username;
	private $comment;
	
	public function __construct() {
		$this->id = new IntegerField;
		$this->blog_id = new IntegerField;
		$this->date = new DatetimeField;
		$this->username = new StringField;
		$this->comment = new TextField;
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