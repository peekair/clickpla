<?
# TODO ajax functions to cancel/delete pending requests


include("ajax_php/memberManager/header.php");
global $user, $id, $settings, $url_variables;
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$pid = $_REQUEST['pid'];

if($_REQUEST['cancel'] == 1) {
	$request=$Db1->query_first("SELECT * FROM requests WHERE id='$pid'");
	if($request[username]==$user['username']) {
		$Db1->query("DELETE FROM requests WHERE id='$pid'");
		
		$wo=$Db1->query_first("SELECT * FROM withdraw_options WHERE id='$request[accounttype]'");
		
		$sql=$Db1->query("INSERT INTO payment_history SET 
			dsub='".time()."',
			username='$request[username]',
			account='".addslashes($request[account])."',
			amount='$request[amount]',
			fee='$request[fee]',
			accounttype='$wo[title]',
			status='2'
		");
		$Db1->query("UPDATE user SET balance=balance+".($request[amount]+$request[fee])." WHERE username='{$user['username']}'");
		$Db1->query("INSERT INTO logs SET username='".$request[username]."', log='Request Cancelled By Admin: Gross: ".$request[amount].", Fee: ".$request[fee].", Account: ".$request[account]."', dsub='".time()."'");
		echo "<div class=\"success\">The payment request was successfully cancelled.</div>";
	}
	else {
		echo "<div class=\"error\">There was an unexpected error. Try reloading the user manager.</div>";
	}
}

if($_REQUEST['delete'] == 1) {
	$request=$Db1->query_first("SELECT * FROM requests WHERE id='$pid'");
	if($request[username]==$user['username']) {
		$Db1->query("DELETE FROM requests WHERE id='$pid'");	
		$Db1->query("INSERT INTO logs SET username='".$request[username]."', log='Request Deleted By Admin: Gross: ".$request[amount].", Fee: ".$request[fee].", Account: ".$request[account]."', dsub='".time()."'");
		echo "<div class=\"success\">The payment request was successfully deleted.</div>";
	}
	else {
		echo "<div class=\"error\">There was an unexpected error. Try reloading the user manager.</div>";
	}
}


$sql=$Db1->query("SELECT requests.*, withdraw_options.title FROM requests, withdraw_options WHERE requests.username='$user[username]' and withdraw_options.id=requests.accounttype ORDER BY requests.dsub DESC");
if($Db1->num_rows() != 0) {
	while(($temp=$Db1->fetch_array($sql))) {
		$pendinglist.="
		<tr>
			<td>".date('M d, Y', @mktime(0,0,$temp[dsub],1,1,1970))."</td>
			<td>$temp[title]</td>
			<td>$temp[account]</td>
			<td>$cursym $temp[fee]</td>
			<td>$cursym $temp[amount]</td>
			<td><a href=\"#\" onclick=\"mm.payment_cancel({$temp[id]}); return false;\">Cancel</a></td>
			<td><a href=\"#\" onclick=\"mm.payment_delete({$temp[id]}); return false;\">Delete</a></td>
		</tr>
		";
	}
}
else {
	$pendinglist="
		<tr>
			<td align=\"center\" colspan=5><font color=\"#236381\">No Pending Requests</font></td>
		</tr>
	";
}


$sql=$Db1->query("SELECT * FROM payment_history WHERE username='$user[username]' ORDER BY dsub DESC");
if($Db1->num_rows() != 0) {
	while(($temp=$Db1->fetch_array($sql))) {
		if($temp[status]==0) $status = "Queued for Payment";
		if($temp[status]==1) $status = date('M d, Y', @mktime(0,0,$temp[dsub],1,1,1970));
		if($temp[status]==2) $status = "Cancelled";
		
		$historylist.="
		<tr>
			<td>{$status}</td>
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
			<td align=\"center\" colspan=4><font color=\"#236381\">No Withdraw History</font></td>
		</tr>
	";
}




?>


<h3>Pending Requests</h3>
<table width="100%" class="tableData">
	<tr>
		<th><b>Request Date</b></th>
		<th><b>Method</b></th>
		<th><b>Account</b></th>
		<th><b>Fee</b></th>
		<th><b>Net</b></th>
		<th colspan=2><b>Actions</b></th>
	</tr>
	<?=$pendinglist;?>
</table>


<h3>Withdraw History</h3>

<table width="100%" class="tableData">
	<tr>
		<th><b>Date Paid</b></th>
		<th><b>Method</b></th>
		<th><b>Account</b></th>
		<th><b>Fee</b></th>
		<th><b>Net</b></th>
	</tr>
	<?=$historylist;?>
</table>
<br />
</div>