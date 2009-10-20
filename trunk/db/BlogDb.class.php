<?php
class BlogDb extends Database {
	function getPostById($id) {
		return $this->get($id);
	}	
	
	function getAllBlogPosts() {
		return $this->all();
	}
	
	function getLatestBlogPosts($num) {
		return $this->filter($num);
	}
	
	function insertNewBlogPost($date, $title, $body) {
		$sql = "INSERT INTO `blog` (`date`, `title`, `body`) " .
			   "VALUES ('" . $date . "', '" . $title . "', '" . $body . "')";
		$rs = $this->execute($sql);
		return $rs;
	}
	
	function updateBlogPost($id, $title, $body) {
		$sql = "UPDATE `blog` SET `title`='" . $title . "', `body`='" . $body . "'" .
			   "WHERE `id`=" . $id;
		$rs = $this->execute($sql);
		return $rs;
	}
	
	function deleteBlogPost($id) {
		return $this->rm($id);
	}
}
?>