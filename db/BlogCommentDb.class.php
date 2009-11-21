<?php
class BlogCommentDb extends Database {
	function getAllBlogComments() {
		return $this->select("ORDER BY `blog_id` DESC,`id` DESC");
	}
	
	function getCommentsForBlogPost($blogId) {
		return $this->select("WHERE `blog_id` = " . $blogId . " ORDER BY `id` DESC");
	}
	
	function deleteBlogCommentByBlogId($id) {
		return $this->delete("WHERE `blog_id`=" . $id);	
	}
}
?>