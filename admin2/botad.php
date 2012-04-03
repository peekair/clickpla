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

$includes[title]="Bot Ad Setup";



$includes[content]="


<center>
<fieldset><legend>Setting up your Bot Detector</legend>
<br>
<b>NOTICE</b> <br>
Please make sure your surf all links feature is disabled in the ptc settings, if it's not disabled, and people use the surf all links, their accounts will get automatically deleted.<br><br>
<font color=\"red\"><font size=\"4\">WARNING!!! DO NOT VIEW THIS LINK WHILE LOGGED IN!</font></font>
Step 1: <input type=\"text\" value=\"http://www.$settings[domain_name]/gptnet.php\" size=\"50\"><br>THIS ONE ZEROES OUT BALANCES : <input type=\"text\" value=\"http://www.$settings[domain_name]/gptnet1.php\" size=\"50\"><br>
Copy the above url and open Manage ads for PTR or PTC and paste it in the second text field in the form for creating a new ad.
<br><br>
Step 2: In the first text field, hit the space bar several times and add about 10,000 credits to the ad (10000)(no commas). Finish out the form. Add a value to the ad make sure it's a class/cash add and not a point ad , bots can probably detect and block point ads from being clicked on.
<br><br>
<b>Tips</b><br>
Try to avoid placing the bot detector in paid email ads, click exchange ads ect.. The only place it should go is PTR section, and PTC Section as long as the surf all links is disabled.
<br><br>


";
?>