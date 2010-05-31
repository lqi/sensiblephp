<?php 
if ($this->getValue("errMsg")) {
?>
<div style="color:red;"><?php echo $this->getValue("errMsg"); ?></div>
<?php } ?>
<p>Fill the info for user_id: <?php echo $this->getValue("userId"); ?></p>
<form action="/BasicInfo/processInfo" method="POST">
<p>Real Name: <input name="realname" /></p>
<p><input type="submit" value="Submit" /></p>
</form>