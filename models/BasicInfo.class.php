<?php
class BasicInfo extends Model {
	protected $employee_id;
	protected $user_id;
	protected $real_name;

	public function __construct() {
		$this->employee_id = new IntegerField;
		$this->user_id = new IntegerField;
		$this->real_name = new StringField(60);
		$this->setPKField("employee_id");
	}
}
?>