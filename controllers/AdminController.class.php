<?php
class AdminController extends Controller {
	function indexAction() {
		$this->setTemplate("admin/index");
	}
	
	function bloglistAction() {
		$this->setTemplate("admin/bloglist");
		$blogDb = new BlogDb;
		$this->setValue("blogArray", $blogDb->getAllBlogPosts());
	}
	
	function blogaddAction() {
		$this->setTemplate("admin/blogform");
	}
	
	function bloginsertAction() {
		$title = $this->fetchPost("title");
		$body = $this->fetchPost("body");
		$date = date("Y-m-d H:i:s");
		
		$blogDb = new BlogDb;
		if($blogDb->insertNewBlogPost($date, $title, $body)) {
			$this->redirect("Admin", "bloglist");
		}
		else {
			throw new Exception("New Blog Post Error!");
		}
	}
	
	function blogeditAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("admin/blogform");
		
		$blogDb = new BlogDb;
		$this->setValue("blog", $blogDb->getPostById($id));
	}
	
	function blogupdateAction() {
		$id = $this->fetchPost("blogId");
		$title = $this->fetchPost("title");
		$body = $this->fetchPost("body");
		
		$blogDb = new BlogDb;
		if($blogDb->updateBlogPost($id, $title, $body)) {
			$this->redirect("Admin", "bloglist");
		}
		else {
			throw new Exception("Update Blog Post Error!");
		}
	}
	
	function blogdeleteAction() {
		$id = $this->fetchGet("id");
		
		$blogDb = new BlogDb;
		$blogCommentDb = new BlogCommentDb;
		if($blogDb->deleteBlogPost($id)) {
			$blogCommentDb->deleteBlogCommentByBlogId($id);
			$this->redirect("Admin", "bloglist");
		}
		else {
			throw new Exception("Delete Blog Post Error!");
		}
	}
	
	function blogcommentlistAction() {
		$this->setTemplate("admin/blogcommentlist");
		$blogCommentDb = new BlogCommentDb;
		$this->setValue("commentArray", $blogCommentDb->getAllBlogComments());
	}
	
	function blogcommentdeleteAction() {
		$id = $this->fetchGet("commentId");
		$blogCommentDb = new BlogCommentDb;
		if($blogCommentDb->deleteBlogCommentByCommentId($id)) {
			$this->redirect("Admin", "blogcommentlist");
		}
		else {
			throw new Exception("Delete Blog Comment Error!");
		}
	}
	
	function dictlistAction() {
		$dictDb = new DictionaryDb;
		$this->setTemplate("admin/dictlist");
		$this->setValue("dictArray", $dictDb->getAllDictItems());
	}
	
	function dictaddAction() {
		$this->setTemplate("admin/dictform");
	}
	
	function dictinsertAction() {
		$term = $this->fetchPost("term");
		$definition = $this->fetchPost("definition");
		$dictDb = new DictionaryDb;
		if($dictDb->insertNewDictItem($term, $definition)) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			throw new Exception("Insert New Dict Error!");
		}
	}
	
	function dicteditAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("admin/dicteditform");

		$dictDb = new DictionaryDb;
		$this->setValue("dict", $dictDb->getDictById($id));
	}
	
	function dictupdateAction() {
		$id = $this->fetchPost("id");
		$definition = $this->fetchPost("definition");
		
		$dictDb = new DictionaryDb;
		if($dictDb->updateCurrentDictItem($id, $definition)) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			throw new Exception("Update Dict Error!");
		}
	}
	
	function dictdeleteAction() {
		$id = $this->fetchGet("id");
		$dictDb = new DictionaryDb;
		if($dictDb->deleteDictionaryById($id)) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			throw new Exception("Delete Dictionary Error!");
		}
	}
}
?>