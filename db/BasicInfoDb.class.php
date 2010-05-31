<?php
class BasicInfoDb extends Database {
	function basicInfoFromUserId($userId) {
		$info = $this->select("WHERE `user_id` = " . $userId);
		if (count($info) == 1) {
			return $info[0];
		}
		else {
			return false;
		}
	}
}
?>