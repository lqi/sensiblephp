<?php
class PaymentInfoController extends Controller {
	function insertPayInfoAction() {
		$user_id = $this->fetchPost("user_id");
		$payInfo = new PaymentInfo;
		$payInfo->user_id->setValue((int) $user_id);
		$payInfo->payment->setValue((int) $this->fetchPost("payment"));
		$payInfo->active_time->setValue();
		$payInfoDb = new PaymentInfoDb;
		if ($payInfoDb->save($payInfo)) {
			$this->redirect("Homepage", "manage?user_id=" . $user_id);
		}
	}
}
?>