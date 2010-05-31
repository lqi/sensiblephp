<?php
class PaymentInfo extends Model {
	protected $id;
	protected $user_id;
	protected $payment;
	protected $active_time;

	public function __construct() {
		$this->id = new IntegerField;
		$this->user_id = new IntegerField;
		$this->payment = new IntegerField;
		$this->active_time = new DateField;

		$this->setPKField("id");
	}
}
?>