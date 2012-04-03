<?
if(!IN_CLICKING) exit;

if(!$LOGGED_IN && $type == "ptc") {

$sql=$Db1->query("SELECT * FROM ".$adTables[$type]." WHERE id='{$id}'");
$ad=$Db1->fetch_array($sql);

if($type == "ptra") {
	$ct = $Db1->querySingle("SELECT dsub FROM click_sessions WHERE username='$username' and type='ptra'","dsub")+9;
	if($ct > time() || $Db1->num_rows()==0) error("You didn't wait long enough!");
}


$time=time();
mt_srand((double)microtime()*1000000);
$num = mt_rand(0,3);

$Db1->query("DELETE FROM click_sessions WHERE username='$username' and type='{$type}'");
$sql=$Db1->query("INSERT INTO click_sessions SET
	dsub='{$time}',
	username='{$username}',
	val='{$num}',
	type='{$type}'
");


if(cheat_check("click", $id) == true) {
	$ad[target]="gpt.php?v=cheat&id={$id}&return=click&".$url_variables;
	$id=-1;
} else {
	$Db1->query("UPDATE ".$adTables[$type]." SET oviews=oviews+1, oviews_today=oviews_today+1 WHERE id='$id'");
}
}

//$clicked = ($Db1->querySingle("SELECT count(id) as found FROM click_history WHERE username='{$username}' and ad_id='{$id}' and type='{$type}'","found")>0?true:false);

if($clickVerified == false && findclick($clickHistory, $id) == 1) {
	error("You Have Already Clicked This Link Today"); 
}


$sql=$Db1->query("SELECT * FROM ".$adTables[$type]." WHERE id='{$id}'");
$ad=$Db1->fetch_array($sql);

if($ad[credits] <= 0 || ($ad[daily_limit] <= $ad[views_today] && $ad[daily_limit] > 0) || ($ad[upgrade] == 1 && $thismemberinfo[type]!=1) ) {
	error("This Link Is Not Available To Click!");
}

/* error getting triggered after being redirected from the cheat check
if($type == "ptra") {
	$ct = $Db1->querySingle("SELECT dsub FROM click_sessions WHERE username='$username' and type='ptra'","dsub")+9;
	if($ct > time() || $Db1->num_rows()==0) error("You didn't wait long enough!");
}
*/


$time=time();
mt_srand((double)microtime()*1000000);
$num = mt_rand(0,3);

$Db1->query("DELETE FROM click_sessions WHERE username='$username' and type='{$type}'");
$sql=$Db1->query("INSERT INTO click_sessions SET
	dsub='{$time}',
	username='{$username}',
	val='{$num}',
	type='{$type}'
");


if(cheat_check("click", $id) == true) {
	$ad[target]="gpt.php?v=cheat&id={$id}&return=click&".$url_variables;
	$id=-1;
	
} else {


}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	<title>Viewing Ad @ <?=$settings['site_title'];?></title>
</head>

<frameset rows="100,*" style="border: 1px black;" noresize="noresize">
	<frame name="surftopframe" src="gpt.php?v=timer&user=<?=$username;?>&pretime=<?=$time;?>&id=<?=$id;?>&<?=$url_variables;?>" scrolling=no marginheight="2" marginwidth="2" noresize="noresize" >
	<frame name="surfmainframe" src="<?=$ad[target];?>" marginheight="0" marginwidth="0" noresize="noresize">
</frameset>

</html>