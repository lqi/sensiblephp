<h1>Blog</h1>

<ul>

<?php
foreach($this->getValue("blogArray") as $id => $blog) {
?>

<li>

<h2><?php echo $blog->title->getValue(); ?></h2>

<h3><?php echo $blog->date->getValue(); ?></h3>

<p><a href="/Blog/blog?id=<?php echo $blog->id->getValue(); ?>">Read this post</a></p>

</li>

<?php
}
?>

</ul>
