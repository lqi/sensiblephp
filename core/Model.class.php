<?php
class Model {
	private $primaryKey;

	public function __get($key) {
		if ($key == "primaryKey")
			throw new Exception("Exception: No priviledge to get Primary Key attribute.");
		if ($key == "pk")
			return $this->getPK();
		return $this->$key;
	}
	
	function getPK() {
		$pkName = $this->getPKField();
		return $this->$pkName;
	}
	
	function getPKField() {
		if ($this->primaryKey == null)
			throw new Exception("Exception: Get primary key without define it.");
		return $this->primaryKey;
	}
	
	function setPKField($newPK) {
		foreach($this->getVars() as $attribute) {
			if ($attribute == $newPK) {
				$this->primaryKey = $newPK;
				return;
			}
		}
		throw new Exception("Exception: Set illigal attribute to Primary key.");
	}
	
	function getVars() {
		$varsArray = array_keys(get_object_vars($this));
		$length = count($varsArray);
		unset($varsArray[$length - 1]);
		return $varsArray;
	}
	
	function getVarsWithoutPK() {
		$varsArray = array();
		foreach($this->getVars() as $attribute) {
			if ($attribute != $this->getPKField()) {
				$varsArray[] = $attribute;
			}
		}
		return $varsArray;
	}
	
	function getModelName() {
		return get_class($this);
	}
	
	function getTableName() {
		return strtolower($this->getModelName());
	}
}