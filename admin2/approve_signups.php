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
$includes[title]="Approve Signups";

//**VS**//$setting[ptsu]//**VE**//
//**S**//

/*
0	waiting approval
1	approved by admin
2	waiting approval by advertiser
3	denied by admin
4	denied by advertiser
*/

if($action == "approve") {
	for($x=0; $x<count($index); $x++) {
		$sql=$Db1->query("SELECT * FROM ptsu_log WHERE id='".$index[$x]."'");
		$temp=$Db1->fetch_array($sql);
		if($dec[$x] == 2) {
			$Db1->query("UPDATE ptsu_log SET status='1' WHERE id='".$index[$x]."'");
			$Db1->query("UPDATE user SET balance=balance+".$temp[pamount]." WHERE username='".$temp[username]."'");
			$Db1->query("UPDATE ptsuads SET pending=pending-1 WHERE id='".$temp[ptsu_id]."'");
		}
		if($dec[$x] == 3) {
			$Db1->query("UPDATE ptsu_log SET status='2' WHERE id='".$index[$x]."'");
		}
		if($dec[$x] == 4) {
			$Db1->query("UPDATE ptsu_log SET status='3' WHERE id='".$index[$x]."'");
			$Db1->query("UPDATE ptsuads SET pending=pending-1, credits=credits+1 WHERE id='".$temp[ptsu_id]."'");
		}
	}
}

$sql=$Db1->query("SELECT ptsu_log.*, ptsuads.title FROM ptsu_log, ptsuads WHERE ptsu_log.status='0' and ptsuads.id=ptsu_log.ptsu_id LIMIT 5");
for($x=0; $temp = $Db1->fetch_array($sql); $x++) {
	$list.="
<table cellpadding=0 cellspacing=0>
	<tr>
		<td valign=\"top\">
			<b>Title: </b> $temp[title]<br />
			<b>Username: </b> $temp[username]<br />
		</td>
		<td valign=\"top\">
			<input type=\"hidden\" name=\"index[$x]\" value=\"$temp[id]\">
			<input type=\"radio\" name=\"dec[$x]\" value=\"1\" checked=\"checked\">Pending <br />
			<input type=\"radio\" name=\"dec[$x]\" value=\"2\">Approve <br />
			<input type=\"radio\" name=\"dec[$x]\" value=\"3\">Require Advertiser Approval <br />
			<input type=\"radio\" name=\"dec[$x]\" value=\"4\">Deny <br />
		</td>
	</tr>
</table>
<div align=\"center\">
<div style=\"width: 95%; height: 200px; overflow: auto; border: 1px solid black; background-color: #f8f8f8; text-align: left;\">
<b>Userid: </b> $temp[userid]<br />
<hr>
".nl2br($temp[welcome_email])."
</div>
</div>
<hr>
<br />
<hr>
	";
}

$includes[content]="
<form action=\"admin.php?view=admin&ac=approve_signups&action=approve&".$url_variables."\" method=\"post\">
<input type=\"submit\" value=\"Process Signups!\">

<hr>
$list

<input type=\"submit\" value=\"Process Signups!\">

</form>
";

//**E**//

?>
