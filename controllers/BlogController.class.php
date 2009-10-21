<?php
class BlogController extends Controller {
	function indexAction() {
		$this->setTemplate("blog/index");
		$blogDb = new BlogDb;
		$this->setValue("blogArray", $blogDb->filter(10));
	}
	
	function blogAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("blog/blog");
		
		$blogDb = new BlogDb;
		$this->setValue("blog", $blogDb->get($id));
		
		$blogCommentDb = new BlogCommentDb;
		$this->setValue("commentArray", $blogCommentDb->getCommentsForBlogPost($id));
	}
	
	function newcommentAction() {
		$blogId = (int) $this->fetchGet("blogId");
		$username = $this->fetchPost("username");
		$comment = $this->fetchPost("comment");
		//the following will be refactored
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$hour = date("H");
		$minute = date("i");
		$second = date("s");
		// the above will be refactored
		$blogComment = new BlogComment;
		$blogComment->date->setValue($year, $month, $day, $hour, $minute, $second);
		$blogComment->blog_id->setValue($blogId);
		$blogComment->username->setValue($username);
		$blogComment->comment->setValue($comment);
		
		$blogCommentDb = new BlogCommentDb;
		if($blogCommentDb->save($blogComment)) {
			$this->redirect("Blog", "blog?id=" . $blogId);
		}
		else {
			throw new Exception("Comment Post Error!");
		}
	}

}

?>