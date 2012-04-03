<?
$includes[title]="Hall Of Shame";

$sql=$Db1->query("SELECT Count(suspended) FROM user ORDER BY 1 Desc");
$total= $Db1->num_rows();

$sql=$Db1->query("Select *  From user where suspended='1'");
$total=0;

if($Db1->num_rows() > 0) {
	for($x=0; $member=$Db1->fetch_array($sql); $x++) {
$total++;	
			$code="
			<tr  id=\"col$x\">
				
			<td height=21 nowrap=\"nowrap\">
					$member[username]
					
			</td('col$x')\">
			
				<td width=300>$member[suspendMsg]</td('col$x')\">				
			</tr>
				
			";
$ttotal.=$code;
}

}
$includes[content].="
".iif($total>0, "

<div class=\"ptcWrapper\">
		<table width=\"100%\" cellpadding=3 cellspacing=0 class=\"ptcList\">
	<tr>
	<th align=\"center\">Member</th>
	<th align=\"center\">Reason</th>
	</tr>

	$ttotal
	
		</table>
		</div>
		
		")."

";
?>