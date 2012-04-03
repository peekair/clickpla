<?
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$sql=$Db1->query("SELECT * FROM orders WHERE order_id='$order_id'");
$order=$Db1->fetch_array($sql);
$cost=$order[cost];
$includes[content]="
	<div align=\"center\">
		<table>
			<tr>
				<td>Item: </td>
				<td>$order[payment_id]</td>
			</tr>
			<tr>
				<td>Cost: </td>
				<td>
				".iif($order[proc]==6,"".($cost*100)." Points",iif($order[proc]==10,"".($order[amount])." F.A Credits",iif($order[proc]==11,"".($order[amount])." Banner Credits",iif($order[proc]==12,"".($order[amount])." Link Credits","$cursym $order[cost]"))))."
				</td>
			</tr>
			<tr>
				<td align=\"center\" colspan=2><b>Thank You For Your Order!</b><br /><a href=\"index.php?view=account&ac=order_ledger&".$url_variables."\">Click Here To View Status Of The Order</a></td>
			</tr>
		</table>
	</div>";
?>