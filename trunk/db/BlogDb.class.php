<?php
class BlogDb extends Database {
	function getPostById($id) {
		return $this->get($id);
	}	
	
	function getAllBlogPosts() {
		return $this->all();
	}
	
	function getLatestBlogPosts($num) {
		return $this->filter($num);
	}
	
	function insertNewBlogPost($date, $title, $body) {
		$blog = new Blog;
		//the following will be refactored
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
		return $this->save($blog);
	}
	
	function updateBlogPost($id, $date, $title, $body) {
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
		return $this->save($blog);
	}
	
	function deleteBlogPost($id) {
		return $this->rm($id);
	}
}
?>