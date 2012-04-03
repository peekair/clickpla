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
$sql=$Db1->query("SELECT * FROM withdraw_options WHERE id='$id'");
$wo=$Db1->fetch_array($sql);

$includes[title]="$wo[title] - Process Auto-Payouts";

$sql=$Db1->query("SELECT SUM(balance) as total FROM user WHERE auto_pay='1' and auto_method='$id' and auto_account!=''");
$watingtotal=$Db1->fetch_array($sql);

$amountleft=$waitingtotal[total];

function formatmp($request) {
	global $wo;
	
	$temp=explode($wo[delim],$wo[mps]);
	for($x=0; $x<count($temp); $x++) {
		$temp2=$request[$temp[$x]];
		if($temp2 == "") {
			$temp2=$temp[$x];
		}
		$return.=$temp2.iif($x<(count($temp)-1),$wo[delim]);
	}
	
	$return = str_replace("{tab}","\t",$return."\n");
	return $return;
}

function add2queue($request, $payout_id) {
	global $Db1, $id, $wo;
	$request[balance]=round($request[balance],2);
	$Db1->query("UPDATE user SET balance=balance-$request[balance] WHERE username='$request[username]'");
	
	$fee=0;
	$ramount=$request[balance];
	if($thismemberinfo[type] == 0) {
		if($ramount <= 1) 		$fee=$wo[fee]/100;
		else if($ramount > 1) 	$fee=$amount*$wo[fee]/100;
		$ramount=$ramount-$fee;
	}	
	
	if(!check_valid_price($ramount)) {
		$ramount="$ramount"."0";
	}
	
	$request[amount]=$ramount;
	$request[account]=$request[auto_account];
	
	$sql=$Db1->query("INSERT INTO payment_history SET 
			payout_id='$payout_id',
			rdsub='$request[dsub]',
			dsub='".time()."',
			username='$request[username]',
			account='".addslashes($request[auto_account])."',
			amount='$ramount',
			fee='$fee',
			accounttype='$wo[title]',
			status='0'
	");
	echo "<!-- Queued $request[username] For $cursym $request[balance]! -->";
	flush();
	return array($ramount,formatmp($request));
}

function queue_payments($amountleft, $payout_id) {
	global $Db1, $id, $wo;
	$sql=$Db1->query("SELECT * FROM user WHERE auto_pay='1' and auto_method='$id' and auto_account!='' and balance >=$wo[minimum]");
	//$sql=$Db1->query("SELECT * FROM requests WHERE accounttype='$id' ORDER BY dsub");
	while($request=$Db1->fetch_array($sql)) {
		echo "$request[username]<br />";
		if($request[balance] <= $amountleft) {
			$temp = add2queue($request, $payout_id);
			$masspay[0]+=$temp[0];
			$masspay[1].=$temp[1];
			$masspay[2]++;
			$amountleft-=$request[balance];
		}
	}
	return $masspay;
}



if($action == "queue") {
	$payout_id=rand_string(5);
	$masspay = queue_payments($queueamount, $payout_id);
	$sql=$Db1->query("INSERT INTO payouts SET
		dsub='".time()."',
		amount='$masspay[0]',
		mass='".addslashes($masspay[1])."',
		payments='$masspay[2]',
		payout_id='$payout_id',
		accounttype='$id'
	");
	$Db1->sql_close();
	echo "<script>document.location='admin.php?view=admin&ac=payouts&".$url_variables."';</script>";
}



$includes[content]="
<div align=\"right\"><a href=\"admin.php?view=admin&ac=payouts&".$url_variables."\">Payouts Manager Main</a></div>

".iif($watingtotal[total]>0,"
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=payouts_process2&id=$id&action=queue&".$url_variables."\" method=\"post\">
Current $wo[title] Possible Amount: $cursym $watingtotal[total]<br />
$cursym <input type=\"text\" name=\"queueamount\" value=\"".($watingtotal[total]+0.01)."\" size=5> <input type=\"submit\" value=\"Queue Payments\"><br /><br />
</form>
</div>
","There are no accounts that are available for auto-payment right now.")."


";
//**E**//
?>
