<?php
class Department extends Model {
	protected $department_id;
	protected $name;
	protected $description;

	public function __construct() {
		$this->department_id = new IntegerField;
		$this->name = new StringField(60);
		$this->description = new TextField;

		$this->setPKField("department_id");
	}
}
?>