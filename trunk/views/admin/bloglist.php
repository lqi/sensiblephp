<h1>Admin - Blog - Bloglist</h1>

<p><a href="/Admin/blogadd">Add new blog</a></p>

<ul>

<?php
foreach($this->getValue("blogArray") as $id => $blog) {
?>

<li>
| 
<?php echo $blog->id; ?> | 
<?php echo $blog->date; ?> | 
<?php echo $blog->title; ?> | 
<a href="/Admin/blogedit?id=<?php echo $blog->id; ?>">Edit</a> | 
<a href="/Admin/blogdelete?id=<?php echo $blog->id; ?>">Delete</a> |

</li>

<?php
}
?>

</ul>

<h2><a href="/Admin/blogcommentlist">Comment Management<a/></h2>