<?php
class BasicInfoController extends Controller {
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
	
	function newInfoAction() {
		if ($this->verifyLogin()) {
			$this->setTemplate("info/infoForm");
			$this->setValue("userId", $this->verifyLogin()->user_id->getValue());
		}
	}
	
	function processInfoAction() {
		$account = $this->verifyLogin();
		if ($account) {
			$info = new BasicInfo;
			$info->user_id->setValue($account->user_id->getValue());
			$info->real_name->setValue($this->fetchPost("realname"));
			$infoDb = new BasicInfoDb;
			if ($infoDb->save($info)) {
				$this->redirect("Homepage", "index");
			}
			else {
				$this->setTemplate("info/infoForm");
				$this->setValue("errMsg", "Cannot save info!");
			}
		}
	}
}
?>