<?php
class HomepageController extends Controller {
	function indexAction() {
		$this->setTemplate("homepage");
		$accountDb = new AccountDb;
		$account = $accountDb->logedInAccount();
		if ($account) {
			$this->setValue("account", $account);
			$infoDb = new BasicInfoDb;
			$info = $infoDb->basicInfoFromUserId($account->user_id->getValue());
			$this->setValue("info", $info);
		}
	}
}
