<?php
abstract class Model {
	private $primaryKey;

	public function __get($key) {
		if ($key == "primaryKey")
			throw new UnexpectedValueException("UnexpectedValueException: No priviledge to get Primary Key attribute.");
		if ($key == "pk")
			return $this->getPK();
		return $this->$key;
	}
	
	private function getPK() {
		$pkName = $this->getPKField();
		return $this->$pkName;
	}
	
	function getPKField() {
		if ($this->primaryKey == null)
			throw new BadFunctionCallException("BadFunctionCallException: Get primary key without define it.");
		return $this->primaryKey;
	}
	
	function setPKField($newPK) {
		foreach($this->getVars() as $attribute) {
			if ($attribute == $newPK) {
				$this->primaryKey = $newPK;
				return;
			}
		}
		throw new InvalidArgumentException("InvalidArgumentException: Set illigal attribute to Primary key.");
	}
	
	function getVars() {
		$varsArray = array_keys(get_object_vars($this));
		$returnArray = array();
		foreach($varsArray as $it) {
			if ($it != "primaryKey") {
				$returnArray[] = $it;
			}
		}
		return $returnArray;
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
