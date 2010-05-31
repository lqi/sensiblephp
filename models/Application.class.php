<?php
class Application extends Model {
	protected $application_id;
	protected $user_id;
	protected $first_hr_id;
	protected $first_hr_decision;
	protected $second_hr_id;
	protected $second_hr_decision;
	protected $teacher_id;
	protected $teacher_decision;

	public function __construct() {
		$this->application_id = new IntegerField;
		$this->user_id = new IntegerField;
		$this->first_hr_id = new IntegerField;
		$this->first_hr_decision = new BooleanField;
		$this->second_hr_id = new IntegerField;
		$this->second_hr_decision = new BooleanField;
		$this->teacher_id = new IntegerField;
		$this->teacher_decision = new BooleanField;

		$this->setPKField("application_id");
	}
	
	public function hasFirstHrDecision() {
		return $this->first_hr_id->getValue() != 0;
	}
	
	public function hasSecondHrDecision() {
		return $this->second_hr_id->getValue() != 0;
	}
	
	public function hasHrDecision() {
		return $this->hasFirstHrDecision() && $this->hasSecondHrDecision();
	}
	
	public function hrDecision() {
		return $this->hasHrDecision() && $this->first_hr_decision->getValue() && $this->second_hr_decision->getValue();
	}
	
	public function hasTeacherDecision() {
		return $this->teacher_id->getValue() != 0;
	}
	
	public function teacherDecision() {
		return $this->hasTeacherDecision() && $this->teacher_decision->getValue();
	}
	
	public function success() {
		return $this->teacherDecision();
	}
}
?>