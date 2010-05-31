<?php
class AccountController extends Controller {
	function registerAction() {
		$this->setTemplate("account/registerForm");
	}
	
	function processRegisterAction() {
		$username = $this->fetchPost("username");
		$accountDb = new AccountDb;
		if ($accountDb->usernameExist($username)) {
			$this->setTemplate("account/registerForm");
			$this->setValue("errMsg", "Username exists!");
		}
		else {
			$password = $this->fetchPost("password");
			$account = new Account;
			$account->username->setValue($username);
			$account->password->setValue($password);
			$account->privilege->setValue(4);
			if ($accountDb->save($account)) {
				$this->redirect("Homepage", "index");
			}
			else {
				$this->setTemplate("account/registerForm");
				$this->setValue("errMsg", "Cannot register!");
			}
		}
	}
	
	function loginAction() {
		$this->setTemplate("account/loginForm");
	}
	
	function processLoginAction() {
		$username = $this->fetchPost("username");
		$accountDb = new AccountDb;
		if (!$accountDb->usernameExist($username)) {
			$this->setTemplate("account/loginForm");
			$this->setValue("errMsg", "Username doesn't exist!");
		}
		else {
			$password = $this->fetchPost("password");
			if ($accountDb->login($username, $password)) {
				$this->redirect("Homepage", "index");
			}
			else {
				$this->setTemplate("account/loginForm");
				$this->setValue("errMsg", "Password error!");
			}
		}
	}
	
	function logoutAction() {
		$accountDb = new AccountDb;
		$accountDb->logout();
		$this->redirect("Homepage", "index");
	}
}
?>