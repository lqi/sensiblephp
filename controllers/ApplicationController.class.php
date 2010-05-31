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
			$appDb = new ApplicationDb;
			if ($appDb->save($app)) {
				$this->redirect("Homepage", "index");
			}
			else {
				$this->setTemplate("application/applyForm");
				$this->setValue("errMsg", "Cannot submit application!");
			}
		}
	}
}
?>