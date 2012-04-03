<?
$includes[title]="Order Ledger";

//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=ledger&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables);
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" ledger.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total  FROM ledger ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="ledger.dsub";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";



$sql=$Db1->query("SELECT ledger.* FROM ledger ".iif($conditions,"WHERE $conditions")." ORDER BY $orderby $type LIMIT $start, 25");
$total_ledger=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_ledger=$Db1->fetch_array($sql); $x++) {
		$ledgerslisted .= "
				<tr>
					<td NOWRAP=\"NOWRAP\"><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_ledger[username]."&s=$s&direct=ledger&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_ledger[username]</a></td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[proc]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[account]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[product]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[amount]</td>
					<td NOWRAP=\"NOWRAP\">$cursym $this_ledger[cost]</td>
					<td NOWRAP=\"NOWRAP\">".date('M d, Y', mktime(0,0,$this_ledger[dsub],1,1,1970))."</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[transaction_id]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[payment_id]</td>
				</tr>
";
	}
}
else {
	$ledgerslisted="
		<tr>
			<td class=\"tableHL2\" colspan=10 align=\"center\">No Search Results Found!</td>
		</tr>";
}

	$includes[content].="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=ledger&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"transaction_id\" ".iif($search_by == "transaction_id", "SELECTED").">Transaction Id
			<option value=\"payment_id\" ".iif($search_by == "payment_id", "SELECTED").">Payment Id
			<option value=\"name\" ".iif($search_by == "name", "SELECTED").">Name
			<option value=\"account\" ".iif($search_by == "account", "SELECTED").">Account
			<option value=\"product\" ".iif($search_by == "product", "SELECTED").">Product
			<option value=\"name\" ".iif($search_by == "name", "SELECTED").">Name
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>


<table class=\"tableData\">
	<tr>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order['ledger.username']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.proc&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Method</b> ".$order['ledger.proc']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.account&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Account</b> ".$order['ledger.account']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.product&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Product</b> ".$order['ledger.product']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.amount&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Amount</b> ".$order['ledger.amount']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.cost&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Price</b> ".$order['ledger.cost']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.dsub&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Date</b> ".$order['ledger.dsub']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.transaction_id&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Transaction Id</b> ".$order['ledger.transaction_id']."</a></th>
		<th NOWRAP><a href=\"admin.php?view=admin&ac=ledger&orderby=ledger.payment_id&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Order Id</b> ".$order['ledger.payment_id']."</a></th>
	</tr>
	
		$ledgerslisted
	
</table>

";
if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Orders<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=ledger&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=ledger&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}



$includes[content].=$bc."</div><br />";
//**E**//
?>
