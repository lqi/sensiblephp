<?php
class DeptInfoController extends Controller {
	function insertDeptInfoAction() {
		$user_id = $this->fetchPost("user_id");
		$deptInfo = new DeptInfo;
		$deptInfo->user_id->setValue((int) $user_id);
		$deptInfo->department_id->setValue((int) $this->fetchPost("department"));
		$deptInfo->active_time->setValue();
		$deptDb = new DeptInfoDb;
		if ($deptDb->save($deptInfo)) {
			$this->redirect("Homepage", "manage?user_id=" . $user_id);
		}
	}
}
?>