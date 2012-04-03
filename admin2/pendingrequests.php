<HEAD>

<SCRIPT LANGUAGE="JavaScript">
<!-- Idea by:  Nic Wolfe -->
<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=270,height=425,left = 670,top = 237.5');");
}
// End -->
</script>
</HEAD>

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
$includes[title]="Pending Requests";

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
if(($step == "") && ($search == 1)) {
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=pendingrequests&search=1&search_str=$search_str&search_table=$search_table&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables);
	exit;
}

if($search == 1) {
	$search_var="&search=1&step=2&search_table=$search_table&search_str=$search_str&search_by=$search_by";
}

function cancelRequest($id) {
	global $Db1;
	$sql=$Db1->query("SELECT * FROM requests WHERE id='$id'");
	$request=$Db1->fetch_array($sql);
		$Db1->query("DELETE FROM requests WHERE id='$request[id]'");
		$sql=$Db1->query("INSERT INTO payment_history SET 
			rdsub='$request[dsub]',
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

if($action == "Cancel") {
	foreach($multiSelect as $k => $v) {
		cancelRequest($k);
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=pendingrequests&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."");
	exit;
}

function markPaid($id) {
	global $Db1;
	$sql=$Db1->query("SELECT * FROM requests WHERE id='$id'");
	$request=$Db1->fetch_array($sql);

		$sql=$Db1->query("SELECT * FROM withdraw_options WHERE id='$request[accounttype]'");
		$wo=$Db1->fetch_array($sql);

		$Db1->query("DELETE FROM requests WHERE id='$request[id]'");
		$sql=$Db1->query("INSERT INTO payment_history SET 
			rdsub='$request[dsub]',
			dsub='".time()."',
			username='$request[username]',
			account='".addslashes($request[account])."',
			amount='$request[amount]',
			fee='$request[fee]',
			accounttype='$wo[title]',
			status='1'
		");
}

if($action == "Mark Paid") {
	foreach($multiSelect as $k => $v) {
		markPaid($k);
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=pendingrequests&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."");
	exit;
}

if($search == 1) {
	if(
		($search_by == "last_ip") ||
		($search_by == "password")||
		($search_by == "country")
	) {
		$sql=$Db1->query("SELECT * FROM user WHERE $search_by='$search_str'");
		while($temp=$Db1->fetch_array($sql)) {
			$conditions.=" requests.username='$temp[username]' or ";
		}
		$conditions.=" username=''";
	}
	else {
		$search_str2=explode(" ", $search_str);
		for($x=0; $x<count($search_str2); $x++) {
			$conditions.=" $search_by LIKE '%$search_str2[$x]%' ";
			if($x < (count($search_str2)-1)) {
				$conditions .= " AND ";
			}
		}
	}
}


$sql=$Db1->query("SELECT COUNT(requests.id) AS total  FROM requests ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+50;
if($start+50 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="ASC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="requests.username";

if($orderby == "requests.dsub") {$ordernum=6;}
if($orderby == "requests.username") {$ordernum=1;}
if($orderby == "withdraw_options.title") {$ordernum=2;}
if($orderby == "requests.account") {$ordernum=3;}
if($orderby == "requests.fee") {$ordernum=4;}
if($orderby == "requests.amount") {$ordernum=5;}
if($orderby == "user.country") {$ordernum=7;}
if($orderby == "user.last_ip") {$ordernum=8;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";


$sql=$Db1->query("SELECT requests.*, withdraw_options.title FROM requests, withdraw_options WHERE ".iif($conditions,"($conditions) and ")." withdraw_options.id=requests.accounttype ORDER BY $orderby $type LIMIT $start, 50");
$total_requests=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_request=$Db1->fetch_array($sql); $x++) {
		$sql2=$Db1->query("SELECT userid, last_ip, type, country FROM user WHERE username='$this_request[username]'");
		$this_request_user=$Db1->fetch_array($sql2);
		$requestslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
					<td style=\"width: 10px\">
						<input type=\"checkbox\" name=\"multiSelect[".$this_request[id]."]\" value=\"1\" checked=\"checked\">
					</td>
					<td NOWRAP=\"NOWRAP\">".date('M d', mktime(0,0,$this_request[dsub],1,1,1970))."</td>
					<td NOWRAP=\"NOWRAP\"><a href=\"admin.php?view=admin&ac=requests&user=".$this_request[username]."&".$url_variables."\">$this_request[username]</a>
							<a href=\"admin.php?view=admin&ac=edit_user&id=".$this_request_user[userid]."&direct=members&".$url_variables."\">*</a>
					</td>
					<td NOWRAP=\"NOWRAP\">$this_request[title]</td>
					<td NOWRAP=\"NOWRAP\"><a href=\"https://www.paypal.com/us/verified/pal=".$this_request[account]."\" target=\"_blank\">$this_request[account]</a></td>
					<td NOWRAP=\"NOWRAP\">$cursym $this_request[fee]</td>
					<td NOWRAP=\"NOWRAP\">$cursym $this_request[amount]</td>
					<td NOWRAP=\"NOWRAP\">".iif($this_request_user[type]==0,"No","YES")."&nbsp;</td>
					<td NOWRAP=\"NOWRAP\">$this_request_user[country]</td>
					<td NOWRAP=\"NOWRAP\">$this_request_user[last_ip]</td>
                                        <td NOWRAP=\"NOWRAP\"><form><input type=button value=\"IP Checker\" onClick=\"javascript:popUp('/admin2/ipchecker.php')\"></form></td>

					<td><a href=\"admin.php?view=admin&ac=requests&action=markpaid&id=$this_request[id]&user=$this_request[username]&".$url_variables."\" onclick=\"return confirm('Are You Sure You Want To Mark These Paid?')\">Mark Paid</a></td>
					<td><a href=\"admin.php?view=admin&ac=requests&action=cancel&id=$this_request[id]&user=$this_request[username]&".$url_variables."\" onclick=\"return confirm('Are You Sure You Want To Cancel This?')\">Cancel</a></td>
					<td><a href=\"admin.php?view=admin&ac=requests&action=delete&id=$this_request[id]&user=$this_request[username]&".$url_variables."\" onclick=\"return confirm('Are You Sure You Want To Delete This?')\">Delete</a></td>


				</tr>
";
	}
}
else {
	$requestslisted="
		<tr>
			<td class=\"tableHL2\" colspan=7 align=\"center\">No Results Found!</td>
		</tr>";
}

	$includes[content].="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=pendingrequests&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"requests.username\" ".iif($search_by == "requests.username", "SELECTED").">Username
			<option value=\"requests.account\" ".iif($search_by == "requests.account", "SELECTED").">Account
			<option value=\"password\" ".iif($search_by == "password", "SELECTED").">Password
			<option value=\"last_ip\" ".iif($search_by == "last_ip", "SELECTED").">Last Ip
			<option value=\"country\" ".iif($search_by == "country", "SELECTED").">Country
		</select>
		<br /><input type=\"submit\" value=\"Search\">".iif($search_by!="","<br /><a href=\"admin.php?view=admin&ac=pendingrequests&".$url_variables."\">Cancel Search</a>")."</td>
	</tr>
    <tr>You may click on Account Name to Verify the account in PayPal.<br></tr>
</table>
</form>

<form action=\"admin.php?view=admin&ac=pendingrequests&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\" method=\"post\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"1100\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td style=\"width: 10px\"></td>
					<td NOWRAP><b><a href=\"admin.php?view=admin&ac=pendingrequests&orderby=requests.dsub&type=$newtype".iif($search_var,"$search_var")."&".$url_variables."\">Date ".$order[6]."</a></b></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=pendingrequests&orderby=requests.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order[1]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=pendingrequests&orderby=withdraw_options.title&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Method</b> ".$order[2]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=pendingrequests&orderby=requests.account&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Account</b> ".$order[3]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=pendingrequests&orderby=requests.fee&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Fee</b> ".$order[4]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=pendingrequests&orderby=requests.amount&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Net</b> ".$order[5]."</a></td>
					<td>Upgraded</td>
					<td>Country</td>
					<td>Last IP</td>
			                <td>Check IP</td>
					<td></td>
					<td></td>
					</tr>
				
					$requestslisted
				
			</table>
		</td>
	</tr>
</table>
<br />
<b>With Selected: </b> <input type=\"submit\" name=\"action\" value=\"Cancel\"><br><br>
<b>With Selected: </b> <input type=\"submit\" name=\"action\" value=\"Mark Paid\">
</form>

";
if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Requests<br />";
	if($ttotal > 50) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-50;
		$bc.="<a href=\"admin.php?view=admin&ac=pendingrequests&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+50 < $ttotal)) {$bc.=" :: ";}
	if($start+50 < $ttotal) {
		$start=$start+50;
		$bc.=" <a href=\"admin.php?view=admin&ac=pendingrequests&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 50) {$bc.=" ]";}
}



$includes[content].=$bc."</div><br />";
//**E**//
?>
