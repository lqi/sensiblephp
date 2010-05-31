<?php
class WorkingTime extends Model {
	protected $id;
	protected $user_id;
	protected $start_time;
	protected $end_time;

	public function __construct() {
		$this->id = new IntegerField;
		$this->user_id = new IntegerField;
		$this->start_time = new DatetimeField;
		$this->end_time = new DatetimeField;

		$this->setPKField("id");
	}
}
?>