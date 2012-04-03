<?
$includes[title]="Advertising  Specials";

if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

$sql=$Db1->query("SELECT * FROM specials WHERE active='1' ORDER BY `order`");
for($x=0; $special=$Db1->fetch_array($sql); $x++) {
	if($x%2 == 0) {
		$list.="
		</tr>
		<tr>
			<td height=10></td>
		</tr>
		<tr>";
	}
	if($x%2 == 1) {
		$list.="<td></td>";
	}
	$feats="";
	$sql2=$Db1->query("SELECT * FROM special_benefits WHERE special='$special[id]' ORDER BY amount");
	while($temp=$Db1->fetch_array($sql2)) {
		if($temp[type] == "referrals") {
			$sql3=$Db1->query("SELECT userid FROM user WHERE refered='' ".iif($LOGGED_IN==true,"and username!='$username'")."");
			$totalrefsavailable=$Db1->num_rows();
			if($totalrefsavailable < $temp[amount]) {
				$temp[amount]=$totalrefsavailable;
			}
		}
		if($temp[amount] > 0) {
			$feats.="<li>".$temp[amount]."  ".$temp[title]." (	
				".iif($temp[type]=='link_credits',"<small><b>$cursym ".(($temp[amount]/1000)*($settings[base_price]*$settings[class_d_ratio])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='xcredits',"<small><b>$cursym ".(($temp[amount]/1000)*($settings[base_price]*$settings[x_ratio])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='popup_credits',"<small><b>$cursym ".(($temp[amount]/1000)*($settings[base_price]*$settings[popup_ratio])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='ptr_credits',"<small><b>$cursym ".(($temp[amount]/1000)*($settings[base_price]*$settings[ptr_ratio])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='ptra_credits',"<small><b>$cursym ".(($temp[amount]/1000)*($settings[base_price]*$settings[ptr_d_ratio])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='ptsu_credits',"<small><b>$cursym ".(($temp[amount]*$settings[ptsu_cost])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='fad_credits',"<small><b>$cursym ".(($temp[amount]/1000/$settings[fad_ratio]*$settings[base_price])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='banner_credits',"<small><b>$cursym ".(($temp[amount]/1000/$settings[banner_ratio]*$settings[base_price])+$settings[buy_fee])." Value</b></small>")."
				".iif($temp[type]=='fbanner_credits',"<small><b>$cursym ".(($temp[amount]/1000/$settings[fbanner_ratio]*$settings[base_price])+$settings[buy_fee])." Value</b></small>")."	
				".iif($temp[type]=='referrals',"<small><b>$cursym ".(($temp[amount]*$settings[referral_price])+$settings[buy_fee])." Value</b></small>")."
			)";
		}
	}
	$tpackages=explode(",",$special[packages]);
	$list.="
	<td valign=\"top\" ".iif($special[id] == $hl, " bgcolor=\"lightyellow\"")." style=\"border: 1px black solid;\" width=\"250\">
		<b style=\"color: darkred\">$special[title]</b><br />
		<li style=\"color: darkgreen\">$cursym ".($tpackages[0]*$special[price])."
		$feats<br /><br />
		<div align=\"right\"><input type=\"button\" value=\"Purchase Special\" onclick=\"location.href='index.php?view=account&ac=buywizard&step=2&ptype=special&id=$special[id]&".$url_variables."'\">
		</div>
	</td>";
}


$includes[content]="
<div align=\"center\">
<table cellpadding=5>
	<tr>
		$list
	</tr>
</table>
</div><br />


";

?>