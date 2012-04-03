<?
//**VS**//$setting[ptr]//**VE**//
$includes[title]="Paid Email View [Final]";
include("header.php");
//**S**//

if(cheat_check2("pemailfinal", $id) == true) {
	$Db1->sql_close();
	header("Location: pemail.php?id=$id&".$url_variables."");
	exit;
}


$thisuser1cash=0;

$time=time();
mt_srand((double)microtime()*1000000);
$num = mt_rand(0,3);

$num=$num;

$sql=$Db1->query("SELECT * FROM emails WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

$sql=$Db1->query("SELECT * FROM email_browseval WHERE dsub='$pretime' AND username='$user' LIMIT 1");
$browseval=$Db1->fetch_array($sql);
$ccranval=$browseval[val];

if(($button_clicked != $ccranval) || ($button_clicked == "") || ($pretime == "") || ($Db1->num_rows() == 0) || ((time()-$ad[timed]) < $browseval[dsub])) {
	$correct=0;
}
else {
	$correct=1;
}
$sql=$Db1->query("DELETE FROM email_browseval WHERE username='$user'");


if($correct == 1) {
	$userinfo=$thismemberinfo;

	$pointspaid=$ad[pamount];

	if($settings[tickets_ptr] > 0) {
		$queryextra=" tickets=tickets+$settings[tickets_ptr], ";
	}

	$thisuser1cash=$settings[ptr_earn];
	$cashpaid=$thisuser1cash;

	$sql=$Db1->query("UPDATE user SET balance=balance+$thisuser1cash, $queryextra emails_today=emails_today+1, emails=emails+1 WHERE username='$user'");

	if(isset($userinfo[refered])) {
		$cashspaid += pay_upline($userinfo[refered], 1, $ad[pamount]);
	}

	$today_date=date("d/m/y");
	$sql=$Db1->query("UPDATE stats SET emails=emails+1, cash=cash+".$cashpaid." WHERE date='$today_date'");
}

$Db1->sql_close();
header("Location: $ad[target]");
exit;
//**E**//
?>

