<?php
class BlogComment {
	private $id;
	private $date;
	private $username;
	private $comment;
	
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