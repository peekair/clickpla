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
//**VS**//$setting[ptc]//**VE**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if($settings[ptcon] == 1) {
//**S**//
if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="pamount";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";


$totalptc=0;
$y=0;
if(!$LOGGED_IN) {

$sql = $Db1->query("SELECT * FROM ads WHERE 
	 credits>=1 
	and active=1
	and (country='' or country='{$thismemberinfo[country]}') 
	and (daily_limit>views_today or daily_limit=0)
	and (upgrade='' or upgrade='1')
	ORDER BY $orderby $type
");	
$totalptc = $Db1->num_rows();
}

if($LOGGED_IN) {
/*
$sql = $Db1->query("SELECT * FROM ads WHERE 
	NOT EXISTS (SELECT * FROM click_history WHERE click_history.type='ptc' AND click_history.username='{$username}' AND click_history.ad_id=ads.id)
	and credits>=1 
	and active=1
	and (country='' or country='{$thismemberinfo[country]}') 
	and (daily_limit>views_today or daily_limit=0)
	and (upgrade='0' ".($thismemberinfo[type]==1?" or upgrade='1'":"").")
	ORDER BY $orderby $type
");	
$totalptc = $Db1->num_rows();
*/
$clickHistory = loadClickHistory($username, "ptc");


$sql = $Db1->query("SELECT * FROM ads WHERE
        credits>=1
        and active=1
        and (country='' or country='{$thismemberinfo[country]}')
        and (daily_limit>views_today or daily_limit=0)
        and username!='$username'
        and (upgrade='0' ".($thismemberinfo[type]==1?" or upgrade='1'":"").")
        ORDER BY $orderby $type
"); 	
}
$totalptc=0;
if($Db1->num_rows() > 0) {
	for($x=0; $ad=$Db1->fetch_array($sql); $x++) {
		if(findclick($clickHistory, $ad['id']) == 0) {
			$totalptc++;
			$tempcode="
			<tr  id=\"col$x\" ".iif($ad[bgcolor]!="","style=\"background-color: $ad[bgcolor] !important;\" class=\"adHighlighted\" ","class=\"zebra".(($x%2==1)?"1":"2")."\"").">
				<td style=\"padding: 5px 10px 5px 5px; width: 5px;\">".iif($ad['icon_on']==1 && $ad['icon']!="","<img src=\"adicons/".$ad['icon']."\" />")."".iif($ad['icon_on']==0 ,".")."</td>
				<td height=21 nowrap=\"nowrap\">
				<a href=\"gpt.php?v=entry&type=ptc&id=$ad[id]&".$url_variables."\" target=\"_blank\" onclick=\"clicked1('col$x')\">".parse_link(ucwords(strtolower(stripslashes($ad[title]))))."<br> ".iif($ad['targetban']!="","<img src=\"$ad[targetban]\"width=\"300\" border=\"0\">")."".iif($ad['targetban']==0 ,".")."</a>
					".iif($ad['subtitle_on'] && $ad['subtitle']!="","<br/><em>".strtolower(html_entity_decode($ad['subtitle']))."</em>")."
				</td>
				<td width=50>$ad[timed] Sec.</td>
				<td width=60>".iif($ad['class']=="P","$ad[pamount] Points","$cursym $ad[pamount]")."</td>
				<td width=60>$ad[views]</td>
				<td width=60>$ad[oviews]</td>
				</tr>
			";
			if($ad[upgrade] == 1) $adsptc2.=$tempcode;
			else $adsptc.=$tempcode;
		}
	}
}

if($thismemberinfo[type] != 1 && $settings[showPremOnlyMsg]) {
	$sql = $Db1->query("SELECT COUNT(id)as total FROM ads WHERE credits>=1 and active='1' and (daily_limit>views_today or daily_limit=0) and upgrade='1' ");
	$upgradeOnly = $Db1->fetch_array($sql);
	if($upgradeOnly[total] > 0) {
		$showmsg="<div style=\"background-color: pink; border: 1px solid red; margin: 10px;\">Upgrade to a premium account to access more advertisements. There are currently ".$upgradeOnly[total]." premium-only ads available!</div>";
	}
}




$includes[title]="Get Paid To Click";

$includes[content].="
".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if your unable to use our member features!</div>")."

<script>
function clicked1(colid) {
	document.getElementById(colid).style.display='none';
	document.getElementById('refwarn').style.display='';
}
</script>

".iif($totalptc>0, "
	<table width=\"100%\" cellpadding=0 cellspacing=0>
		<tr>
			<td align=\"left\">$totalptc Links Available To Click</td><td align=\"right\"><div align=\"right\">
".iif($settings[surfalllinks],"<a href=\"gpt.php?v=entry&type=ptc&s=1&".$url_variables."\" style=\"font-size: 15pt;\">Surf These Links</a>")." &nbsp;&nbsp;&nbsp;&nbsp;</div></td>
		</tr>
	</table>

".iif($thismemberinfo[confirm] == 1,"
	".iif($settings[ptc_list],"
		<div class=\"ptcWrapper\">
		<table width=\"100%\" cellpadding=3 cellspacing=0 class=\"ptcList\">
			<tr>
				<th>.</th>
				<th><a href=\"index.php?view=account&ac=click&orderby=title&type=$newtype&".$url_variables."\">Title".$order['title']."</a></th>
				<th width=50><a href=\"index.php?view=account&ac=click&orderby=timed&type=$newtype&".$url_variables."\">Time".$order['timed']."</a></th>
				<th width=40><a href=\"index.php?view=account&ac=click&orderby=pamount&type=$newtype&".$url_variables."\">Earning".$order['']."</a></th>
				<th width=60><a href=\"index.php?view=account&ac=click&orderby=pamount&type=$newtype&".$url_variables."\">Members".$order['']."</a></th>
				<th width=60><a href=\"index.php?view=account&ac=click&orderby=pamount&type=$newtype&".$url_variables."\">Outside".$order['']."</a></th>
				</tr>
			$adsptc2
			$adsptc
		</table>
		</div>
		$showmsg
	
")."

	<p>
	<b>Rules</b><br />
	<small>You Can Only Visit One Site At A Time<br />
	<strong>You MUST Click The Correct Button After The Timer Runs Out</strong></small>
	</p>

","<p>There are no links available to click!</p>")."
")."
";
}
else {
	$includes[content]="PTC is currently disabled by admin!";
}

?>