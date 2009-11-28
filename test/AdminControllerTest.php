<?php
require_once(dirname(dirname(__file__)) . "/sensiblephp/init.php");

class BlogDb {
	function all() {
		return "test";
	}
	
	function save($foo) {
		return true;
	}
	
	function get($foo) {
		$blog = new Blog;
		return $blog;
	}
	
	function rm($foo) {
		if($foo == 1)
			return true;
		else
			return false;
	}
	
	function filter($foo) {
		return "test";
	}
}

class DictionaryDb {
	function all() {
		return "test";
	}
	
	function save($foo) {
		return true;
	}
	
	function get($foo) {
		$dictionary = new Dictionary;
		return $dictionary;
	}
	
	function rm($foo) {
		if($foo == 1)
			return true;
		else
			return false;
	}
}

class BlogCommentDb {
	function getAllBlogComments() {
		return $this->select("ORDER BY `blog_id` DESC,`id` DESC");
	}
	
	function getCommentsForBlogPost($blogId) {
		return $this->select("WHERE `blog_id` = " . $blogId . " ORDER BY `id` DESC");
	}
	
	function deleteBlogCommentByBlogId($id) {
		return $this->delete("WHERE `blog_id`=" . $id);	
	}
	
	function select($foo) {
		return "test";
	}
	
	function delete($foo) {
		return true;
	}
	
	function rm($foo) {
		if($foo == 1)
			return true;
		else
			return false;
	}
	
	function save($foo) {
		return true;
	}
}

class TestField {
	function setValue($a = 0, $b = 0, $c = 0, $d = 0, $e = 0, $f = 0) {
		// do nothing
	}
	
	function processingPDOValue($a) {
		// do nothing
	}
	
	function getValue() {
		return "test";
	}
}

class Blog extends Model {
	protected $id;
	protected $date;
	protected $title;
	protected $body;
	
	public function __construct() {
		$this->id = new TestField;
		$this->date = new TestField;
		$this->title = new TestField;
		$this->body = new TestField;
		$this->setPKField("id");
	}
}

class Dictionary extends Model {
	protected $id;
	protected $term;
	protected $definition;
	
	public function __construct() {
		$this->id = new TestField;
		$this->term = new TestField;
		$this->definition = new TestField;
		$this->setPKField("id");
	}
}

class AdminControllerTest extends PHPUnit_Framework_TestCase {
	public function testGetAllBlogComments() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/index'));
		$mockAdminController->indexAction();
	}
	
	public function testBloglistAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/bloglist'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('blogArray'), $this->equalTo('test'));
		$mockAdminController->bloglistAction();
	}
	
	public function testBlogaddAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/blogform'));
		$mockAdminController->blogaddAction();
	}
	
	public function testBlogInsertAction() {
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('bloglist'));
		$mockAdminController->bloginsertAction();
	}
	
	public function testBlogeditAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/blogform'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('blog'), $this->equalTo(new Blog));
		$mockAdminController->blogeditAction();
	}
	
	public function testBlogupdateAction() {
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('bloglist'));
		$mockAdminController->blogupdateAction();
	}
	
	public function testBlogdeleteAction() {
		$_GET = array("id" => 1);
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('bloglist'));
		$mockAdminController->blogdeleteAction();
	}
	
	public function testBlogdeleteActionWithException() {
		$_GET = array("id" => 2);
		$controller = new AdminController;
		try {
			$controller->blogdeleteAction();
		}
		catch(Exception $ex) {
			return;
		}
		$this->fail("Exception expected: remove error.");
	}
	
	public function testBlogCommentListAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/blogcommentlist'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('commentArray'), $this->equalTo('test'));
		$mockAdminController->blogcommentlistAction();
	}
	
	public function testBlogcommentDeleteAction() {
		$_GET = array("commentId" => 1);
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('blogcommentlist'));
		$mockAdminController->blogcommentdeleteAction();
	}
	
	public function testBlogcommentDeleteActionWithException() {
		$_GET = array("commentId" => 2);
		$controller = new AdminController;
		try {
			$controller->blogcommentdeleteAction();
		}
		catch(Exception $ex) {
			return;
		}
		$this->fail("Exception expected: remove error.");
	}
	
	public function testDictListAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/dictlist'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('dictArray'), $this->equalTo('test'));
		$mockAdminController->dictlistAction();
	}
	
	public function testDictaddAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/dictform'));
		$mockAdminController->dictaddAction();
	}
	
	public function testDictInsertAction() {
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('dictlist'));
		$mockAdminController->dictinsertAction();
	}
	
	public function testDicteditAction() {
		$mockAdminController = $this->getMock('AdminController', array('setTemplate', 'setValue'));
		$mockAdminController->expects($this->once())->method('setTemplate')->with($this->equalTo('admin/dicteditform'));
		$mockAdminController->expects($this->once())->method('setValue')->with($this->equalTo('dict'), $this->equalTo(new Dictionary));
		$mockAdminController->dicteditAction();
	}
	
	public function testDictupdateAction() {
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('dictlist'));
		$mockAdminController->dictupdateAction();
	}
	
	public function testDictdeleteAction() {
		$_GET = array("id" => 1);
		$mockAdminController = $this->getMock('AdminController', array('redirect'));
		$mockAdminController->expects($this->once())->method('redirect')->with($this->equalTo('Admin'), $this->equalTo('dictlist'));
		$mockAdminController->dictdeleteAction();
	}
	
	public function testDictdeleteActionWithException() {
		$_GET = array("id" => 2);
		$controller = new AdminController;
		try {
			$controller->dictdeleteAction();
		}
		catch(Exception $ex) {
			return;
		}
		$this->fail("Exception expected: remove error.");
	}
}
?>