<?
requireAdmin();


$sql=$Db1->query("INSERT INTO ptsuads SET 
		title='".htmlentities($title)."',
		target='$target',
		username='$user',
		credits='$credits',
		class='$class',
		pamount='$pamount',
		forbid_retract='$forbid_retract',
		active='$active',
        subtitle='$subtitle',
        subtitle_on='1'
	");


?>

<script>
create_done();
</script>