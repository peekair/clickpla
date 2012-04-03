<?
//**VS**//$setting[ptp]//**VE**//
//**S**//
if(SETTING_PTSU != true) {
	haultscript();
}

$Db1->sql_close();
header("Location: index.php?view=account&ac=buywizard&step=3".iif($samount, "&samount=$samount")."&pid=$order[order_id]&".$url_variables."");
//**E**//
?>