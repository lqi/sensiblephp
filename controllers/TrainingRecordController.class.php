<?php
class TrainingRecordController extends Controller {
	function insertTrainRecordAction() {
		$user_id = $this->fetchPost("user_id");
		$trainRecord = new TrainingRecord;
		$trainRecord->user_id->setValue((int) $user_id);
		$trainRecord->train_program->setValue($this->fetchPost("name"));
		$trainRecord->train_description->setValue($this->fetchPost("discription"));
		$trainRecord->train_time->setValue();
		$payInfoDb = new TrainingRecordDb;
		if ($payInfoDb->save($trainRecord)) {
			$this->redirect("Homepage", "manage?user_id=" . $user_id);
		}
	}
}
?>