<?php
/**
* 
*/
class ShipmentPackage extends Model
{
	protected $id;
	protected $shipmentId;
	protected $packageId;
	
	public function __construct() {
		$this->id = new IntegerField;
		$this->shipmentId = new IntegerField;
		$this->packageId = new IntegerField;
		$this->setPKField("id");
	}
}
