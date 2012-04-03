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
$includes[title]="Find Missing Referrals";

$sql=$Db1->query("SELECT * FROM user");
while($temp=$Db1->fetch_array($sql)) {
	if($temp[refered] != "") {
		$sql2=$Db1->query("SELECT userid FROM user WHERE username='".addslashes($temp[refered])."'");
		if($Db1->num_rows() == 0) {
			if($action == "clean") {
				$Db1->query("UPDATE user SET refered='' WHERE username='".addslashes($temp[username])."'");
			}
			$list.="
				<tr>
					<td>$temp[username]</tD>
					<td>$temp[refered]</tD>
				</tr>
			";
		}
	}
}

if($action == "clean") {
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=cleanrefs&".$url_variables."");
}

$includes[content]="
<a href=\"admin.php?view=admin&ac=cleanrefs&action=clean&".$url_variables."\">Clean All</a><br /><br />
<table>
	<tr>
		<td width=100><b>Username</b></td>
		<td><b>False Referrer</b></td>
	</tr>
	$list
</table>

";


?>
