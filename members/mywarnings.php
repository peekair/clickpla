<?
$sql=$Db1->query("SELECT * FROM warnings WHERE username='$username' ORDER BY dsub DESC");
while($warnings=$Db1->fetch_array($sql)) {

$allwarnings.="
<font color=\"blue\"><small>Date Issued: ".date('M d, Y', time(0,0,$news[dsub],1,1,1970))."</font></small><br>
<h4>".stripslashes($warnings[title])."</h2>
".stripslashes($warnings[warning])."
<hr>";
}

$includes[content]="
<table width=\"525\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tr><font color=\"red\">
<td width=\"57\" height=\"32\"><img src=\"members/img/warning.jpg\" border=\"0\"></td>
<td width=\"468\"><font color=\"red\">You are allowed ".stripslashes($settings[nomfw])." warnings before your account is suspended.<br>
You currently have a total of $thismemberinfo[warnings] warnings.</font></td>
  </tr>
</table><hr>
$allwarnings
<br><br>
";

?>


