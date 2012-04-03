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
$includes[title]="Delete Popup Site";
//**VS**//$setting[ptr]//**VE**//
//**S**//
if($step == 2) {
	if($action == "Delete") {
		$sql=$Db1->query("SELECT * FROM popups WHERE id='$id'");
		$popup=$Db1->fetch_array($sql);
		$sql=$Db1->query("DELETE FROM popups WHERE id='$id'");
		if($retract == 1) $sql=$Db1->query("UPDATE user SET popup_credits=popup_credits+$popup[credits] WHERE username='$popup[username]'");
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
}
else {
	$includes[content]="
<form action=\"admin.php?view=admin&ac=delete_popup&step=2&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to delete this?')\">
Return Credits To User's Account? <input type=\"checkbox\" value=\"1\" name=\"retract\"><br />
<input type=\"submit\" value=\"Delete\" name=\"action\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"submit\" value=\"Cancel\">
</form>
	";
}
//**E**//
?>
