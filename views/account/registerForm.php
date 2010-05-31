<?php 
if ($this->getValue("errMsg")) {
?>
<div style="color:red;"><?php echo $this->getValue("errMsg"); ?></div>
<?php } ?>
<form action="/Account/processRegister" method="POST">
<p>Username: <input name="username" /></p>
<p>Password: <input type="password" name="password" /></p>
<p><input type="submit" value="Register" /></p>
</form>