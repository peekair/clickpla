<?
//**S**//
$sql=$Db1->query("DELETE FROM news WHERE id='$id'");
$Db1->sql_close();
header("Location: admin.php?view=news&".$url_variables."");
//**E**//
?>
