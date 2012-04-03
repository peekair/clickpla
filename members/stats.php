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
$includes[title]="Stats";
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

if($thismemberinfo[type] == 1) {
	$sql=$Db1->query("SELECT * FROM memberships WHERE id='$thismemberinfo[membership]'");
	$membership=$Db1->fetch_array($sql);
}


$includes[content]="


<div align=\"center\">
<div style=\"background-color: black; width: 550px;\">
<table cellpadding=3 cellspacing=1>
	<tr class=\"tableHL2\">
		<td width=300>Membership Type: </td>
		<td width=250>".iif($thismemberinfo[type]==1,$thetype,"Basic")." ".iif($thismemberinfo[type]!=0,$membership[title]." - Ends In  ".floor(($thismemberinfo[pend]-time())/24/60/60)." Days&nbsp;")."</td>
	</tr>
	<tr class=\"tableHL3\">
		<td>Balance: </td>
		<td>$cursym $thismemberinfo[balance]</td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Points: </td>
		<td>$thismemberinfo[points]</td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Exchange Credits: </td>
		<td>$thismemberinfo[xcredits]</td>
	</tr>
	<tr class=\"tableHL3\">
		<td>Link Credits: </td>
		<td>$thismemberinfo[link_credits]</td>
	</tr>
	<tr class=\"tableHL3\">
		<td>Email Credits: </td>
		<td>$thismemberinfo[ptr_credits]</td>
	</tr>
	<tr class=\"tableHL2\">
		<td>PTRA Credits</td>
		<td>$thismemberinfo[ptra_credits]</td>
	</tr>
	<tr class=\"tableHL2\">
		<td>PTSU Credits</td>
		<td>$thismemberinfo[ptsu_credits]</td>
	</tr>
	<tr class=\"tableHL3\">
		<td>Banner Credits: </td>
		<td>$thismemberinfo[banner_credits]</td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Featured Banner Credits: </td>
		<td>$thismemberinfo[fbanner_credits]</td>
	</tr>
	<tr class=\"tableHL3\">
		<td>Featured Ad Credits: </td>
		<td>$thismemberinfo[fad_credits]</td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Level 1 Referrals: </td>
		<td>$thismemberinfo[referrals1]</td>
	</tr>
	<tr class=\"tableHL3\">
		<td>Total Downline: </td>
		<td>".($thismemberinfo[referrals1]+$thismemberinfo[referrals2]+$thismemberinfo[referrals3]+$thismemberinfo[referrals4]+$thismemberinfo[referrals5])."</td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Downline Earnings: </td>
		<td>$cursym $thismemberinfo[referral_earns]</td>
	</tr>
	<tr class=\"tableHL3\">
		<td>Tickets</td>
		<td>$thismemberinfo[tickets]</td>
	</tr>
</table>
</div>
</div>
";
