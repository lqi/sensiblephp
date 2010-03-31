<?php
/**
* 
*/
class CompanyManagerController extends Controller
{
	function viewPackageDetailAction() {
		$packageId = (int) $this->fetchGet("packageNumber");
		$this->setTemplate("viewPackageDetail");
		
		/*
		if (isLogined()) {
			throw Exception("User not login!");
		}
		isCM();
		*/
		
		$shipmentPackageDb = new ShipmentPackageDb;
		$shipments = $shipmentPackageDb->getShipmentFromPackageId($packageId);
		$shipment = $shipments[0];
		$shipmentId = $shipment->shipmentId->getValue();
		
		$packageIds = $shipmentPackageDb->getPackageIdFromShipmentId($shipmentId);
		
		$packageArray = array();
		
		foreach ($packageIds as $key => $value) {
			$it = $value->packageId->getValue();
			$packageDb = new PackageDb;
			$package = $packageDb->get($it);
			$packageArray[] = $package;
		}
		
		$this->setValue("packages", $packageArray);
	}
	
}
