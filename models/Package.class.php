<?php
/**
* 
*/
class Package extends Model
{
	protected $packageId;
	
	public function __construct() {
		$this->packageId = new IntegerField;
		$this->setPKField("packageId");
	}
}
