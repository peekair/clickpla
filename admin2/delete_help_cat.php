<?
$Db1->query("DELETE FROM help_cats WHERE id='$id'");
$Db1->sql_close();
header("Location: admin.php?view=admin&ac=help&".$url_variables."");
?>
