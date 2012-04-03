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
$includes[title]="Manage Code Rotator";

if($action == "add") {
	$Db1->query("INSERT INTO code_rotator SET
		title='".addslashes($title)."',
		code='".addslashes($code)."',
		`limit`='$limit',
		weight='$weight'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=code_rotator&".$url_variables."");
}

if($action == "update") {
	for($x=0; $x<count($weight); $x++) {
		if($delete[$x] == 1) {
			$Db1->query("DELETE FROM code_rotator WHERE id='".$codeid[$x]."'");
		}
		else {
			$Db1->query("UPDATE code_rotator SET 
				weight='".$weight[$x]."', 
				`limit`='".$limit[$x]."', 
				code='".addslashes($code[$x])."', 
				title='".addslashes($title[$x])."' WHERE id='".$codeid[$x]."'");
		}
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=code_rotator&".$url_variables."");
}

$sql=$Db1->query("SELECT * FROM code_rotator ORDER BY dsub");
for($x=0; $code = $Db1->fetch_array($sql); $x++) {
	$list.="
	<tr>
		<td colspan=4><hr></td>
	</tr>
	<tr>
		<td><input type=\"text\" name=\"title[$x]\" size=45 value=\"".htmlentities(stripslashes($code[title]))."\"></b><br />Delete: <input type=\"checkbox\" name=\"delete[$x]\" value=\"1\"> <br /><textarea cols=30 rows=3 name=\"code[$x]\">".stripslashes($code[code])."</textarea></td>
		<td align=\"center\">$code[tcount]</td>
		<td align=\"center\">
			<input type=\"hidden\" name=\"codeid[$x]\" value=\"$code[id]\">
			<input type=\"text\" name=\"limit[$x]\" size=3 value=\"$code[limit]\"></td>
		<td align=\"center\">
			<input type=\"text\" name=\"weight[$x]\" size=3 value=\"$code[weight]\"></td>
		<td>
	</tr>
	";
}

$includes[content]="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=code_rotator&action=update&".$url_variables."\" method=\"post\">
<table cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=4 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	<tr>
		<td align=\"center\"><b></b></td>
		<td align=\"center\" width=\"100\"><b>Hits</b></td>
		<td align=\"center\" width=\"70\"><b>Limit</b></td>
		<td align=\"center\" width=\"70\"><b>Weight</b></td>
	</tr>
	$list
	
	<tr>
		<td colspan=4><hr></td>
	</tr>
	<tr>
		<td colspan=4 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>

</form>
<br /><br />

<form action=\"admin.php?view=admin&ac=code_rotator&action=add&".$url_variables."\" method=\"post\">
<b>Add New Code</b>
	<Table>
		<tr>
			<td>Title: </tD>
			<td><input type=\"text\" name=\"title\"></tD>
		</tr>
		<tr>
			<td>Hit Limit: </tD>
			<td><input type=\"text\" name=\"limit\" size=5 value=\"0\"></tD>
		</tr>
		<tr>
			<td>Weight: </tD>
			<td><input type=\"text\" name=\"weight\" size=3 value=\"1\"></tD>
		</tr>
		<tr>
			<td colspan=2>Code:<br /><textarea name=\"code\" cols=30 rows=3></textarea></tD>
		</tr>
		<tr>
			<td colspan=2><input type=\"submit\" value=\"Add Code\"></tD>
		</tr>
	</table>
</form>
</div>
";

?>
