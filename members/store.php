<?
$includes[title]="Point Store";

$sql=$Db1->query("SELECT * FROM store_items WHERE active='1' and qty>0");
if($Db1->num_rows() > 0) {
	while($item=$Db1->fetch_array($sql)) {
		$list.="
			<tr class=\"tableHL3\">
				<td height=5 colspan=2></td>
			</tr>
			<tr class=\"tableHL2\">
				<td  nowrap=\"nowrap\" width=\"100\">
					<small>
						Quantity: $item[qty]<br />
						 ".iif($item[points]>0,"Point Cost:</b> $item[points]<br />")."
						 ".iif($item[cash]>0,"Cash Cost:</b> $item[cash]<br />")."
						<a href=\"index.php?view=account&ac=buy_item&id=$item[id]&".$url_variables."\">Purchase Item</a>
					</small>
				</td>
				<td>
					<b>$item[title]</b><br />
					".nl2br($item[description])."<br />
				</td>
			</tr>
		";
	}
}
else {
	$list="<tr class=\"tableHL2\"><td><b>There are no items in the store right now. Please check back frequently!</b></td></tr>";
}


$includes[content]="
Welcome to the Point Store. Here you can purchase items using your account balance and points!

<table cellpadding=1 cellspacing=0 class=\"tableBD1\" width=\"100%\">
	<tr>
		<td>
			<table width=\"100%\" cellpadding=0 cellspacing=0>
				$list
				
			<tr class=\"tableHL3\">
				<td colspan=2 height=5></td>
			</tr>
			</table>
		</td>
	</tr>
</table>


";
?>