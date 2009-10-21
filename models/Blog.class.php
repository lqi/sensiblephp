<?php
class Blog extends Model {
	protected $id;
	protected $date;
	protected $title;
	protected $body;
	
	public function __construct() {
		$this->id = new IntegerField;
		$this->date = new DatetimeField;
		$this->title = new StringField;
		$this->body = new TextField;
		$this->setPKField("id");
	}
}
?>