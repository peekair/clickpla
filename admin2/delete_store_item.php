<?
$includes[title]="Delete Store Item";
//**S**//
if($step == 2) {
	$sql=$Db1->query("DELETE FROM store_items WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=point_store&".$url_variables."");
	exit;
}
else {
	$includes[content]="
Are You Sure You Want To Delete This Store Item?<br />
<a href=\"admin.php?view=admin&ac=delete_store_item&step=2&id=$id&".$url_variables."\">Yes</a> : 
<a href=\"admin.php?view=admin&ac=point_store&".$url_variables."\">No</a>
	";
}
//**E**//
?>
