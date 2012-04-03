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
$includes[title]="Payment Blocker";


if($action == "blockm") {
	$temp=explode("\n", $accounts);
	for($x=0; $x<count($temp); $x++) {
		$account=$temp[$x];
		if($account != "") {
			$Db1->query("DELETE FROM payment_block WHERE account='$account'");
			$Db1->query("INSERT INTO payment_block SET account='$account'");
		}
	}
}



if($action == "unblock_all") {
	$Db1->query("DELETE FROM payment_block");
}

if($action == "unblock") {
	$Db1->query("DELETE FROM payment_block WHERE account='$account'");
}


$sql = $Db1->query("SELECT * FROM payment_block ORDER BY account");
while($temp=$Db1->fetch_array($sql)) {
	$list.="<option value=\"$temp[account]\">$temp[account]";
	if($export == true) $elist.="$temp[account]\n";
}

$includes[content]="
<small>This tool allows you to block payments from certain accounts from going through. This can be useful if someone keeps trying to use a fraudulent paypal or stormpay account to send funds.</small>
<br /><br />
<div align=\"center\">


<form action=\"admin.php?view=admin&ac=payment_blocker&action=blockm&".$url_variables."\" method=\"post\" onsubmit=\"return confirm('Are you sure you want to block these account?')\">
<b>Block Account</b><br />
<textarea name=\"accounts\" cols=20 rows=5></textarea><br /><input type=\"submit\" value=\"Block Accounts\"><br />
<small>One per line. Examples: account@domain.com or 2836593</b></small>
</form>


<form action=\"admin.php?view=admin&ac=payment_blocker&action=unblock&".$url_variables."\" method=\"post\" name=\"form2\">
<b>Accounts Currently Blocked</b><br />
<select name=\"account\" size=5>
	$list
</select>
<br />
<input type=\"submit\" value=\"Unblock Account\"> <input type=\"button\" value=\"Unblock All Accounts\" onclick=\"if(confirm('Are you sure you want to unblock ALL accounts?')) location.href='admin.php?view=admin&ac=payment_blocker&action=unblock_all&".$url_variables."'\"><br />

</form>



<div align=\"right\"><a href=\"admin.php?view=admin&ac=payment_blocker&export=true&".$url_variables."\">Export List Of Blocked Accounts</a></div>

".iif($export == true,"<textarea cols=35 rows=10>$elist</textarea>")."

</div>

";

?>
