<?
requireAdmin();


$sql=$Db1->query("INSERT INTO ptsuads SET 
		title='".htmlentities($title)."',
		target='$target',
		username='$user',
		credits='$credits',
		class='$cclass',
		pamount='$pamount',
		forbid_retract='$forbid_retract',
		active='$active'
	");


?>

<script>
create_done();
</script>