<?php
class AccountDb extends Database {
	function usernameExist($username) {
		return count($this->select("WHERE `username` = '" . $username . "'")) > 0;
	}
	
	function login($username, $password) {
		$loginTrail = $this->select("WHERE `username` = '" . $username . "' AND `password` = '" . $password . "'");
		if (count($loginTrail) == 1) {
			$account = $loginTrail[0];
			$_SESSION['account'] = $account;
			return true;
		}
		else {
			$this->logout();
			return false;
		}
	}
	
	function logout() {
		unset($_SESSION['account']);
	}
	
	function logedInAccount() {
		if (isset($_SESSION['account'])) {
			return $_SESSION['account'];
		}
		else {
			return false;
		}
	}
}
?>