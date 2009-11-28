<?php
require_once(dirname(dirname(__file__)) . "/sensiblephp/init.php");

class BlogComment extends Model {
	protected $id;
	protected $blog_id;
	protected $date;
	protected $username;
	protected $comment;
	
	public function __construct() {
		$this->id = new TestField;
		$this->blog_id = new TestField;
		$this->date = new TestField;
		$this->username = new TestField;
		$this->comment = new TestField;
		$this->setPKField("id");
	}
}

class BlogControllerTest extends PHPUnit_Framework_TestCase {
	public function testIndexAction() {
		$mockBlogController = $this->getMock('BlogController', array('setTemplate', 'setValue'));
		$mockBlogController->expects($this->once())->method('setTemplate')->with($this->equalTo('blog/index'));
		$mockBlogController->expects($this->once())->method('setValue')->with($this->equalTo('blogArray'), $this->equalTo('test'));
		$mockBlogController->indexAction();
	}
	
	public function testBlogAction() {
		$mockBlogController = $this->getMock('BlogController', array('setTemplate', 'setValue'));
		$mockBlogController->expects($this->once())->method('setTemplate')->with($this->equalTo('blog/blog'));
		//$mockBlogController->expects($this->any())->method('setValue')->with($this->equalTo('blog') || $this->equalTo('commentArray'), $this->equalTo(new Blog) || $this->equalTo("test"));
		$mockBlogController->blogAction();
	}
	
	public function testNewCommentAction() {
		$_GET = array("blogId" => 1);
		$mockBlogController = $this->getMock('BlogController', array('redirect'));
		$mockBlogController->expects($this->once())->method('redirect')->with($this->equalTo('Blog'), $this->equalTo('blog?id=1'));
		$mockBlogController->newcommentAction();
	}
}
?>