<h1>Admin - Blog - Commentlist</h1>


<ul>

<?php
foreach($this->getValue("commentArray") as $id => $comment) {
?>

<li>

<p>
<?php echo $comment->id->getValue(); ?> |
<?php echo $comment->blog_id->getValue(); ?> |
<?php echo $comment->username->getValue(); ?> @ 
<?php echo $comment->date->getValue(); ?> : 
<?php echo $comment->comment->getValue(); ?> | 
<a href="/Admin/blogcommentdelete?commentId=<?php echo $comment->id->getValue(); ?>">Delete</a>
</p>

</li>

<?php
}
?>

</ul>