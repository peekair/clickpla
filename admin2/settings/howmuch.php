<?
$includes[title]="Members By country";

$sql=$Db1->query("SELECT Count(country) FROM user ORDER BY 1 Desc");
$total= $Db1->num_rows();

$sql=$Db1->query("Select Count(country) as cantidad, country  From user Group by country Order by 1 Desc");
$total=0;

if($Db1->num_rows() > 0) {
	for($x=0; $pais=$Db1->fetch_array($sql); $x++) {
$total++;	
			$code="
			<tr  id=\"col$x\">
				
			<td height=21 nowrap=\"nowrap\">
					$pais[country]
					
			</td('col$x')\">
			
				<td width=60>$pais[cantidad]</td('col$x')\">				
			</tr>
				
			";
$ttotal.=$code;
}

}
$includes[content].="
".iif($total>0, "
	<table width=\"100%\" cellpadding=0 cellspacing=0>
		<tr>
		
			<td align=\"left\"><div align=\"left\">
<div class=\"ptcWrapper\">
		<table width=\"70%\" cellpadding=3 cellspacing=0 class=\"ptcList\">
	<tr>
	<th>Country</th>
	<th>Number of users</th>
	</tr>

	$ttotal
	
		</table>
		</div>
		
		")."

";
?>