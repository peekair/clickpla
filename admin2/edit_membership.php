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
$includes[title]="Edit Membership";
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
if($action == "deletem") {
	$sql=$Db1->query("SELECT * FROM user WHERE membership='$id' and type='1'");
	if($Db1->num_rows() == 0) {
		$Db1->query("DELETE FROM memberships WHERE id='$id'");
		$Db1->query("DELETE FROM membership_benefits WHERE membership='$id'");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=memberships&".$url_variables."");
	}
	else {
		$includes[content]="<b style=\"color: red\">ERROR: You cannot delete this membership because there are currently subscribers!</b><br />";
	}
}

if($action == "edit") {
	$sql=$Db1->query("UPDATE memberships SET 
		title='".htmlentities($mtitle)."',
		time_type='$mtype',
		downline_earns='$mdle',
		price='$mprice',
		packages='$mpackages',
		purchase_bonus='$purchase_bonus',
		upgrade_bonus='$upgrade_bonus',
		`order`='$morder',
		active='$mactive',
		ptp='$ptp'
	WHERE id='$id'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_membership&id=$id&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
	$msg="Your changes have been saved.";
}

if($action == "new") {
	$sql=$Db1->query("INSERT INTO membership_benefits SET
		title='".
				iif($mtype=="xcredits","X-Credits").
				iif($mtype=="link_credits","Link Credits").
				iif($mtype=="popup_credits","Popup Credits").
				iif($mtype=="ptr_credits","Email Credits").
				iif($mtype=="ptra_credits","PTR Credits").
				iif($mtype=="ptsu_credits","Guaranteed Signups").
				iif($mtype=="fad_credits","F. Ad Credits").
				iif($mtype=="banner_credits","Banner Credits").
				iif($mtype=="fbanner_credits","F. Banner Credits").
				iif($mtype=="game_site_credits","Game Site Credits").
				iif($mtype=="game_points","Game Points").
				iif($mtype=="balance","Cash").
				iif($mtype=="tickets","Tickets")
		."',
		membership='$id',
		type='$mtype',
		amount='$amount',
		time_type='$time_type',
		time='$time'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_membership&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
}

if($action == "delete") {
	$Db1->query("DELETE FROM membership_benefits WHERE id='$bid'");
}


$sql=$Db1->query("SELECT * FROM memberships WHERE id='$id'");
$membership=$Db1->fetch_array($sql);


$sql2=$Db1->query("SELECT * FROM membership_benefits WHERE membership='$id' ORDER BY amount");
$featnum=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql2)) {
	$feats.="<li>".$temp[amount]."  ".$temp[title]." ".
				iif($temp[time_type]=="U","Upon Joining").
				iif($temp[time_type]=="D","Daily").
				iif($temp[time_type]=="W","Weekly ($temp[time])").
				iif($temp[time_type]=="M","Monthly ($temp[time])").
				iif($temp[time_type]=="Y","Yearly")." <a href=\"admin.php?view=admin&bid=$temp[id]&ac=edit_membership&id=$id&action=delete&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\">Delete</a>";
}

$includes[content].="<br />
$msg<br />
<form action=\"admin.php?view=admin&ac=edit_membership&id=$id&action=new&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">
<table width=\"100%\">
	<tr>
		<td valign=\"top\"><b>$featnum Benefits For This Membership:</b>$feats</td>
		<td valign=\"top\">
			Amount: <input type=\"text\" name=\"amount\" value=\"\"><br />
			Type: 
				<select name=\"mtype\">
					".iif(SETTING_PTC==true,"<option value=\"link_credits\">Link Credits")."
					".iif(SETTING_PTP==true,"<option value=\"popup_credits\">Popup Credits")."
					".iif(SETTING_PTR==true,"<option value=\"ptr_credits\">Email Credits")."
					".iif(SETTING_PTRA==true,"<option value=\"ptra_credits\">PTR Credits")."
					".iif(SETTING_PTSU==true,"<option value=\"ptsu_credits\">Guaranteed Signups")."
					".iif(SETTING_CE==true,"<option value=\"xcredits\">X-Credits")."
					<option value=\"fad_credits\">F. Ad Credits
					<option value=\"banner_credits\">Banner Credits
					<option value=\"fbanner_credits\">F. Banner Credits
				".iif(SETTING_GAMES==true,"
					<option value=\"game_site_credits\">Game Site Credits
					<option value=\"game_points\">Game points
				")."
					<option value=\"balance\">Cash
					<option value=\"tickets\">Tickets
				</select><br />
			Basis: 
				<select name=\"time_type\">
					<option value=\"U\">Upon Joining
					<option value=\"D\">Daily
					<option value=\"W\">Weekly
					<option value=\"M\">Monthly
				</select><br />
			Time: <input type=\"text\" name=\"time\" value=\"\" size=3>*<small>See Below For Help</small><br />
				<input type=\"submit\" value=\"Add Benefit\">
		</td>
	</tr>
</table>
</form>
<br />

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=edit_membership&id=$id&action=edit&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"300\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL2\">
					<td>Title: </td>
					<td><input type=\"text\" name=\"mtitle\" value=\"$membership[title]\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Type: </td>
					<td>
					<select name=\"mtype\">
						<option value=\"D\"".iif($membership[time_type]=="D","selected=\"selected\"").">Day
						<option value=\"W\"".iif($membership[time_type]=="W","selected=\"selected\"").">Week
						<option value=\"M\"".iif($membership[time_type]=="M","selected=\"selected\"").">Month
						<option value=\"Y\"".iif($membership[time_type]=="Y","selected=\"selected\"").">Year
						<option value=\"L\"".iif($membership[time_type]=="L","selected=\"selected\"").">Lifetime
					</select></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Downline Earnings: </td>
					<td><input type=\"text\" name=\"mdle\" value=\"$membership[downline_earns]\" size=3> (0.05 = 5%)</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Price: </td>
					<td>$cursym <input type=\"text\" name=\"mprice\" value=\"$membership[price]\" size=5></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Packages: </td>
					<td><input type=\"text\" name=\"mpackages\" value=\"$membership[packages]\"></td>
				</tr>".iif(SETTING_PTP == true,"
				<tr class=\"tableHL2\">
					<td>PTP Amount: </td>
					<td>$cursym <input type=\"text\" name=\"ptp\" value=\"$membership[ptp]\" size=6></td>
				</tr>")."
				<tr class=\"tableHL2\">
					<td>Purchase Bonus: </td>
					<td>%<input type=\"text\" name=\"purchase_bonus\" value=\"$membership[purchase_bonus]\" size=3></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Upgrade Bonus: </td>
					<td>%<input type=\"text\" name=\"upgrade_bonus\" value=\"$membership[upgrade_bonus]\" size=3></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Order: </td>
					<td><input type=\"text\" name=\"morder\" value=\"$membership[order]\" size=3></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Sell? </td>
					<td><input type=\"checkbox\" name=\"mactive\" value=\"1\" ".iif($membership[active]==1,"checked=\"checked\"")."></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\">
						<input type=\"submit\" value=\"Save\">
						<input type=\"button\" value=\"Delete\" onclick=\"if(confirm('Are you sure you want to delete this membership?')) location.href='admin.php?view=admin&ac=edit_membership&id=$id&action=deletem&".$url_variables."'\">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</div>

<b>* Time Help</b><br />
In this field you can set when it shall assign the bonus.<br />
<b>Upon Joining: </b> Not applicable<br />
<b>Daily: </b> Not applicable<br />
<b>Weekly: </b> Day of week to assign. 1=sunday, 7=saturday<br />
<b>Monthly: </b> Day of month to assign bonus <br />



";
//**E**//
?>
