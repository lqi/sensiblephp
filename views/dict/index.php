<h1>Dictionary</h1>

<ul>

<?php
foreach($this->getValue("dictArray") as $num => $dict) {
?>

<li>

<h2><?php echo $dict->term->getValue(); ?></h2>

<h3><?php echo $dict->definition->getValue(); ?></h3>

</li>

<?php
}
?>

</ul>
