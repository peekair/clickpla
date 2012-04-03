<?
$includes[title]="Investment Tokens";
if(SETTING_TOK==true) {
$sql=$Db1->query("SELECT * FROM tokens WHERE username='$username' ORDER BY payable");
if($Db1->num_rows() != 0) {
	while($token = $Db1->fetch_array($sql)) {
		if($token[status] == 0) {
			$list.="
			<tr".iif($token[status]==0," bgcolor=\"#f8f8f8\"").">
				<td>\$$token[amount]</td>
				<td>".date('F Y', mktime(0,0,$token[dsub],1,1,1970))."</td>
				<td>".$token[returnmin]."% - ".$token[returnmax]."%</td>
				<td>".date('F 10, Y', mktime(0,0,$token[payable],1,1,1970))."</td>
			</tr>";
		}
		else {
			$paidlist.="
			<tr>
				<td>\$$token[amount]</td>
				<td>\$$token[paid] (".@round(($token[paid]-$token[amount])/$token[amount]*100)."%)</td>
				<td>".date('F Y', mktime(0,0,$token[dsub],1,1,1970))."</td>
				<td>".date('F d, Y', mktime(0,0,$token[payable],1,1,1970))."</td>
				</td>
			</tr>";
		}
	}
}
else {
	$list="
	<tr>
		<td colspan=5 align=\"center\"><b style=\"color: darkred\">You do not have any tokens!</b></td>
	</tr>
	";
}

$includes[content]="
<div align=\"center\">

<b style=\"color: darkblue\">Pending Tokens</b>
<table width=\"100%\">
	<tr>
		<td><b>Token Amount</b></td>
		<td><b>Purchased</b></td>
		<td><b>Return %</b></td>
		<td><b>Redeemable</b></td>
	</tr>
	$list
</table>

<br>

<b style=\"color: darkblue\">Paid Tokens</b>
<table width=\"100%\">
	<tr>
		<td><b>Token Amount</b></td>
		<td><b>Returned</b></td>
		<td><b>Purchased</b></td>
		<td><b>Paid</b></td>
	</tr>
	$paidlist
</table>

</div>
";
?><? } 
else {
	$includes[content]="This site does not have Investment Tokens enabled. Please contact your script supplier for more information.";
}?>
