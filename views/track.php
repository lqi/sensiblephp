<ul>
<?php
foreach($this->getValue("shipment") as $id => $shipment) {
?>

<li>

<h2><?php echo $shipment->shipmentId->getValue(); ?></h2>
<p><?php echo $shipment->trackingNumber->getValue(); ?></h2>
</li>
<?php

}
?>
</ul>