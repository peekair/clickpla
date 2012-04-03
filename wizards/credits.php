<?
$producttitle="Raw Credits";
//**S**//
$Db1->sql_close();
header("Location: index.php?view=account&ac=buywizard&step=3".iif($samount, "&samount=$samount")."&pid=$pid&".$url_variables."");
//**E**//
?>