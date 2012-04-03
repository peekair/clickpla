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
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$includes[title]="Contests";

$purchcon[tic]=0;
$sql=$Db1->query("SELECT SUM(purchcon_tic) AS total FROM user");
$totalpurtic=$Db1->fetch_array($sql);
$purchcon[tic]+=$totalpurtic[total];

$sql=$Db1->query("SELECT week_refs FROM user WHERE username!='$username' ORDER BY week_refs DESC LIMIT 1");
$amtaway=$Db1->fetch_array($sql);

if($thismemberinfo[week_refs] < $amtaway[week_refs]) {
	$contestStatus="You Are <b>".($amtaway[week_refs]-$thismemberinfo[week_refs]+1)."</b> Referrals Away From Being First Place!";
}
if($thismemberinfo[week_refs] == $amtaway[week_refs]) {
	$sql=$Db1->query("SELECT COUNT(userid) as total FROM user WHERE week_refs='$amtaway[week_refs]' and username!='$username'");
	$temp=$Db1->fetch_array($sql);
	$contestStatus="You Are Currently Tied With <b>$temp[total]</b> Other Members! You Need One More Referral To Take First Place!";
}
if($thismemberinfo[week_refs] > $amtaway[week_refs]) {
	$contestStatus="<b><font color=\"darkblue\">You Are In The Top $settings[clickc_draw]!</font></b> Currently You Are Ahead By <b>".($thismemberinfo[week_refs]-$amtaway[week_refs])."</b> Referrals!";
}


$sql=$Db1->query("SELECT clickcon_clic FROM user WHERE username!='$username' ORDER BY clickcon_clic DESC LIMIT $settings[clickc_draw]");
$amtaway2=$Db1->fetch_array($sql);

if($thismemberinfo[clickcon_clic] < $amtaway2[clickcon_clic]) {
	$contestStatus2="You Are <b>".($amtaway2[clickcon_clic]-$thismemberinfo[clickcon_clic]+1)."</b> Click(s) Away From Being In The Top $settings[clickc_draw]!";
}
if($thismemberinfo[clickcon_clic] == $amtaway2[clickcon_clic]) {
	$sql=$Db1->query("SELECT COUNT(userid) as total FROM user WHERE clickcon_clic='$amtaway2[clickcon_clic]' and username!='$username'");
	$temp2=$Db1->fetch_array($sql);
	$contestStatus2="You Are Currently Tied With <b>$temp2[total]</b> Other Members! You Need More Click(s) To Stay In The Top $settings[clickc_draw]!";
}
if($thismemberinfo[clickcon_clic] > $amtaway2[clickcon_clic]) {
	$contestStatus2="<b><font color=\"darkblue\">You Are In The Top $settings[clickc_draw] !</font></b><br> Currently You Are Ahead By <b>".($thismemberinfo[clickcon_clic]-$amtaway2[clickcon_clic])."</b> Click(s)!";
}

if($settings[purchcon_time] == daily) $purchcontime="Daily";
if($settings[purchcon_time] == weekly) $purchcontime="Weekly";
if($settings[purchcon_time] == monthly) $purchcontime="Monthly";

if($settings[purchcon_time] == daily) $purchcontime2="Day";
if($settings[purchcon_time] == weekly) $purchcontime2="Week";
if($settings[purchcon_time] == monthly) $purchcontime2="Month";

if($settings[ref_contest_time] == daily) $refcontime="Daily";
if($settings[ref_contest_time] == weekly) $refcontime="Weekly";
if($settings[ref_contest_time] == monthly) $refcontime="Monthly";

if($settings[ref_contest_time] == daily) $refcontime2="Day";
if($settings[ref_contest_time] == weekly) $refcontime2="Week";
if($settings[ref_contest_time] == monthly) $refcontime2="Month";

if($settings[tickets_time] == daily) $ticketscontime="Daily";
if($settings[tickets_time] == weekly) $ticketscontime="Weekly";
if($settings[tickets_time] == monthly) $ticketscontime="Monthly";

if($settings[tickets_time] == daily) $ticketscontime2="Day";
if($settings[tickets_time] == weekly) $ticketscontime2="Week";
if($settings[tickets_time] == monthly) $ticketscontime2="Month";

if($settings[clickc_time] == daily) $clickctime="Daily";
if($settings[clickc_time] == weekly) $clickctime="Weekly";
if($settings[clickc_time] == monthly) $clickctime="Monthly";

if($settings[clickc_time] == daily) $clickctime2="Day";
if($settings[clickc_time] == weekly) $clickctime2="Week";
if($settings[clickc_time] == monthly) $clickctime2="Month";;

$includes[content]="

".iif($settings[purchcon_on] == 1,"
<h6>$purchcontime Purchase Contest</h6><br>
<p>Each $purchcontime2, $settings[purchcon_draw] entry(s) will be randomly chosen.<br> The member(s) who own the drawn entry(s) will receive as follows<br><br> 
<b>1st Place &nbsp;:&nbsp;
		".iif($settings[purchcon_type] == "balance","$cursym $settings[purchcon_amount] Cash")."
		".iif($settings[purchcon_type] == "points","$settings[purchcon_amount] Points")."
		".iif($settings[purchcon_type] == "link_credits","$settings[purchcon_amount] Link Credits")."
		".iif($settings[purchcon_type] == "banner_credits","$settings[purchcon_amount] Banner Credits")."
		".iif($settings[purchcon_type] == "fad_credits","$settings[purchcon_amount] Featured Ad Credits")."
		".iif($settings[purchcon_type] == "popup_credits","$settings[purchcon_amount] Popup Credits")."
		".iif($settings[purchcon_type] == "ptr_credits","$settings[purchcon_amount] Paid Email Credits")."
		".iif($settings[purchcon_type] == "ptr_credits","$settings[purchcon_amount] Paid To Read Credits")."
		".iif($settings[purchcon_type] == "fbanner_credits","$settings[purchcon_amount] Featured Banner Credits")."
<br>
</b>
".iif($settings[purchcon_draw] == 2,"
<b>2nd Place &nbsp;:&nbsp;
		".iif($settings[purchcon_type2] == "balance","$cursym $settings[purchcon_amount2] Cash")."
		".iif($settings[purchcon_type2] == "points","$settings[purchcon_amount2] Points")."
		".iif($settings[purchcon_type2] == "link_credits","$settings[purchcon_amount2] Link Credits")."
		".iif($settings[purchcon_type2] == "banner_credits","$settings[purchcon_amount2] Banner Credits")."
		".iif($settings[purchcon_type2] == "fad_credits","$settings[purchcon_amount2] Featured Ad Credits")."
		".iif($settings[purchcon_type2] == "popup_credits","$settings[purchcon_amount2] Popup Credits")."
		".iif($settings[purchcon_type2] == "ptr_credits","$settings[purchcon_amount2] Paid Email Credits")."
		".iif($settings[purchcon_type2] == "ptr_credits","$settings[purchcon_amount2] Paid To Read Credits")."
		".iif($settings[purchcon_type2] == "fbanner_credits","$settings[purchcon_amount2] Featured Banner Credits")."
<br>
</b>
")."
".iif($settings[purchcon_draw] == 3,"
<b>2nd Place &nbsp;:&nbsp;
		".iif($settings[purchcon_type2] == "balance","$cursym $settings[purchcon_amount2] Cash")."
		".iif($settings[purchcon_type2] == "points","$settings[purchcon_amount2] Points")."
		".iif($settings[purchcon_type2] == "link_credits","$settings[purchcon_amount2] Link Credits")."
		".iif($settings[purchcon_type2] == "banner_credits","$settings[purchcon_amount2] Banner Credits")."
		".iif($settings[purchcon_type2] == "fad_credits","$settings[purchcon_amount2] Featured Ad Credits")."
		".iif($settings[purchcon_type2] == "popup_credits","$settings[purchcon_amount2] Popup Credits")."
		".iif($settings[purchcon_type2] == "ptr_credits","$settings[purchcon_amount2] Paid Email Credits")."
		".iif($settings[purchcon_type2] == "ptr_credits","$settings[purchcon_amount2] Paid To Read Credits")."
		".iif($settings[purchcon_type2] == "fbanner_credits","$settings[purchcon_amount2] Featured Banner Credits")."
<br>
</b>
<b>3rd Place &nbsp;:&nbsp;
		".iif($settings[purchcon_type3] == "balance","$cursym $settings[purchcon_amount3] Cash")."
		".iif($settings[purchcon_type3] == "points","$settings[purchcon_amount3] Points")."
		".iif($settings[purchcon_type3] == "link_credits","$settings[purchcon_amount3] Link Credits")."
		".iif($settings[purchcon_type3] == "banner_credits","$settings[purchcon_amount3] Banner Credits")."
		".iif($settings[purchcon_type3] == "fad_credits","$settings[purchcon_amount3] Featured Ad Credits")."
		".iif($settings[purchcon_type3] == "popup_credits","$settings[purchcon_amount3] Popup Credits")."
		".iif($settings[purchcon_type3] == "ptr_credits","$settings[purchcon_amount3] Paid Email Credits")."
		".iif($settings[purchcon_type3] == "ptr_credits","$settings[purchcon_amount3] Paid To Read Credits")."
		".iif($settings[purchcon_type3] == "fbanner_credits","$settings[purchcon_amount3] Featured Banner Credits")."
<br>
</b>
")."
<br> At the end of the $purchcontime2 when the winners are drawn, all tickets will be removed<br>so every member starts with 0 Entrys at the beginning of each $purchcontime2.</p>


<table>
	<tr><th>How To Earn A Entry:</th></tr>
		".iif($settings[purchcon_buy] != "","<tr><td>For Each Purchase You Will Get</td><td>$settings[purchcon_buy] Entry(s)</td></tr>")."
</table>
<br>

<p>You Currently Have <b>$thismemberinfo[purchcon_tic]</b> Entry(s) Out of <b>$totalpurtic[total]</b> Entry(s)!</p>
<p>*Purchases Made With account Funds Do Not Count</p>

")."


".iif($settings[ref_contest_on] == 1,"
<h6>$refcontime Referral Contest</h6><br>
<p>Each $refcontime2 the top referring member will receive <b>
		".iif($settings[ref_contest_type] == "balance","$cursym $settings[ref_contest_amount] Cash")."
		".iif($settings[ref_contest_type] == "points","$settings[ref_contest_amount] Points")."
		".iif($settings[ref_contest_type] == "link_credits","$settings[ref_contest_amount] Link Credits")."
		".iif($settings[ref_contest_type] == "banner_credits","$settings[ref_contest_amount] Banner Credits")."
		".iif($settings[ref_contest_type] == "fad_credits","$settings[ref_contest_amount] Featured Ad Credits")."
		".iif($settings[ref_contest_type] == "popup_credits","$settings[ref_contest_amount] Popup Credits")."
		".iif($settings[ref_contest_type] == "ptr_credits","$settings[ref_contest_amount] Paid Email Credits")."
		".iif($settings[ref_contest_type] == "ptr_credits","$settings[ref_contest_amount] Paid To Read Credits")."
		".iif($settings[ref_contest_type] == "fbanner_credits","$settings[ref_contest_amount] Featured Banner Credits")."
</b>
</p>

<p>All you have to do is promote your <a href=\"index.php?view=account&ac=banners&".$url_variables."\">Referral URL</a> to start getting referrals today!</p>

<p>
			You Currently Have <b>$thismemberinfo[week_refs]</b> Referrals For Our $refcontime Contest!<br />
			<small>$contestStatus</small>
</p>

")."

".iif($settings[tickets_on] == 1,"
<h6>$ticketscontime Ticket Drawing</h6><br>
<p>Each $ticketscontime2, $settings[tickets_draw] tickets will be randomly chosen. The members who own the drawn tickets will receive <b>
		".iif($settings[tickets_win_type] == "balance","$cursym $settings[tickets_win_amount] Cash")."
		".iif($settings[tickets_win_type] == "points","$settings[tickets_win_amount] Points")."
		".iif($settings[tickets_win_type] == "link_credits","$settings[tickets_win_amount] Link Credits")."
		".iif($settings[tickets_win_type] == "banner_credits","$settings[tickets_win_amount] Banner Credits")."
		".iif($settings[tickets_win_type] == "fad_credits","$settings[tickets_win_amount] Featured Ad Credits")."
		".iif($settings[tickets_win_type] == "popup_credits","$settings[tickets_win_amount] Popup Credits")."
		".iif($settings[tickets_win_type] == "ptr_credits","$settings[tickets_win_amount] Paid Email Credits")."
		".iif($settings[tickets_win_type] == "ptr_credits","$settings[tickets_win_amount] Paid To Read Credits")."
		".iif($settings[tickets_win_type] == "fbanner_credits","$settings[tickets_win_amount] Featured Banner Credits")."
</b>. At the end of the $ticketscontime2 when the winners are drawn, all tickets will be removed so every member starts with 0 tickets at the beginning of each week.</p>


<table>
	<tr><th>How To Earn Tickets:</th></tr>
		".iif($settings[tickets_ptc] != "" && (SETTING_PTC == true),"<tr><td>Click A Paid Link: </td><td>$settings[tickets_ptc]</td></tr>")."
		".iif($settings[tickets_xclick] != "" && (SETTING_CE == true),"<tr><td>Surf An Exchange Site: </td><td>$settings[tickets_xclick]</td></tr>")."
		".iif($settings[tickets_ptr] != "" && (SETTING_PTR == true),"<tr><td>Read A Paid Email: </td><td>$settings[tickets_ptr]</td></tr>")."
		".iif($settings[tickets_ptra] != "" && (SETTING_PTRA == true),"<tr><td>Read A Paid Ad: </td><td>$settings[tickets_ptra]</td></tr>")."
		".iif($settings[tickets_ref] != "","<tr><td>Refer A Member: </td><td>$settings[tickets_ref]</td></tr>")."
		".iif($settings[tickets_buy] != "","<tr><td>Purchase Item: </td><td>$settings[tickets_buy]</td></tr>")."
</table>


<p>You Currently Have <b>$thismemberinfo[tickets]</b> Tickets!</p>


")."
".iif($settings[clickc_on] == 1,"
<hr>
<h6>$clickctime Click Contest</h6><br>
Each $clickctime2,The top $settings[clickc_draw] clickers will be awarded<b>
		".iif($settings[clickc_type] == "balance","$cursym $settings[clickc_amount] Cash")."
		".iif($settings[clickc_type] == "points","$settings[clickc_amount] Points")."
		".iif($settings[clickc_type] == "link_credits","$settings[clickc_amount] Link Credits")."
		".iif($settings[clickc_type] == "banner_credits","$settings[clickc_amount] Banner Credits")."
		".iif($settings[clickc_type] == "fad_credits","$settings[clickc_amount] Featured Ad Credits")."
		".iif($settings[clickc_type] == "popup_credits","$settings[clickc_amount] Popup Credits")."
		".iif($settings[clickc_type] == "ptr_credits","$settings[clickc_amount] Paid Email Credits")."
		".iif($settings[clickc_type] == "ptr_credits","$settings[clickc_amount] Paid To Read Credits")."
		".iif($settings[clickc_type] == "fbanner_credits","$settings[clickc_amount] Featured Banner Credits")."
		".iif($settings[clickc_type] == "game_points","$settings[clickc_amount] Game Points")."
		".iif($settings[tickets_win_type] == "game_points","$settings[tickets_win_amount] Game Points")."
</b>. At the end of the $clickctime2 when the winners are credited, all clicks will be removed so every member starts with 0 clicks at the beginning of each $clickctime2.<br>
<br>
All you have to do is click some ads in our <a href=\"index.php?view=account&ac=click&".$url_variables."\">PTC SECTION</a> to win!
<br><br>

<div class=\"tableHL2\" style=\"text-align: right;\">
			You Currently Have <b>$thismemberinfo[clickcon_clic]</b> Click(s) For Todays Contest!<br>
			<small>$contestStatus2</small>
</div>


")."
";
?>
