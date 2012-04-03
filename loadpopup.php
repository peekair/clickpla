<?
//**VS**//$setting[ptp]//**VE**//
$vip=getenv("REMOTE_ADDR");
include("includes/functions.php");
//**S**//
include("config.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
include("includes/globals.php");
if(SETTING_PTP == true) {
	$today_date=date("d/m/y");
	$sql=$Db1->query("SELECT id FROM stats WHERE date='$today_date'");
	if($Db1->num_rows() == 0) {
		$sql-$Db1->query("INSERT INTO stats SET date='$today_date'");
	}

	if($settings[ptpallow] == 1) {
		$sql=$Db1->query("SELECT * FROM ptp_allow WHERE domain='$rdom'");
		$allowed = $Db1->num_rows();
	}

	if(($ref != "") && ($settings[ptpon] == 1) && ($settings[ptppopup] == 1) && (($allowed > 0) || ($settings[ptpallow] == 0))) {
		$sql=$Db1->query("SELECT * FROM dailyhits WHERE `ip`='$vip' and ref='$ref' and paid='0'");
		if($Db1->num_rows() == 1) {
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
			$Db1->query("UPDATE dailyhits SET paid='1' WHERE `ip`='$vip' and ref='$ref'");
		}
	}

	$sql=$Db1->query("SELECT * FROM popups WHERE credits >=1 and active=1 ORDER BY RAND() LIMIT 1");
	if($Db1->num_rows() != 0) {
		$popup=$Db1->fetch_array($sql);
		$Db1->query("UPDATE popups SET views=views+1, views_today=views_today+1, credits=credits-1 WHERE id='$popup[id]'");
	}
}
else {
	$popup[target]="http://www.latinclicks.info";
}
$Db1->sql_close();
header("Location: $popup[target]");
//**E**//
?>