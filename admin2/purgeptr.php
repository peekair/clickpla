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
$includes['title']="Purge old ads";

if($_POST['days'] > 0) {
	$days = $_POST['days'];
	$secs = (time()-(60*60*24*$days));
	
	
	$Db1->query("DELETE FROM ptrads WHERE credits=0 and dsub<{$secs}");
	
	echo "<p>Old PTR ads Purged</p>";
}


?>

<p>This tool will delete PTR ads that have are over a certain number of days old and that have no credits left.</p>

<form action="admin.php?ac=purgeptr&<?=$url_variables;?>" method="POST">
Age to delete: <input type="text" name="days" size="3" value="30" /> days<br/>
<input type="submit" value="Purge">
</form>