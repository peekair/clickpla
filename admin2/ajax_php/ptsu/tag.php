<?
requireAdmin();

if($tag == true) {
	$tagg = 1;
}
else $tagg=0;

$Db1->query("UPDATE ptsuads SET tagged='$tagg' WHERE id='$id'");

?>