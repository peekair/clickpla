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
$includes[title]="Payouts Manager Main";
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

$sql=$Db1->query("SELECT * FROM withdraw_options ORDER BY title");
while($wo = $Db1->fetch_array($sql)) {
	$sql2=$Db1->query("SELECT SUM(amount) as total FROM requests WHERE accounttype='$wo[id]'");
	$temp=$Db1->fetch_array($sql2);
	$payoutlist.="
	<tr>
		<td><a href=\"admin.php?view=admin&ac=payouts2&id=$wo[id]&".$url_variables."\">$wo[title]</a></td>
		<td>$cursym ".round($temp[total],2)."</td>
	</tr>
	";
}

$includes[content]="

<div style=\"text-align: center; float: left; width: 200px;\">
<table width=200 align=\"center\" class=\"tableStyle2\">
	<tr class=\"tableHead\">
		<td colspan=2><b>Requested Payouts</b></td>
	</tr>
	<tr>
		<td><b>Method</b></td>
		<td><b>Waiting</b></td>
	</tr>
	$payoutlist
</table>
</div>
";



$payoutlist="";
if($settings[auto_pay_on]) {
	$sql=$Db1->query("SELECT * FROM withdraw_options ORDER BY title");
	while($wo = $Db1->fetch_array($sql)) {
		$wolist[$wo[id]]=$wo[title];
		$sql2=$Db1->query("SELECT SUM(balance) as total FROM user WHERE auto_pay='1' and auto_method='$wo[id]' and auto_account!='' and balance >=$wo[minimum]");
		$temp=$Db1->fetch_array($sql2);
		$payoutlist.="
		<tr>
			<td><a href=\"admin.php?view=admin&ac=payouts_process2&id=$wo[id]&".$url_variables."\">$wo[title]</a></td>
			<td>$cursym ".round($temp[total],2)."</td>
		</tr>
		";
	}
	$includes[content].="
<div style=\"text-align: center; float: left; width: 200px; padding-left: 30px;\">
	<table width=200 align=\"center\" class=\"tableStyle2\">
		<tr class=\"tableHead\">
			<td colspan=2><b>Auto Payouts</b></td>
		</tr>
		<tr>
			<td><b>Method</b></td>
			<td><b>Available</b></td>
		</tr>
		$payoutlist
	</table>
</div>
";
}

$includes[content].="<div style=\"clear: both\"></div>";


if($action == "markpaid") {
	$sql=$Db1->query("SELECT * FROM payouts WHERE id='$pid'");
	$selpayout=$Db1->fetch_array($sql);
	$today_date=date("d/m/y");
	$sql=$Db1->query("SELECT id FROM stats WHERE date='$today_date'");
	$sql=$Db1->query("UPDATE stats SET paid=paid+".$selpayout[amount]." WHERE date='$today_date'");
	$sql=$Db1->query("UPDATE payment_history SET dsub='$selpayout[dsub]', status='1', paid='".time()."' WHERE payout_id='$selpayout[payout_id]'");
	$sql=$Db1->query("UPDATE payouts SET paid='1' WHERE id='$pid'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=payouts&id=$id&".$url_variables."");
}

if($action == "view") {
	$sql=$Db1->query("SELECT * FROM payouts WHERE id='$pid' ORDER BY id DESC LIMIT 1");
	$selpayout=$Db1->fetch_array($sql);
	$includes[content].="
<hr>
	<div>
	".$wolist[$selpayout[accounttype]]." - $selpayout[payments] Payments - \$$selpayout[amount] Total<br />
	<textarea cols=50 rows=10 wrap=\"off\">".$selpayout[mass]."</textarea><br />
	<input type=\"button\" value=\"Mark As Paid\" onclick=\"location.href='admin.php?view=admin&ac=payouts&action=markpaid&id=$id&pid=$pid&".$url_variables."'\">
	</div>
	";
}

$payoutlist="";
$sql=$Db1->query("SELECT * FROM payouts  ORDER BY paid ASC, dsub DESC");
while($payout=$Db1->fetch_array($sql)) {
	$payoutlist.="
	<tr".iif($payout[paid]==0," bgcolor=\"lightyellow\"").">
		<td>".$wolist[$payout[accounttype]]."</td>
		<td><a href=\"admin.php?view=admin&ac=payouts&action=view&id=$id&pid=$payout[id]&".$url_variables."\">".date('M d', mktime(0,0,$payout[dsub],1,1,1970))."</a></td>
		<td>$payout[payments]</td>
		<td>$payout[amount]</td>
		<td style=\"background-color: ".iif($payout[paid]==0,"red","green")."; color: white\"><b>".iif($payout[paid]==0,"Not Paid!","Paid!")."</b></td>
	</tr>";
}

$includes[content].="
<hr>
<table class=\"tableStyle2\" style=\"width: 430px\">
	<tr class=\"tableHead\">
		<td><b>Method</b></td>
		<td><b>Date</b></td>
		<td><b>Payments</b></td>
		<td><b>Amount</b></td>
		<td><b>Status</b></td>
	</tr>
	$payoutlist
</table>
";

//**E**//
?>
