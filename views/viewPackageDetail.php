
<?php
foreach($this->getValue("packages") as $id => $package) {
?>


<h2><?php echo $package->packageId->getValue(); ?></h2>

<?php

}
?>
