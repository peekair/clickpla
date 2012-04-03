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
$includes[title]="Edit Special";
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

if($action == "deletes") {
	$Db1->query("DELETE FROM specials WHERE id='$id'");
	$Db1->query("DELETE FROM special_benefits WHERE special='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=specials&".$url_variables."");
}

if($action == "edit") {
	$sql=$Db1->query("UPDATE specials SET 
		title='".htmlentities($mtitle)."',
		price='$mprice',
		packages='$mpackages',
		`order`='$morder',
		active='$mactive'
	WHERE id='$id'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_special&id=$id&".$url_variables."");
	$msg="Your changes have been saved.";
}

if($action == "new") {
	$sql=$Db1->query("INSERT INTO special_benefits SET
		title='".
				iif($mtype=="xcredits","X-Credits").
				iif($mtype=="link_credits","Link Credits").
				iif($mtype=="popup_credits","PTP Credits").
				iif($mtype=="ptr_credits","Email Credits").
				iif($mtype=="ptra_credits","PTR Credits").
				iif($mtype=="ptsu_credits","Guaranteed Signups").
				iif($mtype=="fad_credits","F. Ad Credits").
				iif($mtype=="banner_credits","Banner Credits").
				iif($mtype=="game_site_credits","Game Site Credits").
				iif($mtype=="game_points","Game Points").
				iif($mtype=="fbanner_credits","F. Banner Credits").
				iif($mtype=="balance","Cash").
				iif($mtype=="tickets","Tickets").
				iif($mtype=="referrals","Referrals").
iif($mtype=="tokens","Token")
		."',
		special='$id',
		type='$mtype',
		amount='$amount'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_special&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
}

if($action == "delete") {
	$Db1->query("DELETE FROM special_benefits WHERE id='$bid'");
}


$sql=$Db1->query("SELECT * FROM specials WHERE id='$id'");
$special=$Db1->fetch_array($sql);


$sql2=$Db1->query("SELECT * FROM special_benefits WHERE special='$id' ORDER BY amount");
$featnum=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql2)) {
	$feats.="<li>".$temp[amount]."  ".$temp[title]." ".
				iif($temp[time_type]=="U","Upon Joining").
				iif($temp[time_type]=="D","Daily").
				iif($temp[time_type]=="W","Weekly ($temp[time])").
				iif($temp[time_type]=="M","Monthly ($temp[time])").
				iif($temp[time_type]=="Y","Yearly")." <a href=\"admin.php?view=admin&bid=$temp[id]&ac=edit_special&id=$id&action=delete&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\">Delete</a>";
}

$includes[content]="<br />
$msg<br />
<form action=\"admin.php?view=admin&ac=edit_special&id=$id&action=new&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">
<table width=\"100%\">
	<tr>
		<td valign=\"top\"><b>$featnum Benefits For This Special:</b>$feats</td>
		<td valign=\"top\">
			Amount: <input type=\"text\" name=\"amount\" value=\"\"><br />
			Type: 
				<select name=\"mtype\">
					".iif(SETTING_PTC==true,"<option value=\"link_credits\">Link Credits")."
					".iif(SETTING_PTP==true,"<option value=\"popup_credits\">PTP Credits")."
					".iif(SETTING_PTR==true,"<option value=\"ptr_credits\">Email Credits")."
					".iif(SETTING_PTRA==true,"<option value=\"ptra_credits\">PTR Credits")."
					".iif(SETTING_PTSU==true,"<option value=\"ptsu_credits\">PTSU Credits")."
					".iif(SETTING_CE==true,"<option value=\"xcredits\">X-Credits")."
		".iif(SETTING_TIC==true,"<option value=\"tokens\">Tokens")."
					<option value=\"fad_credits\">F. Ad Credits
					<option value=\"banner_credits\">Banner Credits
					<option value=\"fbanner_credits\">F. Banner Credits
				".iif(SETTING_GAMES==true,"
					<option value=\"game_site_credits\">Game Site Credits
					<option value=\"game_points\">Game Points
				")."
					<option value=\"balance\">Cash
					<option value=\"tickets\">Tickets
					<option value=\"referrals\">Referrals
				</select><br />
				<input type=\"submit\" value=\"Add Benefit\">
		</td>
	</tr>
</table>
</form>
<br />

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=edit_special&id=$id&action=edit&".$url_variables."\" method=\"post\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"300\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL2\">
					<td>Title: </td>
					<td><input type=\"text\" name=\"mtitle\" value=\"$special[title]\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Price: </td>
					<td>$cursym <input type=\"text\" name=\"mprice\" value=\"$special[price]\" size=5></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Packages: </td>
					<td><input type=\"text\" name=\"mpackages\" value=\"$special[packages]\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Order: </td>
					<td><input type=\"text\" name=\"morder\" value=\"$special[order]\" size=3></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Sell? </td>
					<td><input type=\"checkbox\" name=\"mactive\" value=\"1\" ".iif($special[active]==1,"checked=\"checked\"")."></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\">
						<input type=\"submit\" value=\"Save\">
						<input type=\"button\" value=\"Delete\" onclick=\"if(confirm('Are you sure you want to delete this special?')) location.href='admin.php?view=admin&ac=edit_special&id=$id&action=deletes&".$url_variables."'\">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</div>



";
//**E**//
?>
