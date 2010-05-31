<?php 
$account = $this->getValue("account");
if ($account) {
?>
<div style="color:blue;">
Loged-in Account: <br />
user_id: <?php echo $account->user_id->getValue(); ?><br />
username: <?php echo $account->username->getValue(); ?><br />
privilege: <?php echo $account->privilege->getValue(); ?><br />
</div>
<?php } ?>
<p><a href="/Account/register">Register</a></p>
<?php if ($account) {?>
<p><a href="/Account/logout">Logout</a></p>
<?php } else {?>
<p><a href="/Account/login">Login</a></p>
<?php } ?>