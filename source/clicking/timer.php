<?
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if(!IN_CLICKING) exit;

$referringurl=parse_url($HTTP_REFERER);
$selfurl=parse_url($_SERVER['PHP_SELF']);
if (!($referringurl['path'] == $selfurl['path'] && $referringurl['host'] == $_SERVER['HTTP_HOST'])) {
	logError("Failed referring host check while clicking: {$HTTP_REFERER}");
	error("There was an error validating your session");
}


if($id != -1) {
	if(true) { //TODO setup admin setting for showing banner
		$banner=$Db1->query_first("SELECT * FROM banners WHERE credits>=1  order by rand() limit 1");
		if(isset($banner[id])) $Db1->query("UPDATE banners SET credits=credits-1, views=views+1 WHERE id='{$banner[id]}'");
	}
		
	
	$key=$Db1->querySingle("SELECT val FROM click_sessions WHERE dsub='{$pretime}' and username='{$username}' and type='{$type}' ","val");
	
	srand ((float) microtime() * 10000000);
	$buttons = array ("1", "2", "3", "4", "5", "6", "7", "8", "9");
	$rand_keys = array_rand ($buttons, 5);
	$key = $buttons[$rand_keys[$key]];
	for($x=0; $x<5; $x++) { $buttonlist.="<li><a href=\"#\" onclick=\"next({$x})\" id=\"button{$x}\"><img src=\"clickimages/".$buttons[$rand_keys[$x]].".png\" alt=\"Click One\" /></a></li>\n"; }
	
	$t = $Db1->query_first("SELECT ".(($type=="ce" || $type=="ptre")?"":"timed,")." target FROM ".$adTables[$type]." WHERE id='{$id}'");
	
	if($type=="ce") $timer=$settings['ce_time'];
	elseif($type=="ptre") $timer=$settings['ptr_time'];
	else $timer=$t['timed'];
	
	$target=$t['target'];
}

?>

<html>
<head>
	<title><?=$settings['site_title'];?></title>
	<link href="templates/<?=$settings['template'];?>/timer.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		var id="<?=$id;?>";
		var url_variables="<?=$url_variables;?>";
		var timer=<? echo ($timer+1); ?>;
		var type="<?=$type;?>";
		var key="<?=$key;?>";
		var pretime="<?=$pretime;?>";

	</script>
	<script type="text/javascript" src="./includes/ajax/jquery.js"></script>
	<script type="text/javascript" src="./source/clicking/timer.js"></script>
</head>
<body>

<div id="timer">Loading</div>

<div id="buttons"><ul><?=$buttonlist;?></ul></div>

<br><br>
<div id="menu">
<br>	
<li><a href="<?=$target;?>" target="_blank">New Window</a></li>
	<li><a href="#" onClick="reportAd()">Report</a></li>
	
<?
	if ($type!="ce"){
	?>
	<li>Earned Today: $<?=$thismemberinfo['earned_today'];?></li>
<?
}
?>
<?
if($type=="ce") {

	$sql=$Db1->query("SELECT COUNT(id) AS total FROM xsites where credits != 0");
	$xclickstodo=$Db1->fetch_array($sql);
//     print "$xclickstodo[total]  $thismemberinfo[xclicked_today]";
      $clicksleft = ($xclickstodo['total'] - $thismemberinfo['xclicked_today']);
?>
<li>
Remaining Clicks : <? echo $clicksleft ?>
<?
}
?>



	<? if(!$LOGGED_IN && !$type == "ptre") { ?>
	<li><a href="index.php?view=join&<? echo $url_variables; ?>"><span><span>Register</span></span></a></li>
	<li><a href="index.php?view=login&<? echo $url_variables; ?>"><span><span>Login</span></span></a></li>
	<? } ?>
</div>
<div id="banner"><a href="bannerclick.php?id=<?=$banner[id];?>" target="_blank"><img src="<?=$banner[banner];?>" alt="Banner Advertisement" /></a></div>

</body>
</html>