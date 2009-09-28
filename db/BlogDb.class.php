<?php
class BlogDb {
	function getPostById($id) {
		$db = new Database;
		$blog = new Blog;
		$sql = "SELECT * FROM `blog` WHERE `id` = " . $id;
		foreach($db->dbh->query($sql) as $row) {
			foreach($row as $key=>$value) {
				$blog->$key = $value;
			}
		}
		return $blog;
	}
	
	function getLatestBlogPosts($num) {
		$db = new Database;
		$blogArray = array();
		$sql = "SELECT * FROM `blog` ORDER BY `id` DESC LIMIT 0, " . $num;
		foreach($db->dbh->query($sql) as $row) {
			$blog = new Blog;
			foreach($row as $key => $value) {
				$blog->$key = $value;	
			}
			$blogArray[] = $blog;
		}
		return $blogArray;
	}
	
	function getCommentsForBlogPost($blogId) {
		$db = new Database;
		$commentArray = array();
		$sql = "SELECT * FROM `blog_comment` WHERE `blog_id` = " . $blogId . " ORDER BY `id` DESC";
		foreach ($db->dbh->query($sql) as $row) {
			$comment = new BlogComment;
			foreach ($row as $key => $value) {
				$comment->$key = $value;
			}
			$commentArray[] = $comment;
		}
		return $commentArray;
	}
	
	function insertNewComment($blogId, $date, $username, $comment) {
		$db = new Database;
		$sql = "INSERT INTO `blog_comment` (`blog_id`, `date`, `username`, `comment`) " .
			   "VALUES (" . $blogId . ", '" . $date . "', '" . $username . "', '" . $comment . "')";
		$rs = $db->dbh->exec($sql);
		return $rs;
	}
}
?>