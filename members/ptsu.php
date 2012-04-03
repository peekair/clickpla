<?
//##############################################
//#            AURORAGPT Script Copyright owned by Mike Pratt              #
//#                        ALL RIGHTS RESERVED 2007-2009                        #
//#                                                                                                 #
//#        Any illegal use of this script is strictly prohibited unless          # 
//#        permission is given by the owner of this script.  To sell          # 
//#        this script you must have a resellers license. Your site          #
//#        must also use a unique encrypted license key for your         #
//#        site. Your site must also have site_info module and             #
//#        key.php file must be in the script unedited. Otherwise         #
//#        it will be considered as unlicensed and can be shut down    #
//#        legally by Illusive Web Services. By using AuroraGPT       #
//#        script you agree not to copy infringe any of the coding     #
//#        and or create a clone version is also copy infringement   #
//#        and will be considered just that and legal action will be   #
//#        taken if neccessary.                                                    #
//#########################################//   
//**VS**//$setting[ptsu]//**VE**//
if($settings[ptsuon] == 1) {
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
if($type == "") 	$type="ASC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="title";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";



$sql=$Db1->query("SELECT * FROM ptsu_history WHERE username='$username'");
if($Db1->num_rows() != 0) {
	$temp=$Db1->fetch_array($sql);
	$preclicked=$temp[clicks];
}
if($preclicked == "") {
	$preclicked=":0:";
}

$totalptc=0;
$y=array(0,0);
$sql=$Db1->query("SELECT * FROM ptsuads WHERE credits>=1 and (country='' or country='$thismemberinfo[country]') and active='1' and (upgrade='0' ".iif($thismemberinfo[type]==1," or upgrade='1'").") ORDER BY $orderby $type");
if($Db1->num_rows() != 0) {
	for($x=0; $ad=$Db1->fetch_array($sql); $x++) {
		if(findclick($preclicked, $ad[id]) == 0) {
			$totalptc++;
			$y[($ad[featured]==1?1:0)]++;
			$temp="
				<tr id=\"col$x\"  class=\"zebra".(($y[($ad[featured] == 1?1:0)]%2==0)?"1":"2")."".iif($ad[featured]==1," featured")."\"> 
					<td style=\"padding: 5px 10px 5px 5px; width: 5px;\">".iif($ad['icon_on']==1 && $ad['icon']!="","<img src=\"adicons/".$ad['icon']."\" />")."</td>
					<td height=21 nowrap=\"nowrap\" style=\"padding-left: 10px\">
						<a href=\"index.php?view=account&ac=do_ptsu&id=$ad[id]&".$url_variables."\">
							".iif($ad[featured]==1,"<b>")."
							".parse_link(ucwords(strtolower(stripslashes($ad[title]))))."</b></a>
							".iif($ad['subtitle_on'] && $ad['subtitle']!="","<br/><em>".strtolower(html_entity_decode($ad['subtitle']))."</em>")."
						</td>
					<td width=100>".iif($ad['class']=="P","$ad[pamount] Points","$cursym $ad[pamount]")."</td>
				</tr>
			";
			if($ad[featured] == 1) {
				$adsptcF.=$temp;
			}
			else {
				$adsptc.=$temp;
			}
		}
	}
}

if($thismemberinfo[type] != 1 && $settings[showPremOnlyMsg]) {
	$sql = $Db1->query("SELECT COUNT(id)as total FROM ptsuads WHERE credits>=1 and active='1' and upgrade='1' ");
	$upgradeOnly = $Db1->fetch_array($sql);
	if($upgradeOnly[total] > 0) {
		$showmsg="<div style=\"background-color: pink; border: 1px solid red; margin: 10px;\">Upgrade to a premium account to access more advertisements. There are currently ".$upgradeOnly[total]." premium-only ads available!</div>";
	}
}


//**E**//

$includes[title]="Get Paid To Signup";
$includes[content].="
".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if your unable to use our member features!</div>")."
<div align=\"right\" style=\"font-size: 13px;\">
<a href=\"index.php?view=account&ac=ptsu_history&".$url_variables."\">View Offer Completion History & Stats</a>
</div>

".iif($totalptc>0, "
<table width=\"100%\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=\"left\">$totalptc Offers Available</td>
	</tr>
</table>

".iif($thismemberinfo[confirm] ==1,"

<div class=\"ptcWrapper\">
<table width=\"100%\" cellspacing=0 class=\"ptcList\">
	<tr>
		<th></th>
		<th><a href=\"index.php?view=account&ac=ptsu&orderby=title&type=$newtype&".$url_variables."\">Title".$order['title']."</a></th>
		<th width=100><a href=\"index.php?view=account&ac=ptsu&orderby=pamount&type=$newtype&".$url_variables."\">Earning".$order['pamount']."</a></th>
	</tr>
	$adsptcF
	$adsptc
</table>")."
</div>","
	<p>There are no PTSU offers available at this time.</p>
")."



$showmsg


";
}
else {
	$includes[content]="PTSU is currently disabled by admin!";
}

?>
