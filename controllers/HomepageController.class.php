<?php
class HomepageController extends Controller {
	function indexAction() {
		$this->setTemplate("homepage");
		$accountDb = new AccountDb;
		$account = $accountDb->logedInAccount();
		if ($account) {
			$this->setValue("account", $account);
		}
	}
}
