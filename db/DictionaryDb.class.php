<?php
class DictionaryDb {
	function getAllDictItems() {
		$db = new Database;
		$dictItemsArray = array();
		$sql = "SELECT * FROM `dictionary` ORDER BY `id` DESC";
		foreach ($db->dbh->query($sql) as $row) {
			$dict = new Dictionary;
			foreach ($row as $key => $value) {
				$dict->$key = $value;
			}
			$dictArray[] = $dict;
		}
		return $dictArray;
	}
	
	function insertNewDictItem($term, $definition) {
		$db = new Database;
		$sql = "INSERT INTO `dictionary` (`term`, `definition`) " .
			   "VALUES ('" . $term . "', '" . $definition . "')";
		$rs = $db->dbh->exec($sql);
		return $rs;
	}
}
?>