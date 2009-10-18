<?php
$dict = $this->getValue("dict");
?>
<h1>Admin - Dict - Dictionary Edit</h1>
<form action="/Admin/dictupdate" method="post">
<input type="hidden" name="id" value="<?php echo $dict->id->getValue(); ?>" />
<p>Term: <?php echo $dict->term->getValue(); ?></p>
<p>Definition: <textarea name="definition"><?php echo $dict->definition->getValue(); ?></textarea></p>
<input type="submit" />
</form>