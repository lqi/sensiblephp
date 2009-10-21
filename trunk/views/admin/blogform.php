<?php
$editFlag = ($this->getValue("blog")) ? true : false;
if ($editFlag) {
?>
	<h1>Admin - Edit Blog</h1>

	<form action="/Admin/blogupdate" method="post">		
<?php
}
else {
?>
	<h1>Admin - Add new blog</h1>

	<form action="/Admin/bloginsert" method="post">
<?php
}
?>


<?php
if($editFlag) {
?>

<p>Id: <?php echo $this->getValue("blog")->id->getValue(); ?></p>
<input type="hidden" name="blogId" value="<?php echo $this->getValue("blog")->id->getValue(); ?>" />
<?php
}

?>

<p>Title: </p>
<p><input name="title" value="<?php
if($editFlag) {
 echo $this->getValue("blog")->title->getOriginalValue();
}

?>" /></p>

<p>Body: </p>
<p><textarea name="body" rows="20" cols="90"><?php
if($editFlag) {
 echo $this->getValue("blog")->body->getOriginalValue();
}

?></textarea></p>

<p><input type="submit" value="<?php echo ($this->getValue("blog"))?"Update blog":"Add new blog"; ?>" /></p>

</form>