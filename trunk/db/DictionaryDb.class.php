<?php
class DictionaryDb extends Database {
	function getAllDictItems() {
		$dictItemsArray = array();
		$sql = "SELECT * FROM `dictionary` ORDER BY `id` DESC";
		foreach ($this->db()->query($sql) as $row) {
			$dictArray[] = $this->valueObject($row);
		}
		return $dictArray;
	}
	
	function insertNewDictItem($term, $definition) {
		$sql = "INSERT INTO `dictionary` (`term`, `definition`) " .
			   "VALUES ('" . $term . "', '" . $definition . "')";
		$rs = $this->db()->exec($sql);
		return $rs;
	}
	
	function getDictById($id)
	{
		$sql = "SELECT * FROM `dictionary` WHERE `id`=" . $id;
		foreach ($this->db()->query($sql) as $row) {
			$dict = $this->valueObject($row);
		}
		return $dict;
	}
	
	function updateCurrentDictItem($id, $definition) {
		$sql = "UPDATE `dictionary` SET `definition`='" . $definition ."' WHERE `id`=" . $id;
		$rs = $this->db()->exec($sql);
		return $rs;
	}
	
	function deleteDictionaryById($id) {
		$sql = "DELETE FROM `dictionary` WHERE `id`=" . $id;
		$rs = $this->db()->exec($sql);
		return $rs;
	}
}
?>