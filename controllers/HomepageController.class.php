<?php
class HomepageController extends Controller {
	function indexAction() {
		$this->setTemplate("homepage");
		$accountDb = new AccountDb;
		$account = $accountDb->logedInAccount();
		if ($account) {
			$this->setValue("account", $account);
			$user_id = $account->user_id->getValue();
			$privilege = $account->privilege->getValue();
			if ($privilege == 4) {
				$infoDb = new BasicInfoDb;
				$info = $infoDb->basicInfoFromUserId($user_id);
				$this->setValue("info", $info);
				$appDb = new ApplicationDb;
				$application = $appDb->applicationStatusFromUserId($user_id);
				$this->setValue("application", $application);
			}
			if ($privilege == 3) {
				$appDb = new ApplicationDb;
				$toDoApps = array();
				foreach($appDb->all() as $app) {
					if (!$app->hasHrDecision()) {
						if ($app->hasFirstHrDecision()) {
							if ($app->first_hr_id->getValue() != $user_id) {
								$toDoApps[] = $app;
							}
						}
						else {
							$toDoApps[] = $app;
						}
					}
				}
				$this->setValue("toDoApps", $toDoApps);
			}
		}
	}
}
