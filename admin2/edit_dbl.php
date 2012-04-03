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
$includes[title]="Edit Referral Builder Program";
//**S**//

if($action == "edit") {
	$cats1=":";
	for($x=0; $x<count($cat); $x++) {
		$cats1.="".$cat[$x].":";
	}
	$sql=$Db1->query("UPDATE downline_builder SET
		title='$program',
		url='$purl',
		type='$ptype',
		defaultid='$pref',
		category='$cats1',
		dsub='".time()."',
		description='".addslashes($description)."'
	WHERE id='$id'
	");

	$Db1->sql_close();
	$msg="Your changes have been saved.";
//	header("Location: admin.php?view=admin&ac=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
}

$sql=$Db1->query("SELECT * FROM downline_builder WHERE id='$id'");
$adinfo=$Db1->fetch_array($sql);

if($adinfo[pstart] == "") {
	$adinfo[pstart]=time();
}

if($adinfo[pend] == "") {
	$adinfo[pend]=time()+2592000;
}

$cats=explode(":",$adinfo[category]);


function check_cat($ccat) {
	global $cats;
	$return = 0;
	for($x=0; $x<count($cats); $x++) {
		if($cats[$x] == $ccat) {
			$return = 1;
		}
	}
	return $return;
}

$sql=$Db1->query("SELECT * FROM dbl_cat ORDER BY title");
while($cat = $Db1->fetch_array($sql)) {
	$catlist.="<option value=\"$cat[id]\"".iif(check_cat($cat[id]),"selected=\"selected\"").">$cat[title]";
}


$includes[content]="<br />
$msg<br />
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=edit_dbl&id=$id&action=edit&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"500\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL2\">
					<td>Title:</td>
					<td><input type=\"text\" value=\"$adinfo[title]\" name=\"program\" size=\"60\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Base Url:</td>
					<td><input type=\"text\" value=\"$adinfo[url]\" name=\"purl\" size=\"60\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Referral ID:</td>
					<td><input type=\"text\" value=\"$adinfo[defaultid]\" name=\"pref\" size=\"10\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Type:</td>
					<td>
						<select name=\"ptype\">
							<option value=\"0\"".iif($adinfo[type]==0,"selected=\"selected\"").">Affiliate
							<option value=\"1\"".iif($adinfo[type]==1,"selected=\"selected\"").">Non-Affiliate
						</select>
					</td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\">
					<textarea name=\"description\" cols=30 rows=5>".stripslashes($adinfo[description])."</textarea>&nbsp;&nbsp;&nbsp;
						<select name=\"cat[]\" size=5 multiple=1>
							$catlist
						</select>
					</td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\">
						<input type=\"submit\" value=\"Save\">
						".iif($permission==7,"<input type=\"button\" value=\"Delete\" onclick=\"location.href='admin.php?view=admin&ac=delete_dbl&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."'\">")."
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
<a href=\"$adinfo[url]$adinfo[defaultid]\" target=\"_blank\">$adinfo[url]$adinfo[defaultid]</a>
</form>
</div>
";
//**E**//
?>
