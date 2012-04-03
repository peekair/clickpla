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
$includes[title]="Edit Exchange Site";
//**VS**//$setting[ce]//**VE**//
//**S**//
$sql=$Db1->query("SELECT * FROM xsites WHERE id='$id'");
$adinfo=$Db1->fetch_array($sql);
if($action == "edit") {
	$sql=$Db1->query("UPDATE xsites SET 
		title='".htmlentities($title)."',
		target='$target',
		username='$user',
		credits='$credits',
		views='$views',
		daily_limit='$daily_limit',
		country='".addslashes($country)."',
		upgrade='$upgrade',
		views_today='$today',
		forbid_retract='$forbid_retract',
                decline='$decline',
		active='$active'
	WHERE id='$id'
	");
	$Db1->sql_close();
//	header("Location: admin.php?view=admin&ac=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	header("Location: admin.php?view=admin&ac=edit_xsite&id=$id&msg=Your changes have been saved.&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
}


if($adinfo[pstart] == "") {
	$adinfo[pstart]=time();
}

if($adinfo[pend] == "") {
	$adinfo[pend]=time()+2592000;
}

$includes[content]="
<div align=\"right\"><a href=\"admin.php?view=admin&ac=xsites&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\">Back To Manager</a></div>
$msg<br />
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=edit_xsite&id=$id&action=edit&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\"><a href=\"$adinfo[url]\" url=\"_blank\">$adinfo[title]</a></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Title:</td>
					<td><input type=\"text\" value=\"$adinfo[title]\" name=\"title\" size=\"40\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Url:</td>
					<td><input type=\"text\" value=\"$adinfo[target]\" name=\"target\" size=\"40\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Username:</td>
					<td><input type=\"text\" value=\"$adinfo[username]\" name=\"user\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Credits:</td>
					<td><input type=\"text\" value=\"$adinfo[credits]\" name=\"credits\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Views:</td>
					<td><input type=\"text\" value=\"$adinfo[views]\" name=\"views\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Today:</td>
					<td><input type=\"text\" value=\"$adinfo[views_today]\" name=\"today\"></td>
				</tr>
				<tr>
					<td>Target Country: </td>
					<td><select name=\"country\">".targetCountryList($adinfo[country])."</select></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2>Status:
						<select name=\"active\">
							<option value=\"0\"".iif($adinfo[active] == 0,"selected=\"selected\"").">Pending Approval
							<option value=\"1\"".iif($adinfo[active] == 1,"selected=\"selected\"").">Active
							<option value=\"2\"".iif($adinfo[active] == 2,"selected=\"selected\"").">Approval Denied
						</select>
					</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Daily Limit:</td>
					<td><input type=\"text\" value=\"$adinfo[daily_limit]\" name=\"daily_limit\"></td>
				</tr>

				<tr class=\"tableHL2\">
					<td colspan=2>Only For Upgraded Members?: <input type=\"checkbox\" value=\"1\" name=\"upgrade\"".iif($adinfo[upgrade] == 1,"checked=\"checked\"")."></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2>Forbid Credit Retraction: <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"".iif($adinfo[forbid_retract] == 1,"checked=\"checked\"")."></td>
				</tr>
	<tr class=\"tableHL2\">
					<td>Decline Message:</td>
					<td><input type=\"text\" value=\"$adinfo[decline]\" name=\"decline\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\">
						<input type=\"submit\" value=\"Save\">
						".iif($permission==7,"<input type=\"button\" value=\"Delete\" onclick=\"location.href='admin.php?view=admin&ac=delete_xsite&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."'\">")."
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
