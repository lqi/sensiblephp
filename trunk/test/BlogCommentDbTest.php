<?php
require_once(dirname(dirname(__file__)) . "/sensiblephp/init.php");

class BlogCommentDbTest extends PHPUnit_Framework_TestCase {
	public function testGetAllBlogComments() {
		$mockBlogCommentDb = $this->getMock('BlogCommentDb', array('select'));
		$mockBlogCommentDb->expects($this->once())->method('select')->with($this->equalTo('ORDER BY `blog_id` DESC,`id` DESC'));
		$mockBlogCommentDb->getAllBlogComments();
	}
	
	public function testGetCommentsForBlogPost() {
		$mockBlogCommentDb = $this->getMock('BlogCommentDb', array('select'));
		$mockBlogCommentDb->expects($this->once())->method('select')->with($this->equalTo('WHERE `blog_id` = 1 ORDER BY `id` DESC'));
		$mockBlogCommentDb->getCommentsForBlogPost(1);
	}
	
	public function testDeleteBlogCommentByBlogId() {
		$mockBlogCommentDb = $this->getMock('BlogCommentDb', array('delete'));
		$mockBlogCommentDb->expects($this->once())->method('delete')->with($this->equalTo('WHERE `blog_id`=1'));
		$mockBlogCommentDb->deleteBlogCommentByBlogId(1);
	}
}
?>