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
$includes[title]="Pending Orders";

function approve_order($order) {
	global $Db1;
	$today_date=date("d/m/y");
	$sql=$Db1->query("UPDATE stats SET income=income+".$order['cost']." WHERE date='$today_date'");
	if($settings[tickets_buy] > 0) {
		$Db1->query("UPDATE user SET tickets=tickets+$settings[tickets_buy] WHERE username='$order[username]'");
	}
	$sql=$Db1->query("SELECT type FROM user WHERE username='$order[username]'");
	$userinfo=$Db1->fetch_array($sql);
	$sql=$Db1->query("SELECT refered FROM user WHERE username='$order[username]'");
	$referedinfo=$Db1->fetch_array($sql);
	if((isset($referedinfo[refered])) && ($referedinfo[refered] != $order[username])) {
		$sql=$Db1->query("SELECT type, membership FROM user WHERE username='$referedinfo[refered]'");
		$referrerinfo=$Db1->fetch_array($sql);
		if($referrerinfo[type] == 1) {
			$sql=$Db1->query("SELECT * FROM memberships WHERE id='".$referrerinfo[membership]."'");
			$membershipinfo=$Db1->fetch_array($sql);
			$refearnamount=$membershipinfo[purchase_bonus]*$order[cost]/100;
			$sql=$Db1->query("UPDATE user SET balance=balance+$refearnamount, referral_earns=referral_earns+$refearnamount WHERE username='$referedinfo[refered]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$referedinfo[refered]."', order_id='".$order[order_id]."', log='Received $$refearnamount Bonus For Referral Purchase', dsub='".time()."'");
		}
	}
	doswitch($order);
}

if($action == "process") {
	$haultswitch=true;
	include("wizards/pfunctions.php");
	for($x=0; $x<count($index); $x++) {
		$id=$index[$x];
		$sql=$Db1->query("SELECT * FROM ledger WHERE id='$id'");
		$ledger=$Db1->fetch_array($sql);
		if($appr[$x] == 1) {
			$sql=$Db1->query("UPDATE ledger SET status='1' WHERE id='$id'");
			$sql=$Db1->query("SELECT * FROM orders WHERE order_id='$ledger[payment_id]'");
			if($Db1->num_rows() > 0) {
				$order=$Db1->fetch_array($sql);
				echo "<!-- Approving Order $id -->\n";
				approve_order($order);
				$sql=$Db1->query("INSERT INTO payment_approve SET account='$ledger[account]'");
			}
			else {
				echo "<!-- No order found! $id : $ledger[payment_id] -->";
			}
		}
		if($appr[$x] == 2) {
			$sql=$Db1->query("UPDATE ledger SET status='2' WHERE id='$id'");
		}
	}
}

$sql=$Db1->query("SELECT * FROM ledger WHERE status='0' ORDER BY email_verify DESC");
$pending_orders=$Db1->num_rows();
for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
	$sql2=$Db1->query("SELECT COUNT(id) AS total FROM ledger WHERE username='$temp[username]' and status='1'");
	$temp2=$Db1->fetch_array($sql2);
	$orders_appr=$temp2[total];
	$sql3=$Db1->query("SELECT COUNT(id) AS total FROM ledger WHERE username='$temp[username]' and status='2'");
	$temp3=$Db1->fetch_array($sql3);
	$orders_denied=$temp3[total];
	$sql4=$Db1->query("SELECT name, email, joined FROM user WHERE username='$temp[username]'");
	$user=$Db1->fetch_array($sql4);
	
	
	$orderlist.="
		<input type=\"hidden\" name=\"index[$x]\" value=\"$temp[id]\">
		<tr>
			<td><a href=\"admin.php?view=admin&ac=edit_user&uname=$temp[username]&".$url_variables."\">$temp[username]</a> (".floor((time()-$user[joined])/60/60/24)." Days)</td>
			<td>$temp[proc]</td>
			<td>$user[email]</td>
			<td>$temp[account]</td>
			<td>".iif($temp[email_verify] == 1,"Yes","<font color=\"red\">No</font>")."</td>
			<td>$user[name]</td>
			<td>$temp[name]</td>
			<td>$temp[product]</td>
			<td>\$$temp[cost]</td>
			<td>$orders_appr</td>
			<td>".iif($orders_denied>0,"<font color=\"red\">")."$orders_denied</font></td>
			<td style=\"background-color: lightgreen;\" align=\"center\" width=26><input type=\"radio\" name=\"appr[$x]\" value=\"1\"></td>
			<td align=\"center\" width=26><input type=\"radio\" name=\"appr[$x]\" value=\"0\" checked=\"checked\"></td>
			<td style=\"background-color: pink;\" align=\"center\" width=26><input type=\"radio\" name=\"appr[$x]\" value=\"2\"></td>
		</tr>
	";
}

$includes[content]="
<form action=\"admin.php?view=admin&ac=pending_orders&action=process&".$url_variables."\" method=\"post\">

<table class=\"tableData\">
	<tr>
		<th><b>Username</b></th>
		<th><b>Processor</b></th>
		<th><b>Member's Email</b></th>
		<th><b>Payee Account</b></th>
		<th><b>Verified</b></th>
		<th><b>Member's Name</b></th>
		<th><b>Payee Name</b></th>
		<th><b>Product</b></th>
		<th><b>Cost</b></th>
		<th><b>Approved</b></th>
		<th><b>Denied</b></th>
		<th width=26></th>
		<th width=26></th>
		<th width=26></th>
	</tr>
	$orderlist
</table>

<div align=\"right\"><input type=\"submit\" value=\"Approve\"></div>
</form>

<br /><br />
<b>Help</b><br />
<small>
<font color=\"darkblue\">Username:</font> The member's username<br />
<font color=\"darkblue\">Member's Email:</font> The email address used to signup here<br />
<font color=\"darkblue\">Payee Account:</font> The account ID/email being paid from<br />
<font color=\"darkblue\">Verified:</font> If the member clicked the verify link sent to their email<br />
<font color=\"darkblue\">Member's Name:</font> The name supplied during registration here<br />
<font color=\"darkblue\">Payee Name:</font> The name on the account being paid from<br />
<font color=\"darkblue\">Product:</font> Product being purchased<br />
<font color=\"darkblue\">Cost:</font> Cost of product<br />
<font color=\"darkblue\">Approved:</font> How many approved purchases has this member made<br />
<font color=\"darkblue\">Denied:</font> How many denied purchases has this member made
</small>

";


?>
