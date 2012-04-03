<?php
include("header.php");
$includes[title]="YOUR A BOT!";

		

		$Db1->query("UPDATE user SET notes='".$userinfo[notes]."\n---------------\nDeleted By Bot Detector ($vip)' WHERE username='$thismemberinfo[username]'");
		$Db1->query("DELETE FROM user_deleted WHERE username='$thismemberinfo[username]'");
		$Db1->query("INSERT INTO user_deleted SELECT * FROM user WHERE username='$thismemberinfo[username]'");
		$Db1->query("DELETE FROM user WHERE userid='$thismemberinfo[userid]'");

		$sql=$Db1->query("INSERT INTO logs SET username='".$userinfo[username]."', log='BOT Deleted Account $thismemberinfo[username]',   dsub='".time()."'");
		$sql=$Db1->query("UPDATE user SET refered='' WHERE refered='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM sessions WHERE user_id='$userinfo[userid]'");
		if($userinfo[refered]) {
			edit_upline(1, $userinfo[refered]);
		}


?>
 </html>
</body>

