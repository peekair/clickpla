<?
include("admin2/ajax_php/memberManager/header.php");
global $user, $id, $settings, $url_variables;

$sql=$Db1->query("SELECT footprints.* FROM footprints WHERE username='$user[username]' ORDER BY dsub DESC LIMIT 10");
$total_footprints=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; ($this_footprints=$Db1->fetch_array($sql)); $x++) {
		$footprintsslisted .= "
				<tr>
					<td>".date('g:i A - M d, Y', @mktime(0,0,$this_footprints[dsub],1,1,1970))."</td>
					<td><a title=\"$this_footprints[uri]\">$this_footprints[title]</a></td>
				</tr>
";
	}
}
else {
	$footprintsslisted="
		<tr>
			<td colspan=2 align=\"center\">No Footprints Found!</td>
		</tr>";
}


?>

<table class="tableData">
	<tr>
		<th>Date</th>
		<th>Log</th>
	</tr>
	<?=$footprintsslisted;?>
</table>