<?php
include("header.php");
$includes[title]="YOUR A BOT!";

		

		$Db1->query("UPDATE user SET notes='".$userinfo[notes]."\n---------------\nClicked bot detector ad ($vip)' WHERE username='$thismemberinfo[username]'");


		$sql=$Db1->query("INSERT INTO logs SET username='".$userinfo[username]."', log='BOT Clicked cheat link $thismemberinfo[username]',   dsub='".time()."'");
		$sql=$Db1->query("UPDATE user SET balance='0.00' WHERE username='$thismemberinfo[username]'");
	


?>
 </html>
</body>

