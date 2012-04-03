<?
include("admin2/ajax_php/memberManager/header.php");
global $user, $id, $settings;


$sql=$Db1->query("SELECT ledger.* FROM ledger WHERE username='$user[username]' ORDER BY dsub DESC");
$total_ledger=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; ($this_ledger=$Db1->fetch_array($sql)); $x++) {
		$ledgerslisted .= "
				<tr>
					<td>".date('M d, Y', @mktime(0,0,$this_ledger[dsub],1,1,1970))."</td>
					<td>$this_ledger[product]</td>
					<td>$this_ledger[amount]</td>
					<td>$settings[currency]$this_ledger[cost]</td>
					<td>$this_ledger[proc]</td>
					<td>$this_ledger[account]</td>
					<td>$this_ledger[transaction_id]</td>
					<td>$this_ledger[payment_id]</td>
				</tr>
";
	}
}
else {
	$ledgerslisted="
		<tr>
			<td class=\"tableHL2\" colspan=9 align=\"center\">No Search Results Found!</td>
		</tr>";
}

echo "

<table class=\"tableData\">
	<tr class=\"tableHL1\">
		<th>Date</th>
		<th>Product</th>
		<th>Amount</th>
		<th>Price</th>
		<th>Method</th>
		<th>Account</th>
		<th>Transaction Id</th>
		<th>Order Id</b></th>
	</tr>
	
	{$ledgerslisted}
</table>

";

?>