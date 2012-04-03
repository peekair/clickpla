<?
$includes[title]="Manage Point Store";
if(($action == "save") && ($working == 1)) {
$settings["point_on"]		= 	"$point_on";
include("admin2/settings/update.php");
updatesettings($settings);
$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=point_store&saved=1&".$url_variables."");
}

if($action == "add") {
	$Db1->query("
	INSERT INTO store_items SET
		title='".addslashes($title)."',
		cash='$cash',
		points='$points',
		qty='$qty',
		email='$email',
		active='$active',
		description='".addslashes($description)."',
		dsub='".time()."'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=point_store&".$url_variables."");
}


$sql=$Db1->query("SELECT * FROM store_items ORDER by active");
if($Db1->num_rows() > 0) {
	while($item=$Db1->fetch_array($sql)) {
		$list.="
			<tr class=\"tableHL3\">
				<td height=5 colspan=2></td>
			</tr>
			<tr class=\"tableHL2\">
				<td  nowrap=\"nowrap\" width=\"100\">
					<small>
						Quantity: $item[qty]<br />
						Active? ".iif($item[active]==1,"Yes","No")."<br />
						 ".iif($item[points]>0,"Point Cost:</b> $item[points]<br />")."
						 ".iif($item[cash]>0,"Cash Cost:</b> $item[cash]<br />")."
						<a href=\"admin.php?view=admin&ac=edit_store_item&id=$item[id]&".$url_variables."\">Edit Item</a><br />
						<a href=\"admin.php?view=admin&ac=delete_store_item&id=$item[id]&".$url_variables."\">Delete Item</a>
					</small>
				</td>
				<td>
					<b>$item[title]</b><br />
					".nl2br($item[description])."<br />
				</td>
			</tr>
		";
	}
}
else {
	$list="<tr class=\"tableHL2\"><td><b>There are no items in the store right now. </b></td></tr>";
}


$includes[content]="

<div align=\"left\">
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=point_store&action=save&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"350\"><b>Activate Members link to Point Store: </b><br><small> Check this box if you would like the members to have a link to the Point Store </td>
		<td><input type=\"checkbox\" name=\"point_on\" value=\"1\"".iif($settings[point_on] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td colspan=2 align=\"left\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
</div>
</form>

<table cellpadding=1 cellspacing=0 class=\"tableBD1\" width=\"100%\">
	<tr>
		<td>
			<table width=\"100%\" cellpadding=0 cellspacing=0>
				$list
				
			<tr class=\"tableHL3\">
				<td colspan=2 height=5></td>
			</tr>
			</table>
		</td>
	</tr>
</table>

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=point_store&action=add&".$url_variables."\" method=\"post\">
	<table width=350>
		<tr>
			<td colspan=2 align=\"center\"><b>New Store Item</b></td>
		</tr>
		<tr>
			<td>Title: </td>
			<td><input type=\"text\" name=\"title\"></td>
		</tr>
		<tr>
			<td>Cash Price: </td>
			<td><input type=\"text\" name=\"cash\" size=4> (blank to disable)</td>
		</tr>
		<tr>
			<td>Points Price: </td>
			<td><input type=\"text\" name=\"points\" size=4> (blank to disable)</td>
		</tr>
		<tr>
			<td>Quantity: </td>
			<td><input type=\"text\" name=\"qty\" size=3></td>
		</tr>
		<tr>
			<td>Email Order To: </td>
			<td><input type=\"text\" name=\"email\" value=\"$settings[admin_email]\"></td>
		</tr>
		<tr>
			<td>Active? </td>
			<td><select name=\"active\">
					<option value=\"1\">Yes
					<option value=\"0\">No
				</select>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=\"center\">Description:<br /><textarea name=\"description\" cols=35 rows=5></textarea></td>
		</tr>
		<tr>
			<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Item\"></td>
		</tr>
	</table>
</form>
</div>
";
?>