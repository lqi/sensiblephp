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
		$blogCommentDb = new BlogCommentDb;
		$rs = $blogDb->deleteBlogPost($id);
		if($rs) {
			$blogCommentDb->deleteBlogCommentByBlogId($id);
			$this->redirect("Admin", "bloglist");
		}
		else {
			echo "Delete Blog Post Error!";
		}
	}
	
	function blogcommentlistAction() {
		$this->setTemplate("admin/blogcommentlist");
		$blogCommentDb = new BlogCommentDb;
		$commentArray = $blogCommentDb->getAllBlogComments();
		$this->setValue("commentArray", $commentArray);
	}
	
	function blogcommentdeleteAction() {
		$id = $this->fetchGet("commentId");
		$blogCommentDb = new BlogCommentDb;
		$rs = $blogCommentDb->deleteBlogCommentByCommentId($id);
		if($rs) {
			$this->redirect("Admin", "blogcommentlist");
		}
		else {
			echo "Delete Blog Comment Error!";
		}
	}
	
	function dictlistAction() {
		$dictDb = new DictionaryDb;
		$dictItems = $dictDb->getAllDictItems();
		$this->setTemplate("admin/dictlist");
		$this->setValue("dictArray", $dictItems);
	}
	
	function dictaddAction() {
		$this->setTemplate("admin/dictform");
	}
	
	function dictinsertAction() {
		$term = $this->fetchPost("term");
		$definition = $this->fetchPost("definition");
		$dictDb = new DictionaryDb;
		$rs = $dictDb->insertNewDictItem($term, $definition);
		if($rs) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			echo "Insert New Dict Error!";
		}
	}
	
	function dicteditAction() {
		$id = $this->fetchGet("id");
		$this->setTemplate("admin/dicteditform");

		$dictDb = new DictionaryDb;
		$dict = $dictDb->getDictById($id);
		$this->setValue("dict", $dict);
	}
	
	function dictupdateAction() {
		$id = $this->fetchPost("id");
		$definition = $this->fetchPost("definition");
		
		$dictDb = new DictionaryDb;
		$rs = $dictDb->updateCurrentDictItem($id, $definition);
		if($rs) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			echo "Update Dict Error!";
		}
	}
	
	function dictdeleteAction() {
		$id = $this->fetchGet("id");
		$dictDb = new DictionaryDb;
		$rs = $dictDb->deleteDictionaryById($id);
		if($rs) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			echo "Delete Dictionary Error!";
		}
	}
}
?>