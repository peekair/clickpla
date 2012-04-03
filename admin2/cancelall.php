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
$includes[title]="Cancel All Pending Requests";

function cancel($id) {
	global $Db1;
	$sql=$Db1->query("SELECT * FROM requests WHERE id='$id'");
	$request=$Db1->fetch_array($sql);
	$Db1->query("DELETE FROM requests WHERE id='$id'");
	
	$sql=$Db1->query("SELECT * FROM withdraw_options WHERE id='$request[accounttype]'");
	$wo=$Db1->fetch_array($sql);
	
	
	$sql=$Db1->query("INSERT INTO payment_history SET 
			dsub='".time()."',
			username='$request[username]',
			account='".addslashes($request[account])."',
			amount='$request[amount]',
			fee='$request[fee]',
			accounttype='By Admin',
			status='2'
	");
	
	$Db1->query("UPDATE user SET balance=balance+".($request[amount]+$request[fee])." WHERE username='$request[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$request[username]."', log='Request Cancelled By Admin: Gross: ".$request[amount].", Fee: ".$request[fee].", Account: ".$request[account]."', dsub='".time()."'");
}


if($action == "cancel") {
	$sql=$Db1->query("SELECT * FROM requests");
	while($temp=$Db1->fetch_array($sql)) {
		cancel($temp[id]);
	}
}



$includes[content]="
<form action=\"admin.php?view=admin&ac=cancelall&action=cancel&".$url_variables."\" method=\"post\">
	<input type=\"submit\" value=\"Cancel All Requests\">
</form>
";

?>
