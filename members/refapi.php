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
$includes[title]="Referral API";

$includes[content]="
This tool allows you to export a list of your 1st level referrals to an external program or script in real time. This could be used for many things including paid to signup and offering special commissions to referral signups.

<br /><br />

<a href=\"http://www.$settings[domain_name]/refapi.php?username=$username&access=".md5($thismemberinfo[password])."\">View API</a><br />
Url: <input type=\"text\" value=\"http://www.$settings[domain_name]/refapi.php?username=$username&access=".md5($thismemberinfo[password])."\" size=\"100\">

<br /><br />

The list is outputed with the format of 1 referral username per line (\\"."n)
";

?>