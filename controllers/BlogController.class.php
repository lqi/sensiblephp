<?php
class BlogController extends Controller {
	function indexAction() {
		$this->setTemplate("blog/index");
		$blogDb = new BlogDb;
		$blogArray = $blogDb->getLatestBlogPosts(10);
		$this->setValue("blogArray", $blogArray);
	}
	
	function blogAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("blog/blog");
		
		$blogDb = new BlogDb;
		$blog = $blogDb->getPostById($id);
		$this->setValue("blog", $blog);
		
		$blogCommentDb = new BlogCommentDb;
		$commentArray = $blogCommentDb->getCommentsForBlogPost($id);
		$this->setValue("commentArray", $commentArray);
	}
	
	function newcommentAction() {
		$blogId = $this->fetchGet("blogId");
		$username = $this->fetchPost("username");
		$comment = $this->fetchPost("comment");
		$date = date("Y-m-d H:i:s");
		
		$blogCommentDb = new BlogCommentDb;
		$rs = $blogCommentDb->insertNewComment($blogId, $date, $username, $comment);
		if($rs) {
			$this->redirect("Blog", "blog?id=" . $blogId);
		}
		else {
			echo "Comment Post Error!";
		}
	}

}

?>