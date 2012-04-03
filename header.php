<?
$vip=getenv("REMOTE_ADDR");

$id=$_REQUEST['id'];
if (ereg('[^0-9]', $id)) { $id=false; }


$permission = 0;
include("includes/functions.php");
//**S**//
$settingsdemo=false;

session_start();

$aurora=true;

@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
@header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
@header("Cache-Control: no-cache, must-revalidate");
@header("Pragma: no-cache");

if(isset($referrer)) {$ref=$referrer;}
if(isset($referer)) {$ref=$referer;}

include("config.php");
require("./includes/globals.php");
include("./includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);


if($ref) {
//	$Db1->query("UPDATE user SET ptp_track=ptp_track+1 WHERE username='$ref'");
}
include("./includes/sessions.php");

if($LOGGED_IN) {
//	$Db1->query("UPDATE user SET hit_track=hit_track+1 WHERE username='$username'");
//	$Db1->query("UPDATE user SET last_page='".$REQUEST_URI."' WHERE username='$username'");
}

if($zxc == 1) {
/*	$sql=$Db1->query("SELECT * FROM settings");
	echo "<br /><br /><br />";
	while($temp=$Db1->fetch_array($sql)) {
		echo "\"".addslashes($temp[title])."\" => \"".addslashes($temp[setting])."\",<br />";
	}*/
}

$today_date=date("d/m/y");
$sql=$Db1->query("SELECT id FROM stats WHERE date='$today_date'");
if($Db1->num_rows() == 0) {
	$sql-$Db1->query("INSERT INTO stats SET date='$today_date'");
}
$sql=$Db1->query("UPDATE stats SET hits=hits+1 WHERE date='$today_date'");


$sql=$Db1->query("SELECT * FROM dailyhits WHERE `ip`='$vip'");
if($Db1->num_rows() == 0) {
$unique=1;
$Db1->query("UPDATE stats SET unhits=unhits+1 WHERE date='$today_date'");
$sql=$Db1->query("SELECT * FROM dailyhits WHERE `ip`='$vip'".iif($settings[ptpuniqueuser] == 1," and ref='$ref'")."");
if($Db1->num_rows() == 0) {
$freshvisit=1;
}
$Db1->query("INSERT INTO dailyhits SET `ip`='$vip', ref='$ref'");
}


if($ref != "") {
	if($settings[block_nem] == 1) {
		$sql=$Db1->query("SELECT suspended FROM user WHERE username='$ref'");
		$temp=$Db1->fetch_array($sql);
		if(($Db1->num_rows() == 0) || ($temp[suspended] == 1)) {
			$Db1->sql_close();
			header("Location: $settings[nem_goto]");
			exit;
		}
	}
	$Db1->query("UPDATE user SET ref_hits_raw=ref_hits_raw+1 ".iif($unique==1,", ref_hits_unique=ref_hits_unique+1")." WHERE username='$ref'");
}


if(($settings[floodguard_on] == 1)) {
	$sql=$Db1->query("SELECT * FROM dailyhits WHERE `ip`='$vip' and ref='$ref'");
	$temp=$Db1->fetch_array($sql);
	$sql=$Db1->query("UPDATE dailyhits SET ".iif(($temp[last_time]+$settings[floodguard_seconds])>time(),"mcount=mcount+1","last_time='".time()."', mcount='1'")." WHERE `ip`='$vip' and ref='$ref'");
	if(($temp[last_time]+$settings[floodguard_seconds]>time()) && ($temp[mcount] >= $settings[floodguard_hits])) {
		$sql=$Db1->query("UPDATE stats SET floodguard=floodguard+1 WHERE date='$today_date'");
		$sql=$Db1->query("UPDATE user SET floodguard=floodguard+1, floodguard_today=floodguard_today+1 WHERE username='$ref'");
		$Db1->sql_close();
		header("Location: $settings[floodguard_foward]");
	}
}


$url_variables=iif($sid, "sid=".$sid."&").iif($sid2, "sid2=".$sid2."&").iif($dbg==1, "dbg=1&").iif($siduid, "siduid=".$siduid."&").iif($ref!="","ref=$ref"."&");


	$referringurl=parse_url($HTTP_REFERER);

if(($settings[track_refers] == 1) && ($ref != "")) {
	$sql=$Db1->query("SELECT * FROM refdomains WHERE domain='$referringurl[host]'");
	if($Db1->num_rows() > 0) {
		$Db1->query("UPDATE refdomains SET hits = hits + 1 WHERE domain='$referringurl[host]'");
	}
	else {
		$Db1->query("INSERT INTO refdomains SET domain='$referringurl[host]', hits='1'");
	}
}

if($settings[block_domains] == 1) {
	$sql=$Db1->query("SELECT * FROM blocklist WHERE domain='$referringurl[host]'");
	if($Db1->num_rows() > 0) {
		$Db1->sql_close();
		header("Location: $settings[banned_goto]");
		die();
	}
}


if((SETTING_PTP == true) && ($ref != "")) {
	if(($freshvisit == 1) || ($settings[ptpunique] != 1)) {
		if($settings[ptpallow] == 1) {
			$sql=$Db1->query("SELECT * FROM ptp_allow WHERE domain='$referringurl[host]'");
			$allowed = $Db1->num_rows();
		}
		if(($ref != "") && ($settings[ptpon] == 1) && ($settings[ptppopup] != 1) && (($allowed > 0) || ($settings[ptpallow] == 0))) {
			if(($referringurl[host] != "") || ($settings[no_ref_pay] == 1)) {
				$sql=$Db1->query("SELECT type, membership FROM user WHERE username='$ref'");
				$temprefinfo=$Db1->fetch_array($sql);
				if($temprefinfo[type] == 1) {
					$sql=$Db1->query("SELECT ptp FROM memberships WHERE id='$temprefinfo[membership]'");
					$tempmem=$Db1->fetch_array($sql);
					$ptppay=$tempmem[ptp];
				}
				else {
					$ptppay=$settings[ptpamount];
				}
				$Db1->query("UPDATE user SET ptpearns=ptpearns+$ptppay, balance=balance+$ptppay, ptphits_today=ptphits_today+1, ptphits=ptphits+1 WHERE username='$ref'");
				$Db1->query("UPDATE stats SET ptphits=ptphits+1, cash=cash+$ptppay WHERE date='$today_date'");
			}
			else {
				$freshvisit=0;
			}
		}
	}
}



if($LOGGED_IN) {
	$sql=$Db1->query("UPDATE user SET last_act='".time()."' WHERE username='$username'");
}


$fivemin=time()-60;
$sql=$Db1->query("DELETE FROM online WHERE dsub<'$fivemin'");
$sql=$Db1->query("SELECT id FROM online WHERE ip='$vip' LIMIT 1");
if($Db1->num_rows() == 0) {
	$sql=$Db1->query("INSERT INTO online (userid, dsub, ip) VALUES ('$userid','".time()."','$vip')");
}

$sql=$Db1->query("SELECT COUNT(id) AS total FROM online");
$temp=$Db1->fetch_array($sql);
$total_online=$temp[total];


if(isset($track)) {
	$sql=$Db1->query("SELECT * FROM tracker WHERE track_id='".addslashes($track)."' and ip='$vip'");
	if($Db1->num_rows() == 0) {
		$sql=$Db1->query("INSERT INTO tracker SET track_id='".addslashes($track)."', ip='$vip', dsub='".time()."'");
	}
	else {
		$sql=$Db1->query("UPDATE tracker SET visits=visits+1 WHERE track_id='".addslashes($track)."' and ip='$vip'");
	}
}


//**E**//
?>