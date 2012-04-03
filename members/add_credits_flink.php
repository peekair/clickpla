<?
//**S**//
		$pid=rand_string(10);
		$sql=$Db1->query("INSERT INTO orders SET
			order_id='$pid',
			username='$username',
			ad_type='flink',
			ad_id='$id',
			dsub='".time()."'
		");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=buywizard&step=3&pid=$pid&".$url_variables."");
//**E**//
?>