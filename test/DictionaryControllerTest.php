<?php
require_once(dirname(dirname(__file__)) . "/sensiblephp/init.php");

class DictControllerTest extends PHPUnit_Framework_TestCase {
	public function testIndexAction() {
		$mockDictController = $this->getMock('DictionaryController', array('setTemplate', 'setValue'));
		$mockDictController->expects($this->once())->method('setTemplate')->with($this->equalTo('dict/index'));
		$mockDictController->expects($this->once())->method('setValue')->with($this->equalTo('dictArray'), $this->equalTo('test'));
		$mockDictController->indexAction();
	}
}
?>