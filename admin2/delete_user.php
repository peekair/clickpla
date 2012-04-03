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

   function deleteUser1($id) {
	global $Db1;
		$sql=$Db1->query("SELECT * FROM user WHERE userid='$id'");
		$userinfo=$Db1->fetch_array($sql);

		$Db1->query("DELETE FROM ads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM emails WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM ptrads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM ptsuads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM popups WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM xsites WHERE username='$userinfo[username]'");

		$Db1->query("DELETE FROM banners WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM fbanners WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM fads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM flinks WHERE username='$userinfo[username]'");

		$Db1->query("UPDATE user SET refered='' WHERE refered='".$userinfo[username]."' ");
		$Db1->query("UPDATE user SET notes='\n---------------\nDeleted By Admin' WHERE userid='$userinfo[userid]'");
		$Db1->query("INSERT INTO user_deleted SELECT * FROM user WHERE userid='$userinfo[userid]'");
		$Db1->query("DELETE FROM user WHERE userid='$userinfo[userid]'");
}

$includes[title]="Delete Member";
//**S**//


if($do == "delete") {
	if($action == "Delete") {
		deleteUser1($id);
	}
	$sql=$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=members&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
}
$includes[content]="
<form action=\"admin.php?view=admin&ac=delete_user&step=2&id=$id&do=delete&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to delete this?')\">
<input type=\"submit\" value=\"Delete\" name=\"action\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"submit\" value=\"Cancel\">
</form>
";
//**E**//
?>
