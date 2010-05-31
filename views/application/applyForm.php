<?php 
if ($this->getValue("errMsg")) {
?>
<div style="color:red;"><?php echo $this->getValue("errMsg"); ?></div>
<?php } ?>
<p>Apply jobs for user_id: <?php echo $this->getValue("userId"); ?></p>
<form action="/Application/processApply" method="POST">
<p>Department: <input name="dept" /></p>
<p><input type="submit" value="Apply" /></p>
</form>