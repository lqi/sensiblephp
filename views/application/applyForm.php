<?php 
if ($this->getValue("errMsg")) {
?>
<div style="color:red;"><?php echo $this->getValue("errMsg"); ?></div>
<?php } ?>
<p>Apply jobs for user_id: <?php echo $this->getValue("userId"); ?></p>
<form action="/Application/processApply" method="POST">
<p>Choose the department you are applying:
<ul>
<?php
foreach ($this->getValue("departments") as $dept) {
	echo "<li><input type=\"radio\" value=\"" . $dept->department_id->getValue() . "\" name=\"department\" />" . $dept->name->getValue() . "</li>";
}
?>
</ul>
</p>
<p><input type="submit" value="Apply" /></p>
</form>