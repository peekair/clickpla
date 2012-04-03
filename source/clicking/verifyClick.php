<?
if(!IN_CLICKING) exit;

if(cheat_check2("clickfinal", $id) == true) {
	$Db1->sql_close();
	header("Location: gpt.php?v=entry&id={$id}&{$url_variables}");
	exit;
}

if(!$LOGGED_IN && $type == "ptc") {
$time=time();
mt_srand((double)microtime()*1000000);
$num = mt_rand(0,3);

$ad=$Db1->query_first("SELECT * FROM ".$adTables[$type]." WHERE id='$id'");

$st = $statType[$type];

$Db1->sql_close();

if($_GET['s']==1) $goto = "gpt.php?v=entry&s=1&{$url_variables}";
else $goto = $ad['target'];


}


$Db1->query("UPDATE user SET last_click='".time()."' WHERE username='$username'");


$payout=0;

$time=time();
mt_srand((double)microtime()*1000000);
$num = mt_rand(0,3);

$ad=$Db1->query_first("SELECT * FROM ".$adTables[$type]." WHERE id='$id'");


if($type=="ce") $ad['timed']=$settings['ce_time'];

$browseval=$Db1->query_first("SELECT * FROM click_sessions WHERE dsub='{$_GET['pretime']}' AND username='{$username}' AND type='{$type}' LIMIT 1");

if($_GET['buttonClicked'] == "") error("Error determining which button clicked.");
elseif($_GET['pretime'] == "") error("Error determining pretime variable.");
elseif($Db1->num_rows() == 0) {

/*
		$sql=$Db1->query("SELECT * FROM click_sessions WHERE username='{$username}'");
		while($r = $Db1->fetch_array($sql)) {
			$list .= "\n--------------------\ndsub: {$r['dsub']}\ntype: {$r['type']}";
		}
		mail("","Click Error","Pretime: {$_GET['pretime']}\nUsername: {$username}\nType: {$type}\n{$list}","From: ");
*/
		error("There was a problem finding your click session. Are you viewing more than 1 ad at a time?");
}
elseif($_GET['buttonClicked'] != $browseval[val]) error("You clicked the wrong number!");
elseif((time()-$ad[timed]-1) < $browseval[dsub]) error("You did not wait long enough.");

/*
$Db1->query("INSERT INTO click_history SET 
	username='{$username}',
	type='{$type}',
	ad_id='{$id}'
");
*/

$Db1->query("UPDATE click_history SET clicks='".$clickHistory.$id.":' WHERE username='$username' and type='{$type}'");

$Db1->query("UPDATE ".$adTables[$type]." SET views=views+1, views_today=views_today+1, credits=credits-1 WHERE id='$id'");


$sql=$Db1->query("DELETE FROM click_sessions WHERE username='$username' AND type='{$type}'");

$todayDate=date("d/m/y");

$statType = array(
	"ptc"=>"clicked",
	"ptre"=>"emails",
	"ptra"=>"ptrads",
	"ce"=>"xclicked"
);
$st = $statType[$type];


$userStatType = array(
	"ptc"=>array("clicks","clicked_today"),
	"ptre"=>array("emails","emails_today"),
	"ptra"=>array("ptra_clicks","ptra_clicks_today"),
	"ce"=>array("xclicks","xclicked_today")
);
$ust = $userStatType[$type];






if($type == "ce") {
	$paytype="xcredits";
	$payout=round($settings[ce_ratio2]/$settings[ce_ratio1],5);
	$totalPaid=$payout;

	if(isset($userinfo[refered])) {
		$totalPaid += creditUpline($userinfo[refered], 1, $credits);
	}

	$sql=$Db1->query("UPDATE stats SET xclicked=xclicked+1, xcredits=xcredits+".$payout." WHERE date='$todayDate'");
	
$sql=$Db1->query("select * from xstage WHERE stage='$thismemberinfo[xclicks]'");
$stagem=$Db1->fetch_array($sql);
if($Db1->num_rows() != 0) {
$prizetype=$stagem[type];
$prizem=$stagem[amount];
$sql=$Db1->query("UPDATE user SET $prizetype=$prizetype+$prizem WHERE username='$username'");

}

	
$sql=$Db1->query("select * from xstage WHERE stage='$thismemberinfo[xclicked_today]' and daily='1'");
$staged=$Db1->fetch_array($sql);
if($Db1->num_rows() != 0) {
$prizetyped=$staged[type];
$prized=$staged[amount];
$sql=$Db1->query("UPDATE user SET $prizetyped=$prizetyped+$prized WHERE username='$username'");

}
	
	}
else {
	$paytype=($ad['class']=="P"?"points":"balance");

	if($type == "ptre") $payout = $settings['ptr_earn'];
	else $payout=$ad[pamount];
	
	$totalPaid=$payout;
	
	if((isset($thismemberinfo[refered])) && ($ad['class'] != "P")) {
		$totalPaid += pay_upline($thismemberinfo[refered], 1, ($ad[pamount]));
	}
	$sql=$Db1->query("UPDATE stats SET $st=$st+1, ".($ad['class']=="P"?"points=points":"cash=cash")."+".$totalPaid." WHERE date='$todayDate'");
}




if($paytype == "balance") $queryextra .= " earned_today=earned_today+$payout, "; 

if($type=="ptc") $queryextra.=" clickcon_clic=clickcon_clic+1, ";
if($type=="ptc" && $settings[tickets_ptc] > 0) $queryextra.=" tickets=tickets+$settings[tickets_ptc], ";
if($type=="ptre" && $settings[tickets_ptr] > 0) $queryextra.=" tickets=tickets+$settings[tickets_ptr], ";
if($type=="ptra" && $settings[tickets_ptra] > 0) $queryextra.=" tickets=tickets+$settings[tickets_ptra], ";
if($type=="ce" && $settings[tickets_xclick] > 0) $queryextra.=" tickets=tickets+$settings[tickets_xclick], ";

$sql=$Db1->query("UPDATE user SET $paytype=$paytype+$payout, $queryextra {$ust[0]}={$ust[0]}+1, {$ust[1]}={$ust[1]}+1 WHERE username='$username'");



	

$Db1->sql_close();

if($_GET['s']==1) $goto = "gpt.php?v=entry&s=1&{$url_variables}";
else $goto = $ad['target'];

header("Location: $goto");
exit;


?>