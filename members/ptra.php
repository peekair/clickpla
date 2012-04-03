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
if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="pamount";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";



$clickHistory = loadClickHistory($username, "ptra");
$sql = $Db1->query("SELECT * FROM ptrads WHERE 
	credits>=1 
	and active=1
	and (country='' or country='{$thismemberinfo[country]}') 
	and (daily_limit>views_today or daily_limit=0)
	and (upgrade='0' ".($thismemberinfo[type]==1?" or upgrade='1'":"").")
	ORDER BY $orderby $type
");	

$totalptc=0;
if($Db1->num_rows() > 0) {
	for($x=0; $ad=$Db1->fetch_array($sql); $x++) {
		if(findclick($clickHistory, $ad['id']) == 0) {
			$totalptc++;
			$ptradsptc.="
			<tr  bgcolor=\"".iif($ad[bgcolor]!="","$ad[bgcolor]",($x%2==0)?"white":"#eeeeee")."\" id=\"col$x\">
				<td style=\"padding: 5px 10px 5px 5px; width: 5px;\">".iif($ad['icon_on']==1 && $ad['icon']!="","<img src=\"adicons/".$ad['icon']."\" />")."</td>
				<td height=21  nowrap=\"nowrap\">
					<a href=\"gpt.php?v=read&type=ptra&id=$ad[id]&".$url_variables."\" target=\"_blank\" onclick=\"clicked1('col$x')\">".parse_link(ucwords(strtolower(stripslashes($ad[title]))))."</a>
					".iif($ad['subtitle_on'] && $ad['subtitle']!="","<br/><em>".strtolower(html_entity_decode($ad['subtitle']))."</em>")."
				</td>
				<td width=100>$ad[timed] Seconds</td>
				<td width=100>".iif($ad['class']=="P","$ad[pamount] Points","$cursym $ad[pamount]")."</td>
				<td width=100>$ad[views]</td>
			</tr>
			";
		}
	}
}

if($thismemberinfo[type] != 1 && $settings[showPremOnlyMsg]) {
	$sql = $Db1->query("SELECT COUNT(id)as total FROM ptrads WHERE credits>=1 and (daily_limit>views_today or daily_limit=0) and upgrade='1' ");
	$upgradeOnly = $Db1->fetch_array($sql);
	if($upgradeOnly[total] > 0) {
		$showmsg="<div style=\"background-color: pink; border: 1px solid red; margin: 10px;\">Upgrade to a premium account to access more advertisements. There are currently ".$upgradeOnly[total]." premium-only ads available!</div>";
	}
}


//**E**//

$includes[title]="Get Paid To Read Ads";
$includes[content].="
".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if your unable to use our member features!</div>")."


".iif($totalptc>0, "
<table width=\"100%\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=\"left\">$totalptc Ads Available</td>
	</tr>
</table>


<script>
function clicked1(colid) {
	document.getElementById(colid).style.display='none';
	document.getElementById('refwarn').style.display='';
}
</script>


".iif($thismemberinfo[confirm] ==1,"
<div class=\"ptcWrapper\">
<table width=\"100%\" cellspacing=0 class=\"ptcList\">
	<tr>
		<th></th>
		<th><a href=\"index.php?view=account&ac=click&orderby=title&type=$newtype&".$url_variables."\">Title".$order['title']."</a></th>
		<th width=100><a href=\"index.php?view=account&ac=ptra&orderby=timed&type=$newtype&".$url_variables."\">Time".$order['timed']."</a></th>
		<th width=100><a href=\"index.php?view=account&ac=ptra&orderby=pamount&type=$newtype&".$url_variables."\">Earning".$order['pamount']."</a></th>
		<th width=100><a href=\"index.php?view=account&ac=ptra&orderby=views&type=$newtype&".$url_variables."\">Clicks".$order['views']."</a></th>
	</tr>
	$ptradsptc
</table>
</div>","
	<p>There Are Currently No Paid Ads Available!</p>
")."


$showmsg



<br /><br />

<b>Rules</b><br /><small>
You Can Only Read One Ad At A Time<br />
<b><font color=\"darkblue\">You MUST Click The Correct Button After The Timer Runs Out</font></b>
</small>")."

";


?>
