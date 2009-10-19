<?php
class DictionaryController extends Controller {
	function indexAction() {
		$dictDb = new DictionaryDb;
		$this->setTemplate("dict/index");
		$this->setValue("dictArray", $dictDb->getAllDictItems());
	}
}
?>