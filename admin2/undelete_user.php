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
$includes[title]="Undelete Member";
//**S**//
if($action == "undelete") {
	$sql=$Db1->query("SELECT * FROM user_deleted WHERE userid='$id'");
	$userinfo=$Db1->fetch_array($sql);

	$Db1->query("DELETE FROM user WHERE username='$userinfo[username]'");

	$Db1->query("UPDATE user_deleted SET notes='".$userinfo[notes]."\n---------------\nUndeleted By Admin' WHERE username='$userinfo[username]'");
	
	$Db1->query("INSERT INTO user SELECT * FROM user_deleted WHERE username='$userinfo[username]'");
	
	$Db1->query("DELETE FROM user_deleted WHERE userid='$id'");
	
	$sql=$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=deleted_members&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
}
$includes[content]="
Are you sure you want to undelete this member?<br />
<input type=\"button\" value=\"Yes\" onclick=\"location.href='admin.php?view=admin&ac=undelete_user&action=undelete&id=$id&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."'\">
<input type=\"button\" value=\"No\" onclick=\"location.href='admin.php?view=admin&ac=deleted_members&s=$s'\">
";
//**E**//
?>