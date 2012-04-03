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
$includes[title]="Add Credits To Banner Ad";
//**S**//
$sql=$Db1->query("SELECT * FROM banners WHERE id='$id'");
$thisad=$Db1->fetch_array($sql);

if(!is_numeric($c2add)) {
	$c2add=0;
}

$c2add=floor($c2add);


if($action == "add") {
	if($c2add < 1) {
		$error_msg="You must enter a valid number of credits!";
	}
	else if(($c2add) > $thismemberinfo[banner_credits]) {
		$error_msg="You do not have sufficient credits on your account!";
	}
	else {
		$sql=$Db1->query("UPDATE user SET banner_credits=banner_credits-".($c2add)." WHERE username='$username'");
		$sql=$Db1->query("UPDATE banners SET credits=credits+$c2add WHERE id='$id'");
		header("Location: index.php?view=account&ac=myads&adtype=banner&".$url_variables."");
	}
}


if($step == 0) {
	$includes[content]="
	<br />
<div align=\"center\">
<form action=\"index.php?view=account&ac=add_credits_banner&step=2&".$url_variables."\" method=\"post\">
<input type=\"hidden\" value=\"$id\" name=\"id\">
<table>
	<tr>
		<td>
			How do you wish to fund the credits?<br />
			<input type=\"radio\" name=\"addoption\" value=\"account\" id=\"account\"".iif($thismemberinfo[banner_credits]>=1," Checked=\"checked\"")."> <label for=\"account\">Account Banner Credits ($thismemberinfo[banner_credits])</label><br />
			<input type=\"radio\" name=\"addoption\" value=\"purchase\" id=\"purchase\"".iif($thismemberinfo[banner_credits]<1," Checked=\"checked\"")."> <label for=\"purchase\">Purchase Credits</label>
		</td>
	</tr>
	<tr>
		<td align=\"right\"><input type=\"submit\" value=\"Next =>\"></td>
	</tr>
</table>
</form>
</div>
";
}
else if($step == 2) {
	if($addoption == "purchase") {
		while(!isset($pid)) { //make sure a unique order_id gets generated!
			$temppid=rand_string(10);
			$Db1->query("SELECT order_id FROM orders WHERE order_id='$temppid'");
			if($Db1->num_rows() == 0) {
				$pid = $temppid;
			}
		}
		$sql=$Db1->query("INSERT INTO orders SET
			order_id='$pid',
			username='$username',
			ad_type='banner',
			ad_id='$id',
			dsub='".time()."'
		");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=buywizard&step=3&pid=$pid&".$url_variables."");
	}
	else if($addoption == "account") {
		$includes[content]="
<div align=\"center\">
".iif($error_msg,"<script>alert('$error_msg');</script>")."
<form name=\"form\" action=\"index.php?view=account&ac=add_credits_banner&id=$id&step=2&addoption=account&action=add&".$url_variables."\" method=\"post\" onsubmit=\"submitonce(this)\">
<table>
	<tr>
		<td width=120>Banner: </td>
		<td>$thisad[title]</td>
	</tr>
	<tr>
		<td>Credits To Add: </td>
		<td><input type=\"text\" name=\"c2add\" value=\"0\" size=\"10\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Credits\"></td>
	</tr>
</table>
<small>
You Have $thismemberinfo[banner_credits] Credits On Your Account<br />

</small>
</div>
";
		
	}
}
//**E**//

?>