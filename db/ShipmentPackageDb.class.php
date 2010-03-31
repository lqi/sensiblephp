<?php
/**
* 
*/
class ShipmentPackageDb extends Database
{
	function getShipmentFromPackageId($packageId) {
		return $this->select("WHERE `packageId` = " . $packageId);
	}
	
	function getPackageIdFromShipmentId($shipmentId) {
		return $this->select("WHERE `shipmentId` = " . $shipmentId);
	}
}
