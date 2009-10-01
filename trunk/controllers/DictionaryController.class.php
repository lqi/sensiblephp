<?php
class DictionaryController extends Controller {
	function indexAction() {
		$dictDb = new DictionaryDb;
		$dictItems = $dictDb->getAllDictItems();
		$this->setTemplate("dict/index");
		$this->setValue("dictArray", $dictItems);
	}
}
?>