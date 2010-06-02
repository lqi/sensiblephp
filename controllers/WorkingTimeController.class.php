<?php
class WorkingTimeController extends Controller {
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
	
	function onAction() {
		$account = $this->verifyLogin();
		if ($account) {
			$user_id = $account->user_id->getValue();
			$workingTime = new WorkingTime;
			$workingTime->user_id->setValue($user_id);
			$workingTime->start_time->setValue();
			$workingTime->end_time->setValue(1971, 1, 1, 23, 59, 59);
			$workingDb = new WorkingTimeDb;
			if ($workingDb->save($workingTime)) {
				$this->redirect("Homepage", "index");
			}
		}
	}
	
	function offAction() {
		$account = $this->verifyLogin();
		if ($account) {
			$user_id = $account->user_id->getValue();
			$workingDb = new WorkingTimeDb;
			$workingTimes = $workingDb->workingTimeFromUserId($user_id);
			$workingTime = $workingTimes[0];
			$workingTime->end_time->setValue();
			if ($workingDb->save($workingTime)) {
				$this->redirect("Homepage", "index");
			}
		}
	}
}
?>