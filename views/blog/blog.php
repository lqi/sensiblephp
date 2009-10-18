<p><a href="/Blog">Back to Blog index</a></p>

<h1>Blog - <?php echo $this->getValue("blog")->title->getValue(); ?></h1>

<h3><?php echo $this->getValue("blog")->date->getValue(); ?></h3>

<p><?php echo $this->getValue("blog")->body->getValue(); ?></p>

<h2>Comments</h2>

<ul>

<?php
foreach($this->getValue("commentArray") as $id => $comment) {
?>

<li>

<p><?php echo $comment->username->getValue(); ?> @ <?php echo $comment->date->getValue(); ?> :</p>

<p><?php echo $comment->comment->getValue(); ?></p>

</li>

<?php
}
?>

</ul>

<h2>New Comment</h2>

<form action="/Blog/newcomment?blogId=<?php echo $this->getValue("blog")->id->getValue(); ?>" method="post">

<p>Your name: <input name="username" /></p>

<p>Your comment: <textarea name="comment" rows="5" cols="60"></textarea></p>

<p><input type="submit" value="Comment" /></p>

</form>