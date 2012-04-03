<?
//**S**//
$sql=$Db1->query("DELETE FROM terms WHERE id='$id'");
$Db1->sql_close();
header("Location: index.php?view=terms&".$url_variables."");
//**E**//
?>
