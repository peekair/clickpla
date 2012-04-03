<?
requireAdmin();

/*
0	waiting approval
1	approved by admin
2	waiting approval by advertiser
3	denied by admin
4	denied by advertiser
*/




if($mass == 1) {
	$ida = explode(",",$ids);
	for($x=0; $x<count($ida); $x++) {
//		echo $ida[$x]." : $approve<br />";
		processSignup($ida[$x], $approve);
	}
	?>
<script>
approve_done_mass_signup('<? echo $ids; ?>');
</script>
	<?
}
else {
	processSignup($id, $approve);
	?>
<script>
approve_done_signup('<? echo $id; ?>');
</script>	
	<?
}


?>

