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
//**VS**//$setting[se]//**VE**//
$includes[title]="Activate Surf Sites";

if($action == "update") {
	for($x=0; $x<count($ssite); $x++) {
		if($ssite[$x] == 2) {
			$Db1->query("DELETE FROM surf_sites WHERE id='$siteid[$x]'");
		}
		else {
			$Db1->query("UPDATE surf_sites SET active='$ssite[$x]' WHERE id='$siteid[$x]'");
		}
	}
}

$sql=$Db1->query("SELECT * FROM surf_sites WHERE active='0'");
for($x=0; $site=$Db1->fetch_array($sql); $x++) {
	$list.="
		<tr onclick=\"this.bgColor='lightyellow'\">
			<td><a href=\"frame.php?id=$site[id]&type=surf_sites\" target=\"_blank\"><b>$site[title]</b><br />$site[target]</a></td>
			<td>
				<input type=\"hidden\" name=\"siteid[$x]\" value=\"$site[id]\">
				<input type=\"radio\" name=\"ssite[$x]\" value=\"1\">Activate<br />
				<input type=\"radio\" name=\"ssite[$x]\" value=\"0\" checked=\"checked\">Not Active<br />
				<input type=\"radio\" name=\"ssite[$x]\" value=\"2\">Delete
			</td>
		</tr>
		<tr>
			<td colspan=2><hr></td>
		</tr>
	";
}

$includes[content]="

<form action=\"admin.php?view=admin&ac=actsurf&action=update&".$url_variables."\" method=\"post\">
<table width=\"100%\">
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Update\"></td>
	</tr>
	<tr>
		<td colspan=2><hr></td>
	</tr>
	$list
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Update\"></td>
	</tr>
</table>
</form>
";

?>
