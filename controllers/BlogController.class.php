<?php
class BlogController extends Controller {
	function indexAction() {
		$this->setTemplate("blog/index");
		$blogDb = new BlogDb;
		$this->setValue("blogArray", $blogDb->getLatestBlogPosts(10));
	}
	
	function blogAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("blog/blog");
		
		$blogDb = new BlogDb;
		$this->setValue("blog", $blogDb->getPostById($id));
		
		$blogCommentDb = new BlogCommentDb;
		$this->setValue("commentArray", $blogCommentDb->getCommentsForBlogPost($id));
	}
	
	function newcommentAction() {
		$blogId = $this->fetchGet("blogId");
		$username = $this->fetchPost("username");
		$comment = $this->fetchPost("comment");
		$date = date("Y-m-d H:i:s");
		
		$blogCommentDb = new BlogCommentDb;
		if($blogCommentDb->insertNewComment($blogId, $date, $username, $comment)) {
			$this->redirect("Blog", "blog?id=" . $blogId);
		}
		else {
			throw new Exception("Comment Post Error!");
		}
	}

}

?>