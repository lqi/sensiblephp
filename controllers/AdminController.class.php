<?php
class AdminController extends Controller {
	function indexAction() {
		$this->setTemplate("admin/index");
	}
	
	function bloglistAction() {
		$this->setTemplate("admin/bloglist");
		$blogDb = new BlogDb;
		$this->setValue("blogArray", $blogDb->all());
	}
	
	function blogaddAction() {
		$this->setTemplate("admin/blogform");
	}
	
	function bloginsertAction() {
		$title = $this->fetchPost("title");
		$body = $this->fetchPost("body");
		//the following will be refactored
		$year = date("Y");
		$month = date("m");
		$day = date("d");
		$hour = date("H");
		$minute = date("i");
		$second = date("s");
		// the above will be refactored
		$blog = new Blog;
		$blog->date->setValue($year, $month, $day, $hour, $minute, $second);
		$blog->title->setValue($title);
		$blog->body->setValue($body);
		
		$blogDb = new BlogDb;
		if($blogDb->save($blog)) {
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
		$this->setValue("blog", $blogDb->get($id));
	}
	
	function blogupdateAction() {
		$id = $this->fetchPost("blogId");
		$title = $this->fetchPost("title");
		$body = $this->fetchPost("body");
		
		$blogDb = new BlogDb;
		$date = $blogDb->get($id)->date->getValue();
		
		$blog = new Blog;
		//the following will be refactored
		$blog->id->setValue((int) $id);
		$year = substr($date, 0, 4);
		$month = substr($date, 5, 2);
		$day = substr($date, 8, 2);
		$hour = substr($date, 11, 2);
		$minute = substr($date, 14, 2);
		$second = substr($date, 17, 2);
		$blog->date->setValue($year, $month, $day, $hour, $minute, $second);
		// the above will be refactored
		$blog->title->setValue($title);
		$blog->body->setValue($body);
		
		if($blogDb->save($blog)) {
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
		if($blogDb->rm($id)) {
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
		if($blogCommentDb->rm($id)) {
			$this->redirect("Admin", "blogcommentlist");
		}
		else {
			throw new Exception("Delete Blog Comment Error!");
		}
	}
	
	function dictlistAction() {
		$dictDb = new DictionaryDb;
		$this->setTemplate("admin/dictlist");
		$this->setValue("dictArray", $dictDb->all());
	}
	
	function dictaddAction() {
		$this->setTemplate("admin/dictform");
	}
	
	function dictinsertAction() {
		$dict = new Dictionary;
		$dict->term->setValue($this->fetchPost("term"));
		$dict->definition->setValue($this->fetchPost("definition"));
		
		$dictDb = new DictionaryDb;
		if($dictDb->save($dict)) {
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
		$this->setValue("dict", $dictDb->get($id));
	}
	
	function dictupdateAction() {
		$dict = new Dictionary;
		$dict->id->setValue((int)$this->fetchPost("id"));
		$dict->definition->setValue($this->fetchPost("definition"));
		
		$dictDb = new DictionaryDb;
		$term = $dictDb->get((int)$this->fetchPost("id"))->term->getValue();
		$dict->term->setValue($term);
		if($dictDb->save($dict)) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			throw new Exception("Update Dict Error!");
		}
	}
	
	function dictdeleteAction() {
		$id = $this->fetchGet("id");
		$dictDb = new DictionaryDb;
		if($dictDb->rm($id)) {
			$this->redirect("Admin", "dictlist");
		}
		else {
			throw new Exception("Delete Dictionary Error!");
		}
	}
}
?>