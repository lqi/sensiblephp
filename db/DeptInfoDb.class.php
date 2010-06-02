<?php
class DeptInfoDb extends Database {
	function deptInfoFromUserId($userId) {
		$info = $this->select("WHERE `user_id` = " . $userId . " ORDER BY `active_time` DESC");
		if (count($info) > 0) {
			return $info;
		}
		else {
			return false;
		}
	}
}
?>