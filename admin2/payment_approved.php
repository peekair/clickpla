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
$includes[title]="Payment Approver";


if($action == "approvem") {
	$temp=explode("\n", $accounts);
	for($x=0; $x<count($temp); $x++) {
		$account=$temp[$x];
		if($account != "") {
			$Db1->query("DELETE FROM payment_approve WHERE account='$account'");
			$Db1->query("INSERT INTO payment_approve SET account='$account'");
		}
	}
}



if($action == "unapprove_all") {
	$Db1->query("DELETE FROM payment_approve");
}

if($action == "unapprove") {
	$Db1->query("DELETE FROM payment_approve WHERE account='$account'");
}


$sql = $Db1->query("SELECT * FROM payment_approve ORDER BY account");
while($temp=$Db1->fetch_array($sql)) {
	$list.="<option value=\"$temp[account]\">$temp[account]";
	if($export == true) $elist.="$temp[account]\n";
}

$includes[content]="
<small>This tool allows you to only allow approved accounts to purchase items from the site and have instant activation. If \"First Time Verification\" is enabled in the payment settings, any payments made from any accounts not in this list will have to be manually approved.</small>
<br /><br />
<div align=\"center\">


<form action=\"admin.php?view=admin&ac=payment_approved&action=approvem&".$url_variables."\" method=\"post\" onsubmit=\"return confirm('Are you sure you want to approve these account?')\">
<b>Approve Accounts</b><br />
<textarea name=\"accounts\" cols=40 rows=5></textarea><br /><input type=\"submit\" value=\"approve Accounts\"><br />
<small>One per line. Examples: account@domain.com or 2836593</b></small>
</form>


<form action=\"admin.php?view=admin&ac=payment_approved&action=unapprove&".$url_variables."\" method=\"post\" name=\"form2\">
<b>Accounts Currently approved</b><br />
<select name=\"account\" size=5>
	$list
</select>
<br />
<input type=\"submit\" value=\"Unapprove Account\"> <input type=\"button\" value=\"Unapprove All Accounts\" onclick=\"if(confirm('Are you sure you want to unapprove ALL accounts?')) location.href='admin.php?view=admin&ac=payment_approved&action=unapprove_all&".$url_variables."'\"><br />

</form>



<div align=\"right\"><a href=\"admin.php?view=admin&ac=payment_approved&export=true&".$url_variables."\">Export List Of approved Accounts</a></div>

".iif($export == true,"<textarea cols=35 rows=10>$elist</textarea>")."

</div>

";

?>
