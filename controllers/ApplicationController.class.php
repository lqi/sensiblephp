<?php
class ApplicationController extends Controller {
	private function verifyLogin() {
		$accountDb = new AccountDb;
		$account = $accountDb->logedInAccount();
		if ($account) {
			return $account;
		}
		else {
			$this->setTemplate("account/loginForm");
			$this->setValue("errMsg", "You must login the system before processing!");
		}
	}
	
	function applyAction() {
		if ($this->verifyLogin()) {
			$this->setTemplate("application/applyForm");
			$this->setValue("userId", $this->verifyLogin()->user_id->getValue());
			$deptDb = new DepartmentDb;
			$this->setValue("departments", $deptDb->all());
		}
	}
	
	function processApplyAction() {
		$account = $this->verifyLogin();
		if ($account) {
			$app = new Application;
			$app->user_id->setValue($account->user_id->getValue());
			$app->first_hr_id->setValue(0);
			$app->first_hr_decision->setValue(false);
			$app->second_hr_id->setValue(0);
			$app->second_hr_decision->setValue(false);
			$app->teacher_id->setValue(0);
			$app->teacher_decision->setValue(false);
			$deptInfo = new DeptInfo;
			$deptInfo->user_id->setValue($account->user_id->getValue());
			$deptInfo->department_id->setValue((int) $this->fetchPost("department"));
			$deptInfo->active_time->setValue();
			$appDb = new ApplicationDb;
			$deptDb = new DeptInfoDb;
			if ($appDb->save($app) && $deptDb->save($deptInfo)) {
				$this->redirect("Homepage", "index");
			}
			else {
				$this->setTemplate("application/applyForm");
				$this->setValue("errMsg", "Cannot submit application!");
			}
		}
	}
	
	function hrDecideAction() {
		$account = $this->verifyLogin();
		if ($account && $account->privilege->getValue() == 3) {
			$user_id = (int) $this->fetchGet("appId");
			$action = (bool) $this->fetchGet("action");
			$hr_id = $account->user_id->getValue();
			$appDb = new ApplicationDb;
			$application = $appDb->applicationStatusFromUserId($user_id);
			if ($application->hasFirstHrDecision()) {
				$application->second_hr_id->setValue($hr_id);
				$application->second_hr_decision->setValue($action);
			}
			else {
				$application->first_hr_id->setValue($hr_id);
				$application->first_hr_decision->setValue($action);
			}
			if ($appDb->save($application)) {
				$this->redirect("Homepage", "index");
			}
			else {
				echo "Error in HR decide!";
			}
		}
	}
}
?>