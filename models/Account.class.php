<?php
class Account extends Model {
	protected $user_id;
	protected $username;
	protected $password;
	protected $privilege;

	public function __construct() {
		$this->user_id = new IntegerField;
		$this->username = new StringField(30);
		$this->password = new StringField(30);
		/*
			For privilege:
			1 - admin
			2 - teacher
			3 - hr
			4 - normal
		*/
		$this->privilege = new IntegerField;

		$this->setPKField("user_id");
	}
}
?>