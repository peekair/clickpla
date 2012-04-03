<?
$includes[title]="Purchase Advertising";
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$temp_refs = ($settings[bogrefs] - 1);
$includes[content]="<div align=\"center\">
<form name=\"form\">

<table width=\"100%\" cellspacing=0 class=\"priceTable\">
	<tr>
	
<script type=\"text/javascript\">function buyref() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.referrals.value+'&ptype=referrals&".$url_variables."'
}
</script>
";

if($settings[sell_referrals] == 1) {
		$includes[content].="
			<tr>
				<th colspan=3>Referrals</b></th>
			</tr>";
            	if($temp_refs> 0) {
	$includes[content].="
	<th colspan=3 ></b>Buy 1 Get $temp_refs Free</th>
	";
}


			$sql=$Db1->query("SELECT userid FROM user WHERE refered='' and username!='$username'");
			$totalrefsavailable=$Db1->num_rows();
			$includes[content].="<tr>
				<td>".iif($totalrefsavailable >= $packages['referrals'][0],"<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=referrals&".$url_variables."\">")."Referrals</td>
				<td>
						";
						if($totalrefsavailable >= $packages['referrals'][0]) {
							$includes[content].="<select name=\"referrals\">";
							for($x=0; ($x<count($packages['referrals'])) && ($totalrefsavailable >= $packages['referrals'][$x]); $x++) {
								$temp_price=@($packages['referrals'][$x]*$settings['referral_price']);
								$includes[content].="<option value=\"".$packages['referrals'][$x]."\">".$packages['referrals'][$x]." Referrals - $cursym $temp_price";
							}
							$includes[content].="</select>";
						}
						else {
							$includes[content].="No Referrals Available";
						}
						$includes[content].="
					</td>
				<td>".iif($totalrefsavailable >= $packages['referrals'][0],"<input type=\"button\" onclick=\"buyref()\" value=\"Buy Now!\">")."</td>
			</tr>
	</table>

			";
}

?>