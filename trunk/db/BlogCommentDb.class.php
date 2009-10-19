<?php
class BlogCommentDb extends Database {
	function getAllBlogComments() {
		$commentArray = array();
		$sql = "SELECT * FROM `blogcomment` ORDER BY `blog_id` DESC,`id` DESC";
		foreach ($this->db()->query($sql) as $row) {
			$commentArray[] = $this->valueObject($row);
		}
		return $commentArray;
	}
	
	function getCommentsForBlogPost($blogId) {
		$commentArray = array();
		$sql = "SELECT * FROM `blogcomment` WHERE `blog_id` = " . $blogId . " ORDER BY `id` DESC";
		foreach ($this->db()->query($sql) as $row) {
			$commentArray[] = $this->valueObject($row);
		}
		return $commentArray;
	}
	
	function deleteBlogCommentByCommentId($id) {
		$sql = "DELETE FROM `blogcomment` WHERE `id`=" . $id;
		$rs = $this->db()->exec($sql);
		return $rs;		
	}
	
	function deleteBlogCommentByBlogId($id) {
		$sql = "DELETE FROM `blogcomment` WHERE `blog_id`=" . $id;
		$rs = $this->db()->exec($sql);
		return $rs;		
	}
	
	function insertNewComment($blogId, $date, $username, $comment) {
		$sql = "INSERT INTO `blogcomment` (`blog_id`, `date`, `username`, `comment`) " .
			   "VALUES (" . $blogId . ", '" . $date . "', '" . $username . "', '" . $comment . "')";
		$rs = $this->db()->exec($sql);
		return $rs;
	}
}
?>