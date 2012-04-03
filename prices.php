<?
$includes[title]="Purchase Advertising";
$temp_bogo = ($settings[bog_amount] - 1);
$temp_membership = ($settings[bogomembership] - 1);
$temp_refs = ($settings[bogorefs] - 1);
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$includes[content]="
".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if your unable to use our member features!</div>")."

<script type=\"text/javascript\">
function buylink() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.link.value+'&ptype=link&".$url_variables."'
}
function buyptsu() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptsu.value+'&ptype=ptsu&".$url_variables."'
}
function buyxcredits() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.xcredits.value+'&ptype=xcredits&".$url_variables."'
}
function buysurf() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.link.value+'&ptype=surf&".$url_variables."'
}
function buypopups() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.popups.value+'&ptype=popups&".$url_variables."'
}
function buyptr() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptr.value+'&ptype=ptr&".$url_variables."'
}
function buyptra() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptra.value+'&ptype=ptra&".$url_variables."'
}
function buyptrac() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptrac.value+'&ptype=ptrac&".$url_variables."'
}
function buyfbanner() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.fbanner.value+'&ptype=fbanner&".$url_variables."'
}
function buybanner() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.banner.value+'&ptype=banner&".$url_variables."'
}
function buyfad() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.fad.value+'&ptype=fad&".$url_variables."'
}
function buyflink() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.flink.value+'&ptype=flink&".$url_variables."'
}
function buyref() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.referrals.value+'&ptype=referrals&".$url_variables."'
}
function buyupgrade(id,amount) {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+amount+'&id='+id+'&ptype=upgrade&".$url_variables."'
}
function buyspecial(id,amount) {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+amount+'&id='+id+'&ptype=special&".$url_variables."'
}
</script>



".iif($settings[special_prices] == 1, "<div style=\"text-align: center\" align=\"center\">".advspecial()."</div>")."

<form name=\"form\">

<table width=\"100%\" cellspacing=0 class=\"priceTable\">
	<tr>
		<th colspan=3 class=\"top\">Advertising</b></th>
	</tr>";


if($temp_bogo > 0) {
	$includes[content].="
	<th colspan=3 ></b>Buy 1 Get $temp_bogo Free</th>
	";
}

if(($settings[sell_links] == 1) && (SETTING_PTC == true)) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=link&".$url_variables."\">Link Ad Hits</td>
		<td>
			<select name=\"link\">
				";
				for($x=0; $x<count($packages['link']); $x++) {
					$temp_price=($packages['link'][$x]*($settings[base_price]/1000)*$settings[class_d_ratio]);
					$includes[content].="<option value=\"".$packages['link'][$x]."\">".$packages['link'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		<td><input type=\"button\" onclick=\"buylink()\" value=\"Buy Now!\"></td>
	</tr>";
}



if(($settings[sell_ptsu] == 1) && (SETTING_PTSU == true)) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=ptsu&".$url_variables."\">Guaranteed Signups</td>
		<td>
			<select name=\"ptsu\">
				";
				for($x=0; $x<count($packages['ptsu']); $x++) {
					$temp_price=($packages['ptsu'][$x]*$settings[ptsu_cost]);
					$includes[content].="<option value=\"".$packages['ptsu'][$x]."\">".$packages['ptsu'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		<td><input type=\"button\" onclick=\"buyptsu()\" value=\"Buy Now!\"></td>
	</tr>";
}





if(($settings[sellpopups]==1) && (SETTING_PTP == true)) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=popups&".$url_variables."\">Ptp Hits</td>
		<td>
			<select name=\"popups\">
				";
				for($x=0; $x<count($packages['popups']); $x++) {
					$temp_price=($packages['popups'][$x]*($settings[base_price]/1000)*$settings[popup_ratio]);
					$includes[content].="<option value=\"".$packages['popups'][$x]."\">".$packages['popups'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		<td><input type=\"button\" onclick=\"buypopups()\" value=\"Buy Now!\"></td>
	</tr>
	";
}


if((SETTING_CE==true) && ($settings[sellce] == 1)) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=xcredits&".$url_variables."\">X-Credits</td>
		<td>
			<select name=\"xcredits\">
				";
				for($x=0; $x<count($packages['xcredits']); $x++) {
					$temp_price=($packages['xcredits'][$x]*($settings[base_price]/1000)*$settings[x_ratio]);
					$includes[content].="<option value=\"".$packages['xcredits'][$x]."\">".$packages['xcredits'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		<td><input type=\"button\" onclick=\"buyxcredits()\" value=\"Buy Now!\"></td>
	</tr>
	";
}




if(($settings[sellptr]==1) && (SETTING_PTR == true)) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=ptr&".$url_variables."\">Paid Email Hits</td>
		<td>
			<select name=\"ptr\">
				";
				for($x=0; $x<count($packages['ptr']); $x++) {
					$temp_price=($packages['ptr'][$x]*($settings[base_price]/1000)*$settings[ptr_ratio]);
					$includes[content].="<option value=\"".$packages['ptr'][$x]."\">".$packages['ptr'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		<td><input type=\"button\" onclick=\"buyptr()\" value=\"Buy Now!\"></td>
	</tr>
	";
}



if(($settings[sell_ptra] == 1) && (SETTING_PTRA == true)) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=ptra&".$url_variables."\">Paid To Read Hits</td>
		<td>
			<select name=\"ptra\">
				";
				for($x=0; $x<count($packages['ptra']); $x++) {
					$temp_price=($packages['ptra'][$x]*($settings[base_price]/1000)*$settings[ptr_d_ratio]);
					$includes[content].="<option value=\"".$packages['ptra'][$x]."\">".$packages['ptra'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		<td><input type=\"button\" onclick=\"buyptra()\" value=\"Buy Now!\"></td>
	</tr>
	";
}




if($settings[sellfad] == 1) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=fad&".$url_variables."\">Featured Ad Views</td>
		<td>
			<select name=\"fad\">
				";
				for($x=0; $x<count($packages['fad']); $x++) {
					$temp_price=($packages['fad'][$x]*($settings[base_price]/1000/$settings[fad_ratio]));
					$includes[content].="<option value=\"".$packages['fad'][$x]."\">".$packages['fad'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
			</td>
		<td><input type=\"button\" onclick=\"buyfad()\" value=\"Buy Now!\"></td>
	</tr>";
}


	if($settings[sellbanner] == 1) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=banner&".$url_variables."\">Banner Ad Views</a> <small><i>468x60</i></small></td>
		<td>
			<select name=\"banner\">
				";
				for($x=0; $x<count($packages['banner']); $x++) {
					$temp_price=($packages['banner'][$x]*($settings[base_price]/1000/$settings[banner_ratio]));
					$includes[content].="<option value=\"".$packages['banner'][$x]."\">".$packages['banner'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		</td>
		<td><input type=\"button\" onclick=\"buybanner()\" value=\"Buy Now!\"></td>
	</tr>";
}


	if($settings[sellfbanner] == 1) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=fbanner&".$url_variables."\">Featured Banner Ad Views</a> <small><i>180x100</i></small></td>
		<td>
			<select name=\"fbanner\">
				";
				for($x=0; $x<count($packages['fbanner']); $x++) {
					$temp_price=($packages['fbanner'][$x]*($settings[base_price]/1000/$settings[fbanner_ratio]));
					$includes[content].="<option value=\"".$packages['fbanner'][$x]."\">".$packages['fbanner'][$x]." - $cursym $temp_price";
				}
				$includes[content].="
			</select>
		</td>
		<td><input type=\"button\" onclick=\"buyfbanner()\" value=\"Buy Now!\"></td>
	</tr>";
}


	if($settings[sellflink] == 1) {
	$includes[content].="
	<tr>
		<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=flink&".$url_variables."\">Featured Link Rotation</td>
		<td>
			<select name=\"flink\">
				";
				for($x=0; $x<count($packages['flink']); $x++) {
					$temp_price=($packages['flink'][$x]*$settings[flink_cost]);
					$includes[content].="<option value=\"".$packages['flink'][$x]."\">".$packages['flink'][$x]." Month - $cursym $temp_price";
				}
				$includes[content].="
			</select>
			</td>
		<td><input type=\"button\" onclick=\"buyflink()\" value=\"Buy Now!\"></td>
	</tr>";
}



	$sql=$Db1->query("SELECT * FROM memberships WHERE active='1' ORDER by `order`");
	if($Db1->num_rows() > 0) {
		$includes[content].="

	<tr>
		<th colspan=3>Memberships</b></th>
	</tr>";
	if($temp_membership> 0) {
	$includes[content].="
	<th colspan=3 ></b>Buy 1 Get $temp_membership Free</th>
	";
}

		while($membership = $Db1->fetch_array($sql)) {
			$tpackages=explode(",",$membership[packages]);
			$includes[content].="
			<tr>
				<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=upgrade&id=$membership[id]&".$url_variables."\">$membership[title]</a> <small><a href=\"index.php?view=memberships&hl=$membership[id]&".$url_variables."\" style=\"color: darkblue\"> (Info)</a></small></td>
				<td>
					<select name=\"upgrade$membership[id]\">
						";
						for($x=0; $x<count($tpackages); $x++) {
							$temp_price=($tpackages[$x]*$membership['price']);
							$includes[content].="<option value=\"".$tpackages[$x]."\">".($tpackages[$x])." ".
								iif($membership[time_type]=="D","Day").
								iif($membership[time_type]=="W","Week").
								iif($membership[time_type]=="M","Month").
								iif($membership[time_type]=="Y","Year").
								iif($membership[time_type]=="L","Lifetime").
							" Membership - $cursym $temp_price";
						}
						$includes[content].="
					</select>
					</td>
				<td><input type=\"button\" onclick=\"buyupgrade($membership[id],document.form.upgrade$membership[id].value)\" value=\"Buy Now!\"></td>
			</tr>";
		}
	}

	$sql=$Db1->query("SELECT * FROM specials WHERE active='1' ORDER by `order`");
	if($Db1->num_rows() > 0) {
		$includes[content].="

	<tr>
		<th colspan=3>Specials</b></th>
	</tr>";
	if($temp_bogo> 0) {
	$includes[content].="
	<th colspan=3 ></b>Buy 1 Get $temp_bogo Free</th>
	";
}

		while($special = $Db1->fetch_array($sql)) {
			$tpackages=explode(",",$special[packages]);
			$includes[content].="
			<tr>
				<td><a href=\"index.php?view=account&ac=buywizard&step=2&ptype=special&id=$special[id]&".$url_variables."\">$special[title]</a> <small><a href=\"index.php?view=specials&hl=$special[id]&".$url_variables."\" style=\"color: darkblue\"> (Info)</a></small></td>
				<td>
					<select name=\"special$special[id]\">
						";
						for($x=0; $x<count($tpackages); $x++) {
							$temp_price=($tpackages[$x]*$special['price']);
							$includes[content].="<option value=\"".$tpackages[$x]."\">".($tpackages[$x])." Package - $cursym $temp_price";
						}
						$includes[content].="
					</select>
					</td>
				<td><input type=\"button\" onclick=\"buyspecial($special[id],document.form.special$special[id].value)\" value=\"Buy Now!\"></td>
			</tr>";
		}
	}

$includes[content].="
</table>
</form>

<script type=\"text/javascript\">
$(\".priceTable tr\").hover( function(){ $(this).addClass(\"selected\"); },function(){ $(this).removeClass(\"selected\"); } );
</script>

<br /><br />

<div align=\"center\">



".iif($settings[procs_egold]==1, "<a href=\"https://www.e-gold.com/newacct/newaccount.asp?cid=".$settings[pay_egold]."\" target=\"_blank\"><img src=\"images/egold.gif\" border=0></a>")."
".iif($settings[procs_paypal]==1, "<a href=\"https://www.paypal.com/affil/pal=".$settings[pay_paypal]."\" target=\"_blank\"><img src=\"images/paypal.gif\" border=\"0\" alt=\"I accept payment through PayPal!, the #1 online payment service!\"></a>")."
".iif($settings[procs_netpay]==1, "<a href=\"http://www.netpay.tv/cgi-bin/newacct.cgi?ref=$settings[pay_netpay]\" target=\"_blank\"><img src=\"images/netpay.gif\" border=\"0\"></a>")."
".iif($settings[procs_mb]==1, "<a href=\"https://www.moneybookers.com/app/?rid=$settings[mb_refid]\" target=\"_blank\"><img src=\"images/mb.gif\" border=\"0\"></a>")."
".iif($settings[procs_ap]==1, "<a href=\"https://www.alertpay.com/?$settings[ap_refid]\" target=\"_blank\"><img src=\"images/ap.gif\" border=\"0\"></a>")."
".iif($settings[procs_liberty]==1, "<a href=\"http://www.libertyreserve.com/?ref=?$settings[liberty_account]\" target=\"_blank\"><img src=\"images/liberty.gif\" border=\"0\"></a>")."
".iif($settings[procs_okpay]==1, "<a href=\"https://www.okpay.com/$settings[okpay_refid]\" target=\"_blank\"><img src=\"images/okpay.jpg\" border=\"0\"></a>")."
".iif($settings[procs_perfectm]==1, "<a href=\"https://perfectmoney.com/signup.html?ref=$settings[perfectm_refid]\" target=\"_blank\"><img src=\"images/pm.jpg\" border=\"0\"></a>")."
".iif($settings[procs_routepay]==1, "<a href=\"http://www.routepay.com/?ref=$settings[routepay_account]\" target=\"_blank\"><img src=\"images/rp.jpg\" border=\"0\"></a>")."

<p><b>All prices listed are before buy fee and processor fees are added!</b></p>
<p>Your first order must be manually approved, all your future orders thereafter will be instant.</p>

</div>
";
?>