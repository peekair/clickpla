<?
requireAdmin();

$Db1->query("UPDATE ptsuads SET active='".iif($approve==1,"1","2")."' WHERE id='$id'");

?>



<script>
approve_done('<? echo $id; ?>');
</script>