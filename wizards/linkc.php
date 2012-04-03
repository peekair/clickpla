<?
//**VS**//$setting[ptc]//**VE**//
//**S**//
$Db1->sql_close();
header("Location: index.php?view=account&ac=buywizard&step=3".iif($samount, "&samount=$samount * $settings[bog_amount]")."&pid=$order[order_id]&".$url_variables."");
//**E**//
?>