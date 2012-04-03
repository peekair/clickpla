<?
$includes[title]="Edit Store Item";

if($action == "edit") {
	$Db1->query("
	UPDATE store_items SET
		title='".addslashes($title)."',
		cash='$cash',
		points='$points',
		qty='$qty',
		email='$email',
		active='$active',
		description='".addslashes($description)."'
		WHERE id='$id'
	");
}

$sql=$Db1->query("SELECT * FROM store_items WHERE id='$id'");
$item = $Db1->fetch_array($sql);

$includes[content]="
".iif($action == "edit","<b style=\"color: darkred;\">Your changes have been saved!</b>")."
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=edit_store_item&action=edit&id=$id&".$url_variables."\" method=\"post\">
	<table width=250>
		<tr>
			<td>Title: </td>
			<td><input type=\"text\" name=\"title\" value=\"".htmlentities(stripslashes($item[title]))."\"></td>
		</tr>
		<tr>
			<td>Cash Price: </td>
			<td><input type=\"text\" name=\"cash\" size=4 value=\"$item[cash]\"> (blank to disable)</td>
		</tr>
		<tr>
			<td>Points Price: </td>
			<td><input type=\"text\" name=\"points\" size=4 value=\"$item[points]\"> (blank to disable)</td>
		</tr>
		<tr>
			<td>Quantity: </td>
			<td><input type=\"text\" name=\"qty\" size=3 value=\"$item[qty]\"></td>
		</tr>
		<tr>
			<td>Email Order To: </td>
			<td><input type=\"text\" name=\"email\" value=\"$item[email]\"></td>
		</tr>
		<tr>
			<td>Active? </td>
			<td><select name=\"active\">
					<option value=\"1\"".iif($item[active]==1,"selected=\"selected\"").">Yes
					<option value=\"0\"".iif($item[active]==0,"selected=\"selected\"").">No
				</select>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=\"center\">Description:<br /><textarea name=\"description\" cols=35 rows=5>".stripslashes($item[description])."</textarea></td>
		</tr>
		<tr>
			<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Edit Item\"></td>
		</tr>
	</table>
</form>
</div>

";

?>
