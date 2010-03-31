<?php
class Shipment extends Model {
	protected $shipmentId;
	protected $trackingNumber;
	protected $productType;
	protected $shipType;
	protected $serviceType;
	protected $destination;
	
	public function __construct() {
		$this->shipmentId = new IntegerField;
		$this->trackingNumber = new IntegerField;
		$this->productType = new StringField;
		$this->shipType = new StringField;
		$this->serviceType = new StringField;
		$this->destination = new StringField;
		$this->setPKField("shipmentId");
	}
}