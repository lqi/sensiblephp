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
	
	function getDictById($id)
	{
		$db = new Database;
		$sql = "SELECT * FROM `dictionary` WHERE `id`=" . $id;
		$dict = new Dictionary;
		foreach ($db->dbh->query($sql) as $row) {
			foreach ($row as $key => $value) {
				$dict->$key = $value;
			}
		}
		return $dict;
	}
	
	function updateCurrentDictItem($id, $definition) {
		$db = new Database;
		$sql = "UPDATE `dictionary` SET `definition`='" . $definition ."' WHERE `id`=" . $id;
		$rs = $db->dbh->exec($sql);
		return $rs;
	}
	
	function deleteDictionaryById($id) {
		$db = new Database;
		$sql = "DELETE FROM `dictionary` WHERE `id`=" . $id;
		$rs = $db->dbh->exec($sql);
		return $rs;
	}
}
?>