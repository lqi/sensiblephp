<?php
class AdminController extends Controller {
	function indexAction() {
		$this->setTemplate("admin/index");
	}
	
	function bloglistAction() {
		$this->setTemplate("admin/bloglist");
		$blogDb = new BlogDb;
		$blogArray = $blogDb->getAllBlogPosts();
		$this->setValue("blogArray", $blogArray);
	}
	
	function blogaddAction() {
		$this->setTemplate("admin/blogform");
	}
	
	function bloginsertAction() {
		$title = $this->fetchPost("title");
		$body = $this->fetchPost("body");
		$date = date("Y-m-d H:i:s");
		
		$blogDb = new BlogDb;
		$rs = $blogDb->insertNewBlogPost($date, $title, $body);
		if($rs) {
			$this->redirect("Admin", "bloglist");
		}
		else {
			echo "New Blog Post Error!";
		}
	}
	
	function blogeditAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("admin/blogform");
		
		$blogDb = new BlogDb;
		$blog = $blogDb->getPostById($id);
		$this->setValue("blog", $blog);
	}
	
	function blogupdateAction() {
		$id = $this->fetchPost("blogId");
		$title = $this->fetchPost("title");
		$body = $this->fetchPost("body");
		
		$blogDb = new BlogDb;
		$rs = $blogDb->updateBlogPost($id, $title, $body);
		if($rs) {
			$this->redirect("Admin", "bloglist");
		}
		else {
			echo "Update Blog Post Error!";
		}
	}
	
	function blogdeleteAction() {
		$id = $this->fetchGet("id");
		
		$blogDb = new BlogDb;
		$rs = $blogDb->deleteBlogPost($id);
		if($rs) {
			$blogDb->deleteBlogCommentByBlogId($id);
			$this->redirect("Admin", "bloglist");
		}
		else {
			echo "Delete Blog Post Error!";
		}
	}
	
	function blogcommentlistAction() {
		$this->setTemplate("admin/blogcommentlist");
		$blogDb = new BlogDb;
		$commentArray = $blogDb->getAllBlogComments();
		$this->setValue("commentArray", $commentArray);
	}
	
	function blogcommentdeleteAction() {
		$id = $this->fetchGet("commentId");
		$blogDb = new BlogDb;
		$rs = $blogDb->deleteBlogCommentByCommentId($id);
		if($rs) {
			$this->redirect("Admin", "blogcommentlist");
		}
		else {
			echo "Delete Blog Comment Error!";
		}
	}
}
?>