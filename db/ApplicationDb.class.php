<?php
class ApplicationDb extends Database {
	function applicationStatusFromUserId($userId) {
		$appStatus = $this->select("WHERE `user_id` = " . $userId);
		if (count($appStatus) == 1) {
			return $appStatus[0];
		}
		else {
			return false;
		}
	}
}
?>