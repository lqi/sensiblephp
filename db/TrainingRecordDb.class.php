<?php
class TrainingRecordDb extends Database {
	function trainHistoryFromUserId($userId) {
		$info = $this->select("WHERE `user_id` = " . $userId . " ORDER BY `train_time` DESC");
		if (count($info) > 0) {
			return $info;
		}
		else {
			return false;
		}
	}
}
?>