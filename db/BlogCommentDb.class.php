<?php
class BlogCommentDb extends Database {
	function getAllBlogComments() {
		$commentArray = array();
		$sql = "SELECT * FROM `blogcomment` ORDER BY `blog_id` DESC,`id` DESC";
		foreach ($this->query($sql) as $row) {
			$commentArray[] = $this->valueObject($row);
		}
		return $commentArray;
	}
	
	function getCommentsForBlogPost($blogId) {
		$commentArray = array();
		$sql = "SELECT * FROM `blogcomment` WHERE `blog_id` = " . $blogId . " ORDER BY `id` DESC";
		foreach ($this->query($sql) as $row) {
			$commentArray[] = $this->valueObject($row);
		}
		return $commentArray;
	}
	
	function deleteBlogCommentByBlogId($id) {
		$sql = "DELETE FROM `blogcomment` WHERE `blog_id`=" . $id;
		$rs = $this->db()->exec($sql);
		return $rs;		
	}
}
?>