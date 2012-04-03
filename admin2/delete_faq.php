<?
//**S**//
$sql=$Db1->query("SELECT * FROM help_faqs WHERE id='$id'");
$faq=$Db1->fetch_array($sql);
$sql=$Db1->query("DELETE FROM help_faqs WHERE id='$id'");
$sql=$Db1->query("UPDATE help_cats SET faqs=faqs-1 WHERE id='$faq[cat]'");
header("Location: admin.php?view=help&cat=$catid&".$url_variables."");
//**E**//
?>
