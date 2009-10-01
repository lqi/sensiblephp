<h1>Admin - Dict - Dictionary list</h1>

<p><a href="/Admin/dictadd">Add new Dict</a></p>

<ul>

<?php
foreach($this->getValue("dictArray") as $id => $dict) {
?>

<li>
| 
<?php echo $dict->id; ?> | 
<?php echo $dict->term; ?> | 
<?php echo $dict->definition; ?> | 
<a href="/Admin/dictedit?id=<?php echo $dict->id; ?>">Edit</a> | 
<a href="/Admin/dictdelete?id=<?php echo $dict->id; ?>">Delete</a> |

</li>

<?php
}
?>

</ul>
