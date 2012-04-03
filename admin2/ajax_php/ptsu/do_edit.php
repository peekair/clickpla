<?
requireAdmin();

$sql=$Db1->query("UPDATE ptsuads SET
		title='".htmlentities($title)."',
		target='$target',
		username='$user',
		credits='$credits',
		class='$class',
		signups='$signups',
		pending='$pending',
		country='".addslashes($country)."',
		pamount='$pamount',
		featured='$featured',
		upgrade='$premOnly',
		subtitle_on='1',
		subtitle='".htmlentities($subtitle)."',
		icon_on='$icon_on',
		forbid_retract='$forbid_retract',
		active='$active'
	WHERE id='$id'
	");



?>



<script>
edit_done();
</script>