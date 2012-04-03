<?
//##############################################
//#            AURORAGPT Script Copyright owned by Mike Pratt              #
//#                        ALL RIGHTS RESERVED 2007-2009                        #
//#                                                                                                 #
//#        Any illegal use of this script is strictly prohibited unless          # 
//#        permission is given by the owner of this script.  To sell          # 
//#        this script you must have a resellers license. Your site          #
//#        must also use a unique encrypted license key for your         #
//#        site. Your site must also have site_info module and             #
//#        key.php file must be in the script unedited. Otherwise         #
//#        it will be considered as unlicensed and can be shut down    #
//#        legally by Illusive Web Services. By using AuroraGPT       #
//#        script you agree not to copy infringe any of the coding     #
//#        and or create a clone version is also copy infringement   #
//#        and will be considered just that and legal action will be   #
//#        taken if neccessary.                                                    #
//#########################################//  
$includes[title]="Referral Builder Category Manager";

if($action == "delete") {
	$Db1->query("DELETE FROM dbl_cat WHERE id='$id'");
}

if($action == "add") {
	$Db1->query("INSERT INTO dbl_cat SET
		title='".addslashes($title)."',
		description='".addslashes($description)."'
	");
}

$sql=$Db1->query("SELECT * FROM dbl_cat ORDER BY title");
while($cat = $Db1->fetch_array($sql)) {
	$list.="
		<tr>
			<td width=300>
				<b>$cat[title]</b><br />
				$cat[description]
			</td>
			<td>
				<input type=\"button\" value=\"Delete\" onclick=\"if(confirm('Are you sure you want to delete this?')) location.href='admin.php?view=admin&ac=dlcat&id=$cat[id]&action=delete&".$url_variables."'\">
			</td>
		</tR>
		<tr>
			<td colspan=2 height=1 bgcolor=\"black\"></td>
		</tr>
	";
}


$includes[content]="
<div align=\"center\">
<table>
		<tr>
			<td colspan=2 height=1 bgcolor=\"black\"></td>
		</tr>
	$list
</table>

</div>

<br />

<form action=\"admin.php?view=admin&ac=dlcat&action=add&".$url_variables."\" method=\"post\">
<b>Add New Category</b><br />
Title: <input type=\"text\" name=\"title\"><br />
Description:<br />
<textarea name=\"description\" cols=40 rows=5></textarea><br />
<input type=\"submit\" value=\"Add\">
</form>
";

?>
