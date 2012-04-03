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
$includes[title]="Member Settings";
//**S**//
if($action == "clear") {
	$Db1->query("Update user set lbref='0'");
	print "Test - It does hit";
}
if(($action == "save") && ($working == 1)) {

$settings["ref_contest_on"]		=	"$ref_contest_on";
$settings["ref_contest_amount"]	=	"$ref_contest_amount";
$settings["ref_contest_type"]	=	"$ref_contest_type";
$settings["ref_contest_time"]	=	"$ref_contest_time";
$settings["tickets_on"]			=	"$tickets_on";
$settings["tickets_ptc"]		=	"$tickets_ptc";
$settings["tickets_ptr"]		=	"$tickets_ptr";
$settings["tickets_ptra"]		=	"$tickets_ptra";
$settings["tickets_ptsu"]		=	"$tickets_ptsu";
$settings["tickets_ref"]		=	"$tickets_ref";
$settings["tickets_buy"]		=	"$tickets_buy";
$settings["tickets_win_type"]	=	"$tickets_win_type";
$settings["tickets_win_amount"]	=	"$tickets_win_amount";
$settings["tickets_draw"]		=	"$tickets_draw";
$settings["tickets_time"]		=	"$tickets_time";
$settings["tickets_xclick"]		=	"$tickets_xclick";
$settings["purchcon_on"]		=	"$purchcon_on";
$settings["purchcon_time"]		=	"$purchcon_time";
$settings["purchcon_draw"]		=	"$purchcon_draw";
$settings["purchcon_type"]		=	"$purchcon_type";
$settings["purchcon_buy"]		=	"$purchcon_buy";
$settings["purchcon_amount"]		=	"$purchcon_amount";
$settings["purchcon_type2"]		=	"$purchcon_type2";
$settings["purchcon_amount2"]		=	"$purchcon_amount2";
$settings["purchcon_type3"]		=	"$purchcon_type3";
$settings["purchcon_amount3"]		=	"$purchcon_amount3";
$settings["clickc_on"]		=	"$clickc_on";
$settings["clickc_time"]		=	"$clickc_time";
$settings["clickc_amount"]	=	"$clickc_amount";
$settings["clickc_type"]	=	"$clickc_type";
$settings["clickc_draw"]		=	"$clickc_draw";

include("admin2/settings/update.php");
updatesettings($settings);

	
//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=contest&saved=1&".$url_variables."");
}
if($settings[purchcon_time] == daily) $purchcontime="Daily";
if($settings[purchcon_time] == weekly) $purchcontime="Weekly";
if($settings[purchcon_time] == monthly) $purchcontime="Monthly";

if($settings[ref_contest_time] == daily) $refcontime="Daily";
if($settings[ref_contest_time] == weekly) $refcontime="Weekly";
if($settings[ref_contest_time] == monthly) $refcontime="Monthly";

if($settings[clickc_time] == daily) $ticketstime="Daily";
if($settings[clickc_time] == weekly) $ticketscontime="Weekly";
if($settings[clickc_time] == monthly) $ticketscontime="Monthly";

if($settings[clickc_time] == daily) $clickctime="Daily";
if($settings[clickc_time] == weekly) $clickctime="Weekly";
if($settings[clickc_time] == monthly) $clickctime="Monthly";

$includes[content]="
<table width=\"100%\">

<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
<tr class=\"tableHL1\">
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt;\">Clear Contest leader Board</font></b></td>
</tr>
<tr>
	<td width=\"250\">This tool will Clear Leader Boards For Contests<br>

<form action=\"admin.php?view=admin&ac=settings&action=clear&type=contest&".$url_variables."\" method=\"post\" name=\"form\"><input type=\"submit\" value=\"Clear\">
</form></td>

</tr>
</table>
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=contest&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">

<table width=\"100%\">





<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>	
<tr class=\"tableHL1\">
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt;\">$purchcontime Purchase Contest</font></b></td>
	</tr>
	<tr>
		<td width=\"250\"><b>$purchcontime Purchase Contest: </b></td>
		<td><input type=\"checkbox\" name=\"purchcon_on\" value=\"1\"".iif($settings[purchcon_on] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Contest Length:</b></td>
		<td>
			<select name=\"purchcon_time\">
				<option value=\"daily\"".iif($settings[purchcon_time] == "daily","selected=\"selected\"").">Daily
				<option value=\"weekly\"".iif($settings[purchcon_time] == "weekly","selected=\"selected\"").">Weekly
				<option value=\"monthly\"".iif($settings[purchcon_time] == "monthly","selected=\"selected\"").">Monthly
				</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Winners To Draw:</b></td>
		<td>
		<select name=\"purchcon_draw\">
			<option value=\"1\"".iif($settings[purchcon_draw] == "1","selected=\"selected\"").">1
			<option value=\"2\"".iif($settings[purchcon_draw] == "2","selected=\"selected\"").">2
			<option value=\"3\"".iif($settings[purchcon_draw] == "3","selected=\"selected\"").">3
			</select>
		</td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>1st Place Winnings:</b></td>
		<td>
			<select name=\"purchcon_type\">
				<option value=\"balance\"".iif($settings[purchcon_type] == "balance","selected=\"selected\"").">Cash
				".iif($settings[points]==1,"<option value=\"points\"".iif($settings[purchcon_type] == "points","selected=\"selected\"").">Points")."
				".iif($settings[sell_links]==1,"<option value=\"link_credits\"".iif($settings[purchcon_type] == "link_credits" && (SETTING_PTC == true),"selected=\"selected\"").">Link Credits")."
				".iif($settings[sellbanner]==1,"<option value=\"banner_credits\"".iif($settings[purchcon_type] == "banner_credits","selected=\"selected\"").">Banner Credits")."
				".iif($settings[sellfad]==1,"<option value=\"fad_credits\"".iif($settings[purchcon_type] == "fad_credits","selected=\"selected\"").">F. Ad Credits")."
				".iif($settings[sellpopups]==1,"<option value=\"popup_credits\"".iif($settings[purchcon_type] == "popup_credits" && (SETTING_PTP == true),"selected=\"selected\"").">Popup Credits")."
				".iif($settings[ptron]==1,"<option value=\"ptr_credits\"".iif($settings[purchcon_type] == "ptr_credits" && (SETTING_PTR == true),"selected=\"selected\"").">Email Credits")."
				".iif($settings[sell_ptra]==1,"<option value=\"ptra_credits\"".iif($settings[purchcon_type] == "ptra_credits" && (SETTING_PTRA == true),"selected=\"selected\"").">PTR Credits")."
				".iif($settings[sell_ptsu]==1,"<option value=\"ptsu_credits\"".iif($settings[purchcon_type] == "ptsu_credits" && (SETTING_PTSU == true),"selected=\"selected\"").">PTSU Credits")."
				".iif($settings[sellfbanner]==1,"<option value=\"fbanner_credits\"".iif($settings[purchcon_type] == "fbanner_credits","selected=\"selected\"").">Feat. Banner Credits")."
				".iif($settings[sellgamehits]==1,"<option value=\"game_points\"".iif($settings[purchcon_type] == "game_points" && (SETTING_GAMES == true),"selected=\"selected\"").">Game Points")."
			</select>
		</td>
	</tr>
		<tr>
		<td width=\"250\"><b>1st Winnings Amount:</b></td>
		<td><input type=\"text\" name=\"purchcon_amount\" value=\"$settings[purchcon_amount]\" size=5></td>
	</tr>

	<tr>
		<td width=\"250\"><b>2nd Place Winnings:</b></td>
				<td>
			<select name=\"purchcon_type2\">
				<option value=\"balance\"".iif($settings[purchcon_type2] == "balance","selected=\"selected\"").">Cash
				".iif($settings[points]==1,"<option value=\"points\"".iif($settings[purchcon_type2] == "points","selected=\"selected\"").">Points")."
				".iif($settings[sell_links]==1,"<option value=\"link_credits\"".iif($settings[purchcon_type2] == "link_credits" && (SETTING_PTC == true),"selected=\"selected\"").">Link Credits")."
				".iif($settings[sellbanner]==1,"<option value=\"banner_credits\"".iif($settings[purchcon_type2] == "banner_credits","selected=\"selected\"").">Banner Credits")."
				".iif($settings[sellfad]==1,"<option value=\"fad_credits\"".iif($settings[purchcon_type2] == "fad_credits","selected=\"selected\"").">F. Ad Credits")."
				".iif($settings[sellpopups]==1,"<option value=\"popup_credits\"".iif($settings[purchcon_type2] == "popup_credits" && (SETTING_PTP == true),"selected=\"selected\"").">Popup Credits")."
				".iif($settings[ptron]==1,"<option value=\"ptr_credits\"".iif($settings[purchcon_type2] == "ptr_credits" && (SETTING_PTR == true),"selected=\"selected\"").">Email Credits")."
				".iif($settings[sell_ptra]==1,"<option value=\"ptra_credits\"".iif($settings[purchcon_type2] == "ptra_credits" && (SETTING_PTRA == true),"selected=\"selected\"").">PTR Credits")."
				".iif($settings[sell_ptsu]==1,"<option value=\"ptsu_credits\"".iif($settings[purchcon_type2] == "ptsu_credits" && (SETTING_PTSU == true),"selected=\"selected\"").">PTSU Credits")."
				".iif($settings[sellfbanner]==1,"<option value=\"fbanner_credits\"".iif($settings[purchcon_type2] == "fbanner_credits","selected=\"selected\"").">Feat. Banner Credits")."
				".iif($settings[sellgamehits]==1,"<option value=\"game_points\"".iif($settings[purchcon_type2] == "game_points" && (SETTING_GAMES == true),"selected=\"selected\"").">Game Points")."
			</select>
		</td>
	</tr>
		<tr>
		<td width=\"250\"><b>2nd Winnings Amount:</b></td>
		<td><input type=\"text\" name=\"purchcon_amount2\" value=\"$settings[purchcon_amount2]\" size=5></td>
	</tr>
	<tr>
		<td width=\"250\"><b>3rd Place Winnings:</b></td>
				<td>
			<select name=\"purchcon_type3\">
				<option value=\"balance\"".iif($settings[purchcon_type] == "balance","selected=\"selected\"").">Cash
				".iif($settings[points]==1,"<option value=\"points\"".iif($settings[purchcon_type3] == "points","selected=\"selected\"").">Points")."
				".iif($settings[sell_links]==1,"<option value=\"link_credits\"".iif($settings[purchcon_type3] == "link_credits" && (SETTING_PTC == true),"selected=\"selected\"").">Link Credits")."
				".iif($settings[sellbanner]==1,"<option value=\"banner_credits\"".iif($settings[purchcon_type3] == "banner_credits","selected=\"selected\"").">Banner Credits")."
				".iif($settings[sellfad]==1,"<option value=\"fad_credits\"".iif($settings[purchcon_type3] == "fad_credits","selected=\"selected\"").">F. Ad Credits")."
				".iif($settings[sellpopups]==1,"<option value=\"popup_credits\"".iif($settings[purchcon_type3] == "popup_credits" && (SETTING_PTP == true),"selected=\"selected\"").">Popup Credits")."
				".iif($settings[ptron]==1,"<option value=\"ptr_credits\"".iif($settings[purchcon_type3] == "ptr_credits" && (SETTING_PTR == true),"selected=\"selected\"").">Email Credits")."
				".iif($settings[sell_ptra]==1,"<option value=\"ptra_credits\"".iif($settings[purchcon_type3] == "ptra_credits" && (SETTING_PTRA == true),"selected=\"selected\"").">PTR Credits")."
				".iif($settings[sell_ptsu]==1,"<option value=\"ptsu_credits\"".iif($settings[purchcon_type3] == "ptsu_credits" && (SETTING_PTSU == true),"selected=\"selected\"").">PTSU Credits")."
				".iif($settings[sellfbanner]==1,"<option value=\"fbanner_credits\"".iif($settings[purchcon_type3] == "fbanner_credits","selected=\"selected\"").">Feat. Banner Credits")."
				".iif($settings[sellgamehits]==1,"<option value=\"game_points\"".iif($settings[purchcon_type3] == "game_points" && (SETTING_GAMES == true),"selected=\"selected\"").">Game Points")."
			</select>
		</td>
	</tr>
		<tr>
		<td width=\"250\"><b>3rd Winnings Amount:</b></td>
		<td><input type=\"text\" name=\"purchcon_amount3\" value=\"$settings[purchcon_amount3]\" size=5></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Tickets Per Purchase:</b></td>
		<td><input type=\"text\" name=\"purchcon_buy\" value=\"$settings[purchcon_buy]\" size=3></td>
	</tr>
	<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
	<tr class=\"tableHL1\">
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt;\">$refcontime Referral Contest</font></b></td>
	</tr>
	<tr>
		<td width=\"250\"><b>$refcontime Referral Contest: </b></td>
		<td><input type=\"checkbox\" name=\"ref_contest_on\" value=\"1\"".iif($settings[ref_contest_on] == 1," checked=\"checked\"")."></td>
	</tr>

	<tr>
		<td width=\"250\"><b>Contest Length:</b></td>
		<td>
			<select name=\"ref_contest_time\">
				<option value=\"daily\"".iif($settings[ref_contest_time] == "daily","selected=\"selected\"").">Daily
				<option value=\"weekly\"".iif($settings[ref_contest_time] == "weekly","selected=\"selected\"").">Weekly
				<option value=\"monthly\"".iif($settings[ref_contest_time] == "monthly","selected=\"selected\"").">Monthly
				</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Winnings Type:</b></td>
		<td>
			<select name=\"ref_contest_type\">
				<option value=\"balance\"".iif($settings[ref_contest_type] == "balance","selected=\"selected\"").">Cash
				<option value=\"points\"".iif($settings[ref_contest_type] == "points","selected=\"selected\"").">Points
				<option value=\"link_credits\"".iif($settings[ref_contest_type] == "link_credits" && (SETTING_PTC == true),"selected=\"selected\"").">Link Credits
				<option value=\"banner_credits\"".iif($settings[ref_contest_type] == "banner_credits","selected=\"selected\"").">Banner Credits
				<option value=\"fad_credits\"".iif($settings[ref_contest_type] == "fad_credits","selected=\"selected\"").">F. Ad Credits
				<option value=\"popup_credits\"".iif($settings[ref_contest_type] == "popup_credits" && (SETTING_PTP == true),"selected=\"selected\"").">Popup Credits
				<option value=\"ptr_credits\"".iif($settings[ref_contest_type] == "ptr_credits" && (SETTING_PTR == true),"selected=\"selected\"").">Email Credits
				<option value=\"ptra_credits\"".iif($settings[ref_contest_type] == "ptra_credits" && (SETTING_PTRA == true),"selected=\"selected\"").">PTR Credits
				<option value=\"ptsu_credits\"".iif($settings[ref_contest_type] == "ptsu_credits" && (SETTING_PTSU == true),"selected=\"selected\"").">PTSU Credits
				<option value=\"fbanner_credits\"".iif($settings[ref_contest_type] == "fbanner_credits","selected=\"selected\"").">Feat. Banner Credits
				<option value=\"game_points\"".iif($settings[ref_contest_type] == "game_points" && (SETTING_GAMES == true),"selected=\"selected\"").">Game Points
			</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Winnings Amount:</b></td>
		<td><input type=\"text\" name=\"ref_contest_amount\" value=\"$settings[ref_contest_amount]\" size=5></td>
	</tr>

	<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
	<tr class=\"tableHL1\">
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt;\">$ticketstime Ticket Contest</font></b></td>
	</tr>
	<tr>
		<td width=\"250\"><b>$ticketscontime Ticket Drawing: </b></td>
		<td><input type=\"checkbox\" name=\"tickets_on\" value=\"1\"".iif($settings[tickets_on] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Contest Length:</b></td>
		<td>
			<select name=\"tickets_time\">
				<option value=\"daily\"".iif($settings[tickets_time] == "daily","selected=\"selected\"").">Daily
				<option value=\"weekly\"".iif($settings[tickets_time] == "weekly","selected=\"selected\"").">Weekly
				<option value=\"monthly\"".iif($settings[tickets_time] == "monthly","selected=\"selected\"").">Monthly
				</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Winnings Type:</b></td>
		<td>
			<select name=\"tickets_win_type\">
				<option value=\"balance\"".iif($settings[tickets_win_type] == "balance","selected=\"selected\"").">Cash
				<option value=\"points\"".iif($settings[tickets_win_type] == "points","selected=\"selected\"").">Points
				<option value=\"link_credits\"".iif($settings[tickets_win_type] == "link_credits" && (SETTING_PTC == true),"selected=\"selected\"").">Link Credits
				<option value=\"banner_credits\"".iif($settings[tickets_win_type] == "banner_credits","selected=\"selected\"").">Banner Credits
				<option value=\"fad_credits\"".iif($settings[tickets_win_type] == "fad_credits","selected=\"selected\"").">F. Ad Credits
				<option value=\"popup_credits\"".iif($settings[tickets_win_type] == "popup_credits" && (SETTING_PTP == true),"selected=\"selected\"").">Popup Credits
				<option value=\"ptr_credits\"".iif($settings[tickets_win_type] == "ptr_credits" && (SETTING_PTR == true),"selected=\"selected\"").">Email Credits
				<option value=\"ptra_credits\"".iif($settings[tickets_win_type] == "ptra_credits" && (SETTING_PTRA == true),"selected=\"selected\"").">PTR Credits
				<option value=\"ptsu_credits\"".iif($settings[tickets_win_type] == "ptsu_credits" && (SETTING_PTSU == true),"selected=\"selected\"").">PTSU Credits
				<option value=\"fbanner_credits\"".iif($settings[tickets_win_type] == "fbanner_credits","selected=\"selected\"").">Feat. Banner Credits
				<option value=\"game_points\"".iif($settings[tickets_win_type] == "game_points" && (SETTING_GAMES == true),"selected=\"selected\"").">Game Points
			</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Winnings Amount:</b></td>
		<td><input type=\"text\" name=\"tickets_win_amount\" value=\"$settings[tickets_win_amount]\" size=5></td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>Tickets To Draw:</b></td>
		<td><input type=\"text\" name=\"tickets_draw\" value=\"$settings[tickets_draw]\" size=2></td>
	</tr>
	
	<tr>".iif(SETTING_PTC == true, "
		<td width=\"250\"><b>Tickets Per Link:</b></td>
		<td><input type=\"text\" name=\"tickets_ptc\" value=\"$settings[tickets_ptc]\" size=3></td>
	</tr>")."
	<tr>".iif(SETTING_CE == true, "
		<td width=\"250\"><b>Tickets Per X-Click:</b></td>
		<td><input type=\"text\" name=\"tickets_xclick\" value=\"$settings[tickets_xclick]\" size=3></td>
	</tr>")."
	<tr>".iif(SETTING_PTR == true, "
		<td width=\"250\"><b>Tickets Per Email:</b></td>
		<td><input type=\"text\" name=\"tickets_ptr\" value=\"$settings[tickets_ptr]\" size=3></td>
	</tr>")."
	<tr>".iif(SETTING_PTRA == true, "
		<td width=\"250\"><b>Tickets Per PTR Ad:</b></td>
		<td><input type=\"text\" name=\"tickets_ptra\" value=\"$settings[tickets_ptra]\" size=3></td>
	</tr>")."
	<tr>".iif(SETTING_PTSU == true, "
		<td width=\"250\"><b>Tickets Per PTSU Join:</b></td>
		<td><input type=\"text\" name=\"tickets_ptsu\" value=\"$settings[tickets_ptsu]\" size=3></td>
	</tr>")."
	<tr>
		<td width=\"250\"><b>Tickets Per Referral:</b></td>
		<td><input type=\"text\" name=\"tickets_ref\" value=\"$settings[tickets_ref]\" size=3></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Tickets Per Purchase:</b></td>
		<td><input type=\"text\" name=\"tickets_buy\" value=\"$settings[tickets_buy]\" size=3></td>
	</tr>
	<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
	</tr>
	<tr class=\"tableHL1\">
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt;\">$clickctime Click Contest</font></b></td>
	</tr>
	<tr>
	<td width=\"250\"><b>$clickctime Click Contest: </b></td>
		<td><input type=\"checkbox\" name=\"clickc_on\" value=\"1\"".iif($settings[clickc_on] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Contest Length:</b></td>
		<td>
			<select name=\"clickc_time\">
				<option value=\"daily\"".iif($settings[clickc_time] == "daily","selected=\"selected\"").">Daily
				<option value=\"weekly\"".iif($settings[clickc_time] == "weekly","selected=\"selected\"").">Weekly
				<option value=\"monthly\"".iif($settings[clickc_time] == "monthly","selected=\"selected\"").">Monthly
				</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Winnings Type:</b></td>
		<td>
			<select name=\"clickc_type\">
				<option value=\"balance\"".iif($settings[clickc_type] == "balance","selected=\"selected\"").">Cash
				<option value=\"points\"".iif($settings[clickc_type] == "points","selected=\"selected\"").">Points
				<option value=\"link_credits\"".iif($settings[clickc_type] == "link_credits" && (SETTING_PTC == true),"selected=\"selected\"").">Link Credits
				<option value=\"banner_credits\"".iif($settings[clickc_type] == "banner_credits","selected=\"selected\"").">Banner Credits
				<option value=\"fad_credits\"".iif($settings[clickc_type] == "fad_credits","selected=\"selected\"").">F. Ad Credits
				<option value=\"popup_credits\"".iif($settings[clickc_type] == "popup_credits","selected=\"selected\"").">Popup Credits
				<option value=\"ptr_credits\"".iif($settings[clickc_type] == "ptr_credits","selected=\"selected\"").">Email Credits
				<option value=\"ptra_credits\"".iif($settings[clickc_type] == "ptra_credits","selected=\"selected\"").">PTR Credits
				<option value=\"ptsu_credits\"".iif($settings[clickc_type] == "ptsu_credits","selected=\"selected\"").">PTSU Credits
				<option value=\"fbanner_credits\"".iif($settings[clickc_type] == "fbanner_credits","selected=\"selected\"").">Feat. Banner Credits
				<option value=\"game_points\"".iif($settings[clickc_type] == "game_points","selected=\"selected\"").">Game Points
			</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Winnings Amount:</b></td>
		<td><input type=\"text\" name=\"clickc_amount\" value=\"$settings[clickc_amount]\" size=5></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Number of winners:</b></td>
		<td><input type=\"text\" name=\"clickc_draw\" value=\"$settings[clickc_draw]\" size=2></td>
	</tr>
	
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	
</table>
<div align=\"right\"></div>
</form>
";
//**E**//
?>