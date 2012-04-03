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
$includes[title]="Manage ads &nbsp; &raquo; &nbsp; Edit featured link ad";
//**S**//
if($action == "edit") {
	$sql=$Db1->query("UPDATE flinks SET 
		title='".htmlentities($title)."',
		target='$target',
		username='$user',
		clicks='$clicks',
		marquee='$marquee',
		bgcolor='$bgcolor',
		dend='".mktime(0,0,0,$proendmm,$proenddd,$proendyy)."'
	WHERE id='$id'
	");
	$Db1->sql_close();
//	header("Location: admin.php?view=admin&ac=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	header("Location: admin.php?view=admin&ac=edit_flink&id=$id&msg=Your changes have been saved.&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
}

$sql=$Db1->query("SELECT * FROM flinks WHERE id='$id'");
$adinfo=$Db1->fetch_array($sql);


if($adinfo[dend] == "") {
	$adinfo[dend]=time();
}

$includes[content]="

<p class=\"redButton\" style=\"margin-top:0px;\">
<a href=\"admin.php?view=admin&ac=flinks&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\">Back To \"Manage featured link ads\"</a>
</p>

$msg<br />

<div style=\"float:left;\">

<form action=\"admin.php?view=admin&ac=edit_flink&id=$id&action=edit&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">

			<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">
				<tr>
					<td colspan=\"2\" style=\"font-size:14px; font-weight:bold;\">
                                         <a href=\"$adinfo[target]\" target=\"_blank\">$adinfo[title]</a>
                                        </td>
				</tr>
                                <tr>
					<td colspan=\"2\" style=\"text-align:center; font-size:14px; font-weight:bold;\">
                                          &nbsp;
                                        </td>
				</tr>
				<tr>
					<td width=\"150px;\" style=\"padding:5px 0px;\">Title:</td>
					<td><input type=\"text\" value=\"$adinfo[title]\" name=\"title\" size=\"60\" class=\"text medium\" /></td>
				</tr>
				<tr>
					<td style=\"padding:5px 0px;\">URL:</td>
					<td><input type=\"text\" value=\"$adinfo[target]\" name=\"target\" size=\"60\" class=\"text medium\" /></td>
				</tr>
				<tr>
					<td style=\"padding:5px 0px;\">Username:</td>
					<td><input type=\"text\" value=\"$adinfo[username]\" name=\"user\" class=\"text medium\" /></td>
				</tr>
				<tr>
					<td style=\"padding:5px 0px;\">Highlight color:</td>
					<td><input type=\"text\" value=\"$adinfo[bgcolor]\" name=\"bgcolor\" class=\"text medium\" /></td>
				</tr>
				<tr>
					<td style=\"padding:5px 0px;\">Marquee:</td>
					<td><input type=\"checkbox\" value=\"1\" name=\"marquee\"".iif($adinfo[marquee]==1,"checked=\"checked\"")."></td>
				</tr>
				<tr>
					<td style=\"padding:5px 0px;\">Clicks:</td>
					<td><input type=\"text\" value=\"$adinfo[clicks]\" name=\"clicks\" class=\"text medium\" /></td>
				</tr>
				<tr>
					<td style=\"padding:5px 0px;\">Expire: (mm/dd/yy)</td>
					<td>
						";
						
						if($adinfo[dend]=="") {
							$adinfo[dend]=time()+2764800;
						}
						
						$thedate=explode("/", date('d/m/y', mktime(0,0,$adinfo[dend],1,1,1970)));
						
						$includes[content].="<select name=\"proendmm\">";
						for($x=1; $x<=12; $x++) {
							$includes[content].="
								<option value=\"$x\" ".iif($thedate[1]==$x," selected").">$x
							";
						}
						$includes[content].="</select> &nbsp;";
						
						$includes[content].="<select name=\"proenddd\">";
						for($x=1; $x<=31; $x++) {
							$includes[content].="
								<option value=\"$x\" ".iif($thedate[0]==$x," selected").">$x
							";
						}
						$includes[content].="</select> &nbsp;";
						
						$includes[content].="<select name=\"proendyy\">";
						for($x=10; $x<=19; $x++) {
							$includes[content].="
								<option value=\"$x\" ".iif($thedate[2]==$x," selected").">$x
							";
						}
						$includes[content].="</select> &nbsp;";
						
						$includes[content].="
					</td>
				</tr>
				<tr>
					<td colspan=\"2\">
						<input type=\"submit\" value=\"Save\" style=\"width:143px; padding:3px; margin:10px 5px 0px 0px; background-color:#FFF; border:1px solid #999;\" />
						".iif($permission==7,"<input type=\"button\" value=\"Delete\" style=\"width:140px; padding:3px; margin:10px 0px 0px 0px; background-color:#FFF; border:1px solid #999;\" onclick=\"location.href='admin.php?view=admin&ac=delete_flink&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."'\">")."
					</td>
				</tr>
			</table>

</form>
</div>
";
//**E**//
?>