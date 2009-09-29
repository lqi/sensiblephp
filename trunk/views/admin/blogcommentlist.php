<h1>Admin - Blog - Commentlist</h1>


<ul>

<?php
foreach($this->getValue("commentArray") as $id => $comment) {
?>

<li>

<p>
<?php echo $comment->id; ?> |
<?php echo $comment->blog_id; ?> |
<?php echo $comment->username; ?> @ 
<?php echo $comment->date; ?> : 
<?php echo $comment->comment; ?> | 
<a href="/Admin/blogcommentdelete?commentId=<?php echo $comment->id; ?>">Delete</a>
</p>

</li>

<?php
}
?>

</ul>