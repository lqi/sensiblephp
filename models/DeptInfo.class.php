<?php
class DeptInfo extends Model {
	protected $id;
	protected $user_id;
	protected $department_id;
	protected $active_time;

	public function __construct() {
		$this->id = new IntegerField;
		$this->user_id = new IntegerField;
		$this->department_id = new IntegerField;
		$this->active_time = new DateField;

		$this->setPKField("id");
	}
}
?>