<h1>Admin - Dict - Dictionary list</h1>

<p><a href="/Admin/dictadd">Add new Dict</a></p>

<ul>

<?php
foreach($this->getValue("dictArray") as $id => $dict) {
?>

<li>
| 
<?php echo $dict->id->getValue(); ?> | 
<?php echo $dict->term->getValue(); ?> | 
<?php echo $dict->definition->getValue(); ?> | 
<a href="/Admin/dictedit?id=<?php echo $dict->id->getValue(); ?>">Edit</a> | 
<a href="/Admin/dictdelete?id=<?php echo $dict->id->getValue(); ?>">Delete</a> |

</li>

<?php
}
?>

</ul>
