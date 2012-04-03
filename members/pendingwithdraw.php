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
$includes[title]="Pending Withdraw Requests";
//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if($action == "cancel") {
	$sql=$Db1->query("SELECT * FROM requests WHERE id='$id'");
	$request=$Db1->fetch_array($sql);
	if($request[username]==$username) {
		$Db1->query("DELETE FROM requests WHERE id='$id'");
		
		$sql=$Db1->query("SELECT * FROM withdraw_options WHERE id='$request[accounttype]'");
		$wo=$Db1->fetch_array($sql);
		
		$sql=$Db1->query("INSERT INTO payment_history SET 
			rdsub='$request[dsub]',
			dsub='".time()."',
			username='$request[username]',
			account='".addslashes($request[account])."',
			amount='$request[amount]',
			fee='$request[fee]',
			accounttype='By User',
			status='2'
		");
		$sql=$Db1->query("INSERT INTO logs SET username='".$request[username]."', log='Request Cancelled By User: Gross: ".$request[amount].", Fee: ".$request[fee].", Account: ".$request[account]."', dsub='".time()."'");
		$Db1->query("UPDATE user SET balance=balance+".($request[amount]+$request[fee])." WHERE username='$username'");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=pendingwithdraw&".$url_variables."");
	}
}

$sql=$Db1->query("SELECT requests.*, withdraw_options.title FROM requests, withdraw_options WHERE requests.username='$username' and withdraw_options.id=requests.accounttype ORDER BY requests.dsub DESC");
if($Db1->num_rows() != 0) {
	while($temp=$Db1->fetch_array($sql)) {
		$pendinglist.="
		<tr>
			<td>".date('M d, Y', @mktime(0,0,$temp[dsub],1,1,1970))."</td>
			<td>$temp[title]</td>
			<td>$temp[account]</td>
			<td>$cursym $temp[fee]</td>
			<td>$cursym $temp[amount]</td>
			<td><a href=\"index.php?view=account&ac=pendingwithdraw&action=cancel&id=$temp[id]&".$url_variables."\">Click To Cancel</a></td>
		</tr>
		";
	}
}
else {
	$pendinglist="
		<tr>
			<td align=\"center\" colspan=5><font color=\"#236381\">You Do Not Have Any Withdraw Requests Pending!</font></td>
		</tr>
	";
}



$sql=$Db1->query("SELECT * FROM payment_history WHERE username='$username' ORDER BY dsub DESC");
if($Db1->num_rows() != 0) {
	while($temp=$Db1->fetch_array($sql)) {
		$historylist.="
		<tr>
			<td>".date('M d, Y', @mktime(0,0,$temp[rdsub],1,1,1970))."</td>
			<td>
				".iif($temp[status]==0,"Queued For Payment")."
				".iif($temp[status]==1,"".date('M d, Y', @mktime(0,0,$temp[dsub],1,1,1970)))."
				".iif($temp[status]==2,"Cancelled")."
			
			</td>
			<td>$temp[accounttype]</td>
			<td>$temp[account]</td>
			<td>$cursym $temp[fee]</td>
			<td>$cursym $temp[amount]</td>
		</tr>
		";
	}
}
else {
	$historylist="
		<tr>
			<td align=\"center\" colspan=4><font color=\"#236381\">You Have Not Had Any Withdraws Completed Yet!</font></td>
		</tr>
	";
}
//**E**//

$includes[content]="
".iif($msg!="","<font color=\"darkblue\"><b>$msg</b></a><br /><br />")."
<table width=\"100%\">
	<tr>
		<td><b>Request Date</b></td>
		<td><b>Method</b></td>
		<td><b>Account</b></td>
		<td><b>Fee</b></td>
		<td><b>Net</b></td>
		<td><b></b></td>
	</tr>
	$pendinglist
</table>

<br /><br />
<div align=\"center\"><b>Withdraw History</b></div>

<table width=\"100%\">
	<tr>
		<td><b>Request Date</b></td>
		<td><b>Date Paid</b></td>
		<td><b>Method</b></td>
		<td><b>Account</b></td>
		<td><b>Fee</b></td>
		<td><b>Net</b></td>
	</tr>
	$historylist
</table>


";
?>
