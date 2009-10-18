<h1>Admin - Blog - Bloglist</h1>

<p><a href="/Admin/blogadd">Add new blog</a></p>

<ul>

<?php
foreach($this->getValue("blogArray") as $id => $blog) {
?>

<li>
| 
<?php echo $blog->id->getValue(); ?> | 
<?php echo $blog->date->getValue(); ?> | 
<?php echo $blog->title->getValue(); ?> | 
<a href="/Admin/blogedit?id=<?php echo $blog->id->getValue(); ?>">Edit</a> | 
<a href="/Admin/blogdelete?id=<?php echo $blog->id->getValue(); ?>">Delete</a> |

</li>

<?php
}
?>

</ul>

<h2><a href="/Admin/blogcommentlist">Comment Management<a/></h2>