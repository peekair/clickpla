<?
if(!IN_CLICKING) exit;

$ad=$Db1->query_first("SELECT * FROM ptrads WHERE id='$id'");

if($ad[credits] <= 0 || ($ad[daily_limit]<=$ad[views_today] && $ad[daily_limit] > 0)  || ($ad[upgrade] == 1 && $thismemberinfo[type]!=1)) {
	error("This Ad Is No Longer Available To Read!");
}

$time=time();
mt_srand((double)microtime()*1000000);
$num = mt_rand(0,3);

$Db1->query("DELETE FROM click_sessions WHERE username='$username' and type='ptra'");
$sql=$Db1->query("INSERT INTO click_sessions SET
	dsub='{$time}',
	username='{$username}',
	val='{$num}',
	type='ptra'
");

?>
<html>
<head>
<title><?  echo $settings[domain_name]; ?> : Get Paid To Read : <? echo ucwords(stripslashes($ad[title])); ?></title>
</head>
<body>
<div align="center">

<h2><? echo stripslashes($ad[title]);?></h2>
<table cellpadding=1 cellspacing=0 bgcolor="black">
	<tr>
		<td>
			<table width="500" height="200" cellspacing=0 cellpadding=5>
				<tr>
					<td bgcolor="white" valign="top"><? echo nl2br(strip_tags(stripslashes($ad[ad]))); ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table width="500">
	<tr>
		<td align="right">
			<input type="button" value="" id="countbutton" onclick="proceed()">
		</td>
	</tr>
</table>
<script>
x=11;
countbutton.disabled=true

function proceed() {
	if(countbutton.disabled == false) {
		location.href='gpt.php?v=entry&type=ptra&id=<? echo $id; ?>&<? echo $url_variables ?>'
	}
}

function countdown() {
	x--
	if(x == 0) {
		countbutton.disabled=false
		countbutton.value='Proceed To Site -->'
	}
	if(x > 0) {
		countbutton.value='                '+x+'                ';
		setTimeout('countdown()',1000);
	}
}
countdown()
</script>
</div>
</body>
</html>
<?
exit;
?>