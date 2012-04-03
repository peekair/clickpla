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
$includes[title]="Manage Ads";

if($adtype == "") {
	$adtype=iif(SETTING_PTC == true, "link","banner");
}

$includes[content]="
<script type=\"text/javascript\">
function go_manage() {
	var ad_type = document.getElementById('adtype').value;
	location.href='index.php?view=account&ac=myads&adtype='+ad_type+'&".$url_variables."';
}
</script>	".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if you are unable to use our member features!</div>")."
".iif($thismemberinfo[confirm] == 1,"
<div align=\"center\">
Manage:
	<select id=\"adtype\">
		".iif(($settings[ptcon]==1) && (SETTING_PTC == true),"<option value=\"link\"".iif($adtype=="link"," selected=\"selected\"").">PTC Ads")."
		".iif(($settings[ptsuon]==1) && (SETTING_PTSU == true),"<option value=\"ptsu\"".iif($adtype=="ptsu"," selected=\"selected\"").">Signup Offers")."
		".iif(($settings[user_popups]==1) && (SETTING_PTP == true),"<option value=\"popups\"".iif($adtype=="popups"," selected=\"selected\"").">PTP Ads")."
		".iif(($settings[ptron]==1) && (SETTING_PTR == true),"<option value=\"emails\"".iif($adtype=="emails"," selected=\"selected\"").">Email Ads")."
		".iif(($settings[ptraon]==1) && (SETTING_PTRA == true),"<option value=\"ptrads\"".iif($adtype=="ptrads"," selected=\"selected\"").">PTR Ads")."
		".iif(($settings[ce_on]==1) && (SETTING_CE == true),"<option value=\"xsites\"".iif($adtype=="xsites"," selected=\"selected\"").">Click Exchange Sites")."
		".iif($settings[sellbanner]==1,"<option value=\"banner\"".iif($adtype=="banner"," selected=\"selected\"").">Banner Ads")."
		".iif($settings[sellfbanner] == 1,"<option value=\"fbanner\"".iif($adtype=="fbanner"," selected=\"selected\"").">Featured Banner Ads")."
		".iif($settings[sellfad] == 1,"<option value=\"fad\"".iif($adtype=="fad"," selected=\"selected\"").">Featured Ads")."
		".iif($settings[sellflink] == 1,"<option value=\"flink\"".iif($adtype=="flink"," selected=\"selected\"").">Featured Links")."
	</select>
	<input type=\"button\" value=\"Manage\" onclick=\"go_manage()\">
</div><br />")."
";

include("members/myads/".$adtype.".php");

?>