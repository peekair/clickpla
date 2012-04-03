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
if($action == "shift") {
	shiftDL($username, $to);
	$Db1->query("INSERT INTO logs SET log='Shifted Downline To $to', dsub='".time()."', username='".$username."'");
	$includes[content]="Your downline has been shifted to the member <i>$to</i>!";
}
else {
$includes[content]="
This utility allows you to move your entire downline to another member's account. This is very useful if you want to sell your downline to just give someone a nice gift!<br /><br />

<form action=\"index.php?view=account&ac=dlshift&action=shift&".$url_variables."\" method=\"post\" onsubmit=\"return confirm('This will move your ENTIRE downline, are you sure you want to do this?')\">
<input type=\"text\" name=\"to\">
<input type=\"submit\" value=\"Shift Downline\">
</form>
";
}
?>