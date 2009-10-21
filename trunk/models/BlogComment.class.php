<?php
class BlogComment extends Model {
	protected $id;
	protected $blog_id;
	protected $date;
	protected $username;
	protected $comment;
	
	public function __construct() {
		$this->id = new IntegerField;
		$this->blog_id = new IntegerField;
		$this->date = new DatetimeField;
		$this->username = new StringField;
		$this->comment = new TextField;
		$this->setPKField("id");
	}
}
?>