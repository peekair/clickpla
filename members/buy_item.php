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
$includes[title]="Purchase Item";

$sql=$Db1->query("SELECT * FROM store_items WHERE id='$id'");
$item = $Db1->fetch_array($sql);

if($action == "buy") {
	if((($method == "points") && ($thismemberinfo[points] >= $item[points])) || (($method == "cash") && ($thismemberinfo[balance] >= $item[cash]))) {
		$Db1->query("UPDATE store_items SET qty=qty-1, sold=sold+1 WHERE id='$id'");
		$sql=$Db1->query("UPDATE user SET ".
			iif($method=="cash","balance=balance-$item[cash]").
			iif($method=="points","points=points-$item[points]").
		" WHERE username='$username'");
		$includes[content]="<b style=\"color: darkred\">Your order has been placed!</b><br />We will contact you with your product/service shortly!";
		$msg="
This user has just used the points store at $settings[site_title] to purchase the following item.

Username: $username
Email: $thismemberinfo[email]
Name: $thismemberinfo[name]
Payment Method: ".iif($method=="cash","$cursym $item[cash] Cash","$item[points] Points")."

Item: $item[title]
$item[description]
";
	mail("$item[email]","Item Purchased In The Point Store ($settings[site_title])",$msg,"From: $thismemberinfo[email]");
	}
	else {
		$includes[content]="<b style=\"color: darkred\">You do not have enough funds for this purchase!</b>";
	}
}

if($action == "") {
	$includes[content]="
	<form action=\"index.php?view=account&ac=buy_item&action=buy&id=$id&".$url_variables."\" method=\"post\">
<div align=\"center\">
<table width=350>
	<tr>
		<td width=100>Title: </td>
		<td width=250>$item[title]</td>
	</tr>
	<tr>
		<td colspan=2 class=\"tableHL2\">$item[description]</td>
	</tr>
	<tr>
		<td>Quantity: </td>
		<td>$item[qty]</td>
	</tr>
	".iif($item[points]!=0,"
		<tr>
			<td>Points Price: </td>
			<td>$item[points] Points</td>
		</tr>
	")."
	".iif($item[cash]!=0,"
		<tr>
			<td>Cash Price: </td>
			<td>$cursym $item[cash]</td>
		</tr>
	")."
	<tr>
		<td>Method: </td>
		<td>
			<select name=\"method\">
				".iif($item[points]!=0,"<option value=\"points\">Points")."
				".iif($item[cash]!=0,"<option value=\"cash\">Cash")."
			</select>
		</td>
	</tr>
	<tr>
		<td align=\"center\" colspan=2><input type=\"submit\" value=\"Purchase\"></td>
	</tr>

</table>
</div>
</form>
	";
}


?>