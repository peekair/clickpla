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
$specialPTP=true;

//$includes[title]="My Account";
$includes[title]="My Account Panel - ".$thismemberinfo[name];

if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
//**S**//

if(SETTING_PTC == true && $settings[ptcon] == 1) {
	$clickHistory = loadClickHistory($username, "ptc");
	$sql = $Db1->query("SELECT id FROM ads WHERE 
		credits>=1 
		and active=1
		and (country='' or country='{$thismemberinfo[country]}') 
		and (daily_limit>views_today or daily_limit=0)
		and (upgrade='0' ".($thismemberinfo[type]==1?" or upgrade='1'":"").")
	");	
	$totalptc=0;
	while($ad=$Db1->fetch_array($sql)) {
		if(findclick($clickHistory, $ad['id']) == 0) $totalptc++;
	}
}

//and username!='$username'
if(SETTING_CE == true && $settings[ce_on] == 1) {
	$clickHistory = loadClickHistory($username, "ce");
	$sql = $Db1->query("SELECT id FROM xsites WHERE 
		credits>=1 
		and active=1
		and (country='' or country='{$thismemberinfo[country]}') 
		and (daily_limit>views_today or daily_limit=0)
		and (upgrade='0' ".($thismemberinfo[type]==1?" or upgrade='1'":"").")
	");	
	$totalce=0;
	while($ad=$Db1->fetch_array($sql)) {
		if(findclick($clickHistory, $ad['id']) == 0) $totalce++;
	}
}

if(SETTING_PTRA == true && $settings[ptraon] == 1) {
	$clickHistory = loadClickHistory($username, "ptra");
	$sql = $Db1->query("SELECT id FROM ptrads WHERE 
		credits>=1 
		and active=1
		and (country='' or country='{$thismemberinfo[country]}') 
		and (daily_limit>views_today or daily_limit=0)
		and (upgrade='0' ".($thismemberinfo[type]==1?" or upgrade='1'":"").")
	");	
	$totalptra=0;
	while($ad=$Db1->fetch_array($sql)) {
		if(findclick($clickHistory, $ad['id']) == 0) $totalptra++;
	}
}


if(SETTING_PTSU == true && $settings[ptsuon] == 1) {
	$sql=$Db1->query("SELECT * FROM ptsu_history WHERE username='$username'");
	if($Db1->num_rows() != 0) {
		$temp=$Db1->fetch_array($sql);
		$preclicked=$temp[clicks];
	}
	if($preclicked == "") {
		$preclicked=":0:";
	}
	$totalptsu=0;
	$sql=$Db1->query("SELECT * FROM ptsuads WHERE credits>=1 and (country='' or country='$thismemberinfo[country]') and active='1' and (upgrade='0' ".iif($thismemberinfo[type]==1," or upgrade='1'").")");
	if($Db1->num_rows() != 0) {
		for($x=0; $ad=$Db1->fetch_array($sql); $x++) {
			if(findclick($preclicked, $ad[id]) == 0) {
				$totalptsu++;
			}
		}
	}
}

// You can also earn stage level bonuses after surfing X pages. <a href=\"index.php?view=account&ac=stage_info&".$url_variables."\">Click Here</a> to view stage earnings and to learn more.


if($settings[showPremOnlyMsg]) {
	$sql = $Db1->query("SELECT COUNT(id)as total FROM ads WHERE credits>=1 and active='1' and (daily_limit>views_today or daily_limit=0) and upgrade='1' ");
	$upgradeOnly = $Db1->fetch_array($sql);
	$uptotal+=$upgradeOnly[total];

	$sql = $Db1->query("SELECT COUNT(id)as total FROM ptsuads WHERE credits>=1 and active='1' and upgrade='1' ");
	$upgradeOnly = $Db1->fetch_array($sql);
	$uptotal+=$upgradeOnly[total];

	$sql = $Db1->query("SELECT COUNT(id)as total FROM ptrads WHERE credits>=1 and (daily_limit>views_today or daily_limit=0) and upgrade='1' ");
	$upgradeOnly = $Db1->fetch_array($sql);
	$uptotal+=$upgradeOnly[total];

	$sql = $Db1->query("SELECT COUNT(id)as total FROM xsites WHERE credits>=1 and (daily_limit>views_today or daily_limit=0) and upgrade='1' ");
	$upgradeOnly = $Db1->fetch_array($sql);
	$uptotal+=$upgradeOnly[total];

	if($uptotal > 0) {
		if($thismemberinfo[type] != 1) $showmsg="<div style=\"background-color: pink; border: 1px solid red; margin: 10px;\">Upgrade to a premium account to access more advertisements. There are currently ".$uptotal." premium-only ads available!</div>";
		if($thismemberinfo[type] == 1) $showmsg="<div style=\"background-color: lightgreen; border: 1px solid green; margin: 10px;\">You are a premium member! There are currently ".$uptotal." premium-only ads in the system!</div>";
	}
}


//**VS**//$setting[ptc]//**VE**//
if($settings[ptcon] == 1) {
//**S**//
if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="pamount";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";


$totalptc=0;
$y=0;

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
	and (upgrade='0' ".($thismemberinfo[type]==1?" or upgrade='1'":"").")
	ORDER BY $orderby $type
");	

$totalptc=0;
if($Db1->num_rows() > 0) {
	for($x=0; $ad=$Db1->fetch_array($sql); $x++) {
		if(findclick($clickHistory, $ad['id']) == 0) {
			$totalptc++;
			$tempcode="
				<tr  id=\"col$x\" ".iif($ad[bgcolor]!="","style=\"background-color: $ad[bgcolor] !important;\" class=\"adHighlighted\" ","class=\"zebra".(($x%2==1)?"1":"2")."\"").">
					<td style=\"padding: 5px 10px 5px 5px; width: 5px;\">".iif($ad['icon_on']==1 && $ad['icon']!="","<img src=\"adicons/".$ad['icon']."\" />")."</td>
					<td height=21 nowrap=\"nowrap\">
						<a href=\"gpt.php?v=entry&type=ptc&id=$ad[id]&".$url_variables."\" target=\"_blank\" onclick=\"clicked1('col$x')\">".parse_link(ucwords(strtolower(stripslashes($ad[title]))))."</a>
						".iif($ad['subtitle_on'] && $ad['subtitle']!="","<br/><em>".strtolower(html_entity_decode($ad['subtitle']))."</em>")."
					</td>
					<td width=100>$ad[timed] Seconds</td>
					<td width=100>".iif($ad['class']=="P","$ad[pamount] Points","$cursym $ad[pamount]")."</td>
					<td width=100>$ad[views]</td>
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

//**E**//
//iif($totalptc>0,"<div style=\"height: ".iif($totalptc < 8,($totalptc*22+1),170)."; overflow: auto; border: 1px solid gray;\">").
//	.iif($totalptc>0,"<div style=\"".iif($totalptc > 8,"height: 500px; overflow: auto;")."  border: 1px solid gray;\">")."


//**S**//
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

$includes[content]="
".iif($error_msg,"<script>alert('$error_msg');".iif($foward,"location.href='$foward';")."</script>")."




<script>
function deselectAllHeaders() {
	var headerList = document.getElementById('dropBoxHeaderCont').getElementsByTagName(\"div\");
	for (var i=0; i<headerList.length; i++)	{
		if(headerList[i].className == 'dropBoxHeaderSelected') {
			headerList[i].className='dropBoxHeader';
		}
	}


	var boxList = document.getElementById('dropBoxContMain').getElementsByTagName(\"div\");
	for (var i=0; i<boxList.length; i++)	{
		if(boxList[i].className == 'dropBoxCont') {
			boxList[i].style.display='none';
		}
	}


}



<script>
function deselectAllHeaders() {
	var headerList = document.getElementById('dropBoxHeaderCont').getElementsByTagName(\"div\");
	for (var i=0; i<headerList.length; i++)	{
		if(headerList[i].className == 'dropBoxHeaderSelected') {
			headerList[i].className='dropBoxHeader';
		}
	}


	var boxList = document.getElementById('dropBoxContMain').getElementsByTagName(\"div\");
	for (var i=0; i<boxList.length; i++)	{
		if(boxList[i].className == 'dropBoxCont') {
			boxList[i].style.display='none';
		}
	}


}


function loadDropBox(rel) {
	deselectAllHeaders()
	document.getElementById('dropBoxHeader'+rel).className='dropBoxHeaderSelected'
	document.getElementById('earn'+rel).style.display='block';
}
</script>

<table width=\"570\" height=\"600\" cellspacing=5 cellpadding=0 align=\"center\">
	<tr>
		<td width=\"155\" valign=\"top\">
			<div id=\"dropBoxHeaderCont\">
				<div id=\"dropBoxHeaderAccount\" class=\"dropBoxHeader\"><img src=\"images/icons/about.gif\"/> <a href=\"\" onclick=\"loadDropBox('click'); return true;\">Paid to click</a></div>
				<div id=\"dropBoxHeaderPref\" class=\"dropBoxHeader\"><img src=\"images/icons/preferences.gif\"/> <a href=\"\" onclick=\"loadDropBox('Ptrad'); return true;\">PTR Ads</a></div>
<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/mail.gif\"/><a href=\"\" onclick=\"loadDropBox('earn'); return true;\">Earn Section</a></div>

				</div>

				</div>
		</td>

			</div>
		</td>
		<td valign=\"top\">
			<div class=\"earn\">
			<div style=\" padding: 5px;\" id=\"dropBoxContMain\">


					<div id=\"earn\" class=\"dropBoxCont\">
					
$showmsg

<dl>

".iif(SETTING_PTC == true && $settings[ptcon] == 1,"
<li><b><a href=\"index.php?view=account&ac=click&".$url_variables."\">Click Links</a></b>&nbsp;&nbsp;&nbsp;<font color=\"red\">$totalptc Links Available</font><br />
<menu>Click links and view websites to earn cash and points.</menu>
<br />")."

".iif(SETTING_PTRA == true && $settings[ptraon] == 1,"
<li><b><a href=\"index.php?view=account&ac=ptra&".$url_variables."\">Read Ads</a></b>&nbsp;&nbsp;&nbsp;<font color=\"red\">$totalptra Ads Available</font><br />
<menu>Read advertisments and view websites for cash and points.</menu>
<br />")."

".iif(SETTING_PTSU == true && $settings[ptsuon] == 1,"
<li><b><a href=\"index.php?view=account&ac=ptsu&".$url_variables."\">Paid To Signup</a></b>&nbsp;&nbsp;&nbsp;<font color=\"red\">$totalptsu Signups Available</font><br />
<menu>Get paid to signup at websites!</menu>
<br />")."

".iif(SETTING_CE == true && $settings[ce_on] == 1,"
<li><b><a href=\"gpt.php?v=entry&type=ce&s=1&".$url_variables."\" target=\"_blank\">Click Exchange</a></b>&nbsp;&nbsp;&nbsp;<font color=\"red\">$totalce Links Available</font><br />
<menu>The click exchange allows you to click for unique traffic rather than cash. When you click, you will receive a $settings[ce_ratio1]/$settings[ce_ratio2] ratio, meaning you will get $settings[ce_ratio2] unique hits for every $settings[ce_ratio1] links you click

</menu>
<br />")."


".iif(SETTING_PTR == true && $settings[ptron]==1,"
<li><b><a href=\"index.php?view=account&ac=profile&".$url_variables."\">Read Emails</a></b><br />
<menu>Read emails and view websites for cash and points.<br />
View your profile to opt-in for receiving paid emails.</menu>
<br />")."

".iif(SETTING_PTP == true && $settings[ptpon]==1,"
<li><b><a href=\"index.php?view=account&ac=banners&".$url_variables."\">Promote $settings[site_title]</a></b><br />
<menu>Promote the site and get paid $cursym $settings[ptpamount] for each unique visitor that views your referral URL per 24 hours. <a href=\"index.php?view=memberships&".$url_variables."\">Premium Members Earn More!</a>
</menu>
<br />")."

<li><b><a href=\"index.php?view=account&ac=banners&".$url_variables."\">Upgrade & Refer Members</a></b><br />
<menu>When you are an upgraded member, you get cash bonus's whenever any of your direct referrals purchase an item from our site, upgrade, or just earn money themselves. Upgrade today and have others work for you!</menu>
<br />



</dl>
								</td>
							</tr>
						</table>

					</div>





;



			

							</td>
							</tr>
						</table>

					</div>














		</div>

				

			</div>
		</td>
		<td valign=\"top\">
			<div class=\"Ptrad\">
			<div style=\" padding: 5px;\" id=\"dropBoxContMain\">


					<div id=\"Ptrad\" class=\"dropBoxCont\">
					
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
</small>
							</tr>




						</table>



					</div>

				


			</div>
			</div>
		</td>
	</tr>
</table>

<div style=\"clear: both;\"></div>

<script>

loadDropBox('$grabHeader');

</script>


";
}
?>
