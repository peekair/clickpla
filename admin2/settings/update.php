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
function updatesettings($settings) {
	$newfile="<?\n//**"."VS*"."*//$setting[settings]//**"."VE"."**//\n\$settings = array(\n";
	foreach ($settings as $title => $setting) {
		$newfile.="\"$title\"=>\"$setting\",\n";
	}
	$newfile.=");\n?>";
	
	$input="./includes/settings.php";
	$fpwrite = fopen($input, "w+");
	fputs($fpwrite, $newfile);
}
?>