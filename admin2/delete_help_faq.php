<?
$Db1->query("SELECT * FROM help_faqs WHERE id='$id'");
if($Db1->num_rows() != 0) {
	$temp=$Db1->fetch_array($sql);
	$Db1->query("DELETE FROM help_faqs WHERE id='$id'");
	$Db1->query("UPDATE help_cats SET faqs=faqs-1 WHERE id='$temp[cat]'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=help&".$url_variables."");
}
?>
