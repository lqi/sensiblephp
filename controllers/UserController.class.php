<?php
class UserController extends Controller
{
	function trackAction() {
		$trackingNumber = (int) $this->fetchGet("trackingNumber");
		$this->setTemplate("track");
		
		$shipmentDb = new ShipmentDb;
		$this->setValue("shipment", $shipmentDb->getShipment($trackingNumber));
	}
}
