<?php
class BlogDb extends Database {
	function getPostById($id) {
		$sql = "SELECT * FROM `blog` WHERE `id` = " . $id;
		foreach($this->db()->query($sql) as $row) {
			$blog = $this->valueObject($row);
		}
		return $blog;
	}	
	
	function getAllBlogPosts() {
		$blogArray = array();
		$sql = "SELECT * FROM `blog` ORDER BY `id` DESC";
		foreach($this->db()->query($sql) as $row) {
			$blogArray[] = $this->valueObject($row);
		}
		return $blogArray;
	}
	
	function getLatestBlogPosts($num) {
		$blogArray = array();
		$sql = "SELECT * FROM `blog` ORDER BY `id` DESC LIMIT 0, " . $num;
		foreach($this->db()->query($sql) as $row) {
			$blogArray[] = $this->valueObject($row);
		}
		return $blogArray;
	}
	
	function insertNewBlogPost($date, $title, $body) {
		$sql = "INSERT INTO `blog` (`date`, `title`, `body`) " .
			   "VALUES ('" . $date . "', '" . $title . "', '" . $body . "')";
		$rs = $this->db()->exec($sql);
		return $rs;
	}
	
	function updateBlogPost($id, $title, $body) {
		$sql = "UPDATE `blog` SET `title`='" . $title . "', `body`='" . $body . "'" .
			   "WHERE `id`=" . $id;
		$rs = $this->db()->exec($sql);
		return $rs;
	}
	
	function deleteBlogPost($id) {
		$sql = "DELETE FROM `blog` WHERE `id`=" . $id;
		$rs = $this->db()->exec($sql);
		return $rs;
	}
}
?>