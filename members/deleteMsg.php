<?

$Db1->query("DELETE FROM messages WHERE id='".addslashes($id)."' and username='$username' ");

$Db1->sql_close();
header("Location: index.php?view=account&ac=messages&".$url_variables."");
exit;

?>