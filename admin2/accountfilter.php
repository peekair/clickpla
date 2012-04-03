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

$includes[title]="Payout Account Filter";
//**S**//
$msg="";
function check_user($user, $list) {
	$count=0;
	for($x=0; $x<count($list); $x++) {
		if($list[$x] == $user) {
			$count++;
		}
	}
	return $count;
}

function get_user_list($account) {
	global $Db1;
	echo "."; flush();
	$x=0;
	$sql=$Db1->query("SELECT * FROM payment_history WHERE account='$account' and ignore_filter='0'");
	while($temp=$Db1->fetch_array($sql)) {
		if(check_user($temp[username], $user) == 0) {
			$user[$x]=$temp[username];
			$x++;
		}
	}
	$sql=$Db1->query("SELECT * FROM requests WHERE account='$account'");
	while($temp=$Db1->fetch_array($sql)) {
		if(check_user($temp[username], $user) == 0) {
			$user[$x]=$temp[username];
			$x++;
		}
	}
	return $user;
}

function get_account_list($users) {
	echo "."; flush();
	for($x=0; $x<count($users); $x++) {
		$return.="-".$users[$x]."\n";
	}
	return $return;
}

function suspend_account($username, $users) {
	global $Db1;
	$sql=$Db1->query("SELECT notes, suspended FROM user WHERE username='$username'");
	$user=$Db1->fetch_array($sql);
	if($user[suspended] == 0) {
		$Db1->query("
		UPDATE user SET 
			suspended='1',
			notes='".addslashes(stripslashes(stripslashes($user[notes])))."\n\nAutomated Suspension. Multiple Accounts:\n".get_account_list($users)."'
			WHERE username='$username'
		");
	}
}

function cancel_requests($username) {
	global $Db1;
	$sql=$Db1->query("SELECT * FROM requests WHERE username='$username'");
	while($request=$Db1->fetch_array($sql)) {
		$Db1->query("DELETE FROM requests WHERE id='$request[id]'");
		$sql=$Db1->query("INSERT INTO payment_history SET 
			dsub='".time()."',
			username='$request[username]',
			account='".addslashes($request[account])."',
			amount='$request[amount]',
			fee='$request[fee]',
			accounttype='$wo[title]',
			status='2'
		");
		$Db1->query("UPDATE user SET balance=balance+".($request[amount]+$request[fee])." WHERE username='$request[username]'");
		$sql=$Db1->query("INSERT INTO logs SET username='".$request[username]."', log='Request Cancelled By Admin: Gross: ".$request[amount].", Fee: ".$request[fee].", Account: ".$request[account]."', dsub='".time()."'");
	}
}

function suspend_accounts($account) {
	global $Db1, $msg;
	$users = get_user_list($account);
	for($x=0; $x<count($users); $x++) {
		echo "."; flush();
		suspend_account($users[$x], $users);
		$msg .=  "Suspended User: ".$users[$x]."<br />";
		echo "."; flush();
		cancel_requests($users[$x]);
		$msg .=  "Cancelled Pending Payments For: ".$users[$x]."<br />";
		echo "."; flush();
	}
}

if($action == "suspend") {
	for($x=0; $x<count($account_index); $x++) {
		if($account_check[$x] == 1) {
			$msg .= "Running Account: ".$account_index[$x]."<br /> ";
			suspend_accounts($account_index[$x]);
		}
	}
}

if($tolorance == "") {
	$tolorance=2;
}

function find_ip($ips, $ip) {
	$return=0;
	foreach ($ips as $thisip) {
    	if($thisip == $ip) {
			$return=1;
		}
	}
	return $return;
}


	$includes[content]="
	$msg
<form action=\"admin.php?view=admin&ac=accountfilter&action=filter&".$url_variables."\" method=\"post\">
User Tolorance: <input type=\"text\" name=\"tolorance\" value=\"$tolorance\" size=3> <br />
<input type=\"checkbox\" name=\"history\" value=\"1\"> Search Paid Requests?<br />
<input type=\"checkbox\" name=\"pending\" value=\"1\" checked=\"checked\"> Search Pending Requests?<br />
<input type=\"submit\" value=\"Filter Accounts\">
</form>
	";


if($action == "filter") {

if($history == 1) {
$sql=$Db1->query("SELECT * FROM payment_history");
while($temp=$Db1->fetch_array($sql)) {
	if(!isset($tracker[$temp[account]])) {
		$tracker[$temp[account]]=array();
	}
	if(!isset($tracker[$temp[account]]['users'])) {
		$tracker[$temp[account]]['users']=array();
	}
	if($tracker[$temp[account]]['accounts']=="") {
		$tracker[$temp[account]]['accounts']=0;
		$tracker[$temp[account]]['title']=$temp[account];
	}
	$tracker[$temp[account]]['users'][$temp[username]]=1;
	$tracker[$temp[account]]['accounts']+=1;
}
}

if($pending == 1) {
$sql=$Db1->query("SELECT * FROM requests");
while($temp=$Db1->fetch_array($sql)) {
	if(!isset($tracker[$temp[account]])) {
		$tracker[$temp[account]]=array();
	}
	if(!isset($tracker[$temp[account]]['users'])) {
		$tracker[$temp[account]]['users']=array();
	}
	if($tracker[$temp[account]]['accounts']=="") {
		$tracker[$temp[account]]['accounts']=0;
		$tracker[$temp[account]]['title']=$temp[account];
	}
	$tracker[$temp[account]]['users'][$temp[username]]=1;
	$tracker[$temp[account]]['accounts']+=1;
	$tracker[$temp[account]]['new']+=1;
}
}

//					<td><a href=\"admin.php?view=admin&ac=runquery&action=run&query=UPDATE user SET balance='0' WHERE account='". $temp1['title'] ."'&".$url_variables."\">Clear Earnings</a></td>

$x=0;
if(count($tracker) != 0) {
	foreach ($tracker as $temp1){
		if(count($temp1['users']) >= $tolorance) {
			$show_count++;
			$show_accounts+=count($temp1['users']);
			$trackerlist.="
				<tr".iif($temp1['new']>=1," bgcolor='lightyellow'").">
					<td>
						<input type=\"hidden\" name=\"account_index[$x]\" value=\"".$temp1['title']."\">
						<input type=\"checkbox\" name=\"account_check[$x]\" value=\"1\" ".iif($temp1['new']>=1,"checked=\"checked\"")."></td>
					<td><a href=\"admin.php?view=admin&ac=account_requests&account=". $temp1['title'] ."&".$url_variables."\">". $temp1['title'] ."</a></td>
					<td align=\"center\">". $temp1['accounts'] ."</td>
					<td align=\"center\">". count($temp1['users']) ."</td>
					<td align=\"center\">". $temp1['new'] ."</td>
				</tr>";
			$x++;
		}
	}

	$includes[content]="
".$show_count." possible cheaters found with $show_accounts accounts!
<script>
function selectAll(formObj, isInverse) 
{
   for (var i=0;i < formObj.length;i++) 
   {
      fldObj = formObj.elements[i];
      if (fldObj.type == 'checkbox')
      { 
         if(isInverse)
            fldObj.checked = (fldObj.checked) ? false : true;
         else fldObj.checked = true; 
       }
   }
}
</script>

<form action=\"admin.php?view=admin&ac=accountfilter&action=suspend&".$url_variables."\" method=\"post\">
<input type=\"radio\" name=\"selectall\"  onclick=\"selectAll(this.form,0);\">Select All

<input type=\"radio\" name=\"selectall\"  onclick=\"selectAll(this.form,1);\">Inverse All

<table width=\"500\">
	<tr>
		<td></td>
		<td><b>Account</td>
		<td align=\"center\"><b>Payments</td>
		<td align=\"center\"><b>Members</td>
		<td align=\"center\"><b>Pending</td>
	</tr>
	$trackerlist
</table>

<input type=\"submit\" value=\"Suspend Selected Accounts\">
</form>
";
}
}


//**E**//
?>
