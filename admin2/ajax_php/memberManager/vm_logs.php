<?
include("admin2/ajax_php/memberManager/header.php");
global $user, $id, $settings, $url_variables;


$sql=$Db1->query("SELECT logs.* FROM logs WHERE username='$user[username]' ORDER BY dsub DESC LIMIT 20");
$total_footprints=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; ($this_logs=$Db1->fetch_array($sql)); $x++) {
		$logslisted .= "
				<tr>
					<td>".date('M d, Y', @mktime(0,0,$this_logs[dsub],1,1,1970))."</td>
					<td>".iif($this_logs[order_id]!="","<a href=\"admin.php?view=admin&ac=ledger&search=1&search_str=$this_logs[order_id]&search_by=payment_id&".$url_variables."\">")."$this_logs[log]</a></td>
				</tr>
";
	}
}
else {
	$logslisted="
		<tr>
			<td colspan=2 align=\"center\">No Logs Found!</td>
		</tr>";
}


?>

<table class="tableData">
	<tr>
		<th>Date</th>
		<th>Log</th>
	</tr>
	<?=$logslisted;?>
</table>