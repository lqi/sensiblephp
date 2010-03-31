<?php
class ShipmentDb extends Database {
	function getShipment($trackingNumber) {
		return $this->select("WHERE `trackingNumber` = " . $trackingNumber);
	}
}