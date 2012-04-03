<?
$includes[title]="Help Categories";
//**S**//
if($action == "edit_cat") {
	$sql=$Db1->query("UPDATE help_cats SET title='".addslashes($new)."' WHERE id='$id'");
}

if($action == "delete_cat") {
	$sql=$Db1->query("DELETE FROM help_cats WHERE id='$id'");
	$sql=$Db1->query("DELETE FROM help_faqs WHERE cat='$id'");
}

if($action == "new_cat") {
	$sql=$Db1->query("INSERT INTO help_cats SET title='".addslashes($new_cat)."'");
}


$sql=$Db1->query("SELECT * FROM help_cats ORDER BY title");
while($cat=$Db1->fetch_array($sql)) {
	$editlist.="
	<tr bgcolor=\"white\">
		<td width=\"100%\">$cat[title] ($cat[faqs])</td>
		<td><a href=\"#\" onclick=\"edit($cat[id], '$cat[title]')\">Edit</a></td>
		<td>".iif($permission==7,"<a href=\"#\" onclick=\"if(confirm('Are you sure?')) location.href='admin.php?view=admin&ac=help_cats&action=delete_cat&id=$cat[id]'\">Delete</a>")."</td>
	</tr>";
}

$includes[content]="
<script>
function edit(id, title) {
	title=prompt('Edit The Category!',title)
	if(title != null) {
		location.href='admin.php?view=admin&ac=help_cats&action=edit_cat&id='+id+'&new='+title;
	}
}
</script>
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"300\" align=\"center\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"3\" border=0 width=\"100%\">
			$editlist
			</table>
		</td>
	</tr>
</table>
<hr>
<form action=\"admin.php?view=admin&ac=help_cats&action=new_cat\" method=\"post\">
<input type=\"text\" name=\"new_cat\">
<input type=\"submit\" value=\"Add Category\">
</form>
";
//**E**//
?>
