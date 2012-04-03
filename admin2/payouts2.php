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

$includes[title]="$wo[title] Payouts Manager";

$sql=$Db1->query("SELECT SUM(amount) as total FROM requests WHERE accounttype='$id'");
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
	$request[amount]=round($request[amount],2);
	if(!check_valid_price($request[amount])) {
		$request[amount]="$request[amount]"."0";
	}
	$sql=$Db1->query("DELETE FROM requests WHERE id='$request[id]'");
	$sql=$Db1->query("INSERT INTO payment_history SET 
			payout_id='$payout_id',
			rdsub='$request[dsub]',
			dsub='".time()."',
			username='$request[username]',
			account='".addslashes($request[account])."',
			amount='$request[amount]',
			fee='$request[fee]',
			accounttype='$wo[title]',
			status='0'
	");
	echo "<!-- Queued $request[username] For $cursym $request[amount]! -->";
	flush();
	return array($request[amount],formatmp($request));
}

function queue_payments($amountleft, $payout_id) {
	global $Db1, $id;
	$sql=$Db1->query("SELECT * FROM requests WHERE accounttype='$id' ORDER BY dsub");
	while($request=$Db1->fetch_array($sql)) {
		if($request[amount] <= $amountleft) {
			$temp = add2queue($request, $payout_id);
			$masspay[0]+=$temp[0];
			$masspay[1].=$temp[1];
			$masspay[2]++;
			$amountleft-=$request[amount];
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
<form action=\"admin.php?view=admin&ac=payouts2&id=$id&action=queue&".$url_variables."\" method=\"post\">
Current $wo[title] Waiting Amount: $cursym $watingtotal[total]<br />
$cursym <input type=\"text\" name=\"queueamount\" value=\"".($watingtotal[total]+0.01)."\" size=5> <input type=\"submit\" value=\"Queue Payments\"><br /><br />
</form>
</div>
","There are no pending requests right now!")."


";
//**E**//
?>
