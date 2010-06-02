<?php
class WorkingTimeDb extends Database {
	function workingTimeFromUserId($userId) {
		$time = $this->select("WHERE `user_id` = " . $userId . " ORDER BY `start_time` DESC");
		if (count($time) > 0) {
			return $time;
		}
		else {
			return false;
		}
	}
}
?>