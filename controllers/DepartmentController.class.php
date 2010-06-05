<?php
class DepartmentController extends Controller {
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
	
	public function manageAction() {
		$account = $this->verifyLogin();
		if ($account && $account->privilege->getValue() == 2) {
			$department_id = $this->fetchPost("department_id");
			$dept = new Department;
			if ($department_id) {
				$dept->department_id->setValue((int) $department_id);
			}
			$dept->name->setValue($this->fetchPost("name"));
			$dept->description->setValue($this->fetchPost("descrption"));
		  $deptDb = new DepartmentDb;
			if ($deptDb->save($dept)) {
				$this->redirect("Homepage", "index");
			}
			else {
				echo "Error in adding/updating department information!";
			}
		}
	}
}
?>