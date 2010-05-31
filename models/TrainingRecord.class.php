<?php
class TrainingRecord extends Model {
	protected $train_id;
	protected $user_id;
	protected $train_program;
	protected $train_description;
	protected $train_time;

	public function __construct() {
		$this->train_id = new IntegerField;
		$this->user_id = new IntegerField;
		$this->train_program = new StringField(60);
		$this->train_description = new TextField;
		$this->train_time = new DateField;

		$this->setPKField("train_id");
	}
}
?>