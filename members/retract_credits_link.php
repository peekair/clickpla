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
$includes[title]="Retract Link Credits";
//**VS**//$setting[ptc]//**VE**//
//**S**//
$sql=$Db1->query("SELECT * FROM ads WHERE id='$id'");
$thisad=$Db1->fetch_array($sql);

if($action == "retract") {
	if($credits < 1) {
		$error_msg="You must enter at least 1 credit!";
	}
	else if($thisad[username] != $username) {
		$error_msg="You do not have permission to edit this!!";
	}
	else {
		if($credits > $thisad[credits]) {
			$credits=$thisad[credits];
		}
		$sql=$Db1->query("UPDATE ads SET credits=credits-$credits WHERE id='$id'");
		$sql=$Db1->query("UPDATE user SET link_credits=link_credits+".($credits*$settings['class_'.strtolower($thisad['class']).'_credit_ratio'])." WHERE username='$username'");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=myads&adtype=link&".$url_variables."");
	}
}


if(($thisad['class'] != "P") || ($thisad[forbid_retract] != 1)) {
	$includes[content]="
	".iif($error_msg!="","<font color=\"darkred\"><b>$error_msg</b></font>")."
	<br />
<div align=\"center\">
<form action=\"index.php?view=account&ac=retract_credits_link&action=retract&".$url_variables."\" method=\"post\">
<input type=\"hidden\" value=\"$id\" name=\"id\">
<table>
	<tr>
		<td>Title: </td>
		<td>$thisad[title]</td>
	</tr>
	<tr>
		<td>Url: </td>
		<td>$thisad[target]</td>
	</tr>
	<tr>
		<td>Credits: </td>
		<td>$thisad[credits]</td>
	</tr>
	<tr>
		<td colspan=2>Credits To Retract: <input type=\"text\" name=\"credits\" value=\"$thisad[credits]\" size=5></td>
	</tr>
	<tr>
		<td align=\"right\" colspan=2><input type=\"submit\" value=\"Retract\"></td>
	</tr>
</table>
</form>
</div>
";
}
else {
	$includes[content]="You cannot retract the credits from this link!";
}
//**E**//

?>