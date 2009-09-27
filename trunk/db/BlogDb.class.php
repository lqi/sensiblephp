<?php
class BlogDb {
	function getPostById($id) {
		$db = new Database;
		$blogModel = new BlogModel;
		$sql = "SELECT * FROM blog where id = " . $id;
		foreach($db->dbh->query($sql) as $row) {
			foreach($row as $key=>$value) {
				$blogModel->$key = $value;
			}
		}
		return $blogModel;
	}
}
?>