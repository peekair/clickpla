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
$includes[title]="Member Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["point_ratio"]	= 	"$point_ratio";
$settings["credit_ratio"] 	= 	"$credit_ratio";
$settings["upline_earnings"]= 	"$upline_earnings";
$settings["allow_retract"]	=	"$allow_retract";
$settings["login_redirect"]	=	"$login_redirect";
$settings["allow_self_ref"]	=	"$allow_self_ref";
$settings["contact"]	=	"$contact";
$settings["ref_levels"]		=	"$ref_levels";
$settings["claimon"]		=	"$claimon";
$settings["minimum_ads"]		=	"$minimum_ads";

$settings["ad_alert_group"]		=	"$ad_alert_group";
$settings["new_ad_alert"]		=	"$new_ad_alert";

$settings["ad_alert_ptc"]		=	"$ad_alert_ptc";
$settings["ad_alert_ptsu"]		=	"$ad_alert_ptsu";
$settings["ad_alert_ptra"]		=	"$ad_alert_ptra";


$settings["deny_multiple_ips"]		=	"$deny_multiple_ips";

$settings["shifteron"]                          = "$shifteron";
$settings["adminapprove"]   = "$adminapprove";
$settings["adminapproved"]   = "$adminapproved";

$settings["bonusclaim"] = "$bonusclaim";
$settings["xcreditjoin"] = "$xcreditjoin";
$settings["payment_notifier"]			=	"$payment_notifier";
$settings["notifier_email"]			=	"$notifier_email";
$settings["join_ptc"]		=	"$join_ptc";
$settings["join_banner"]	=	"$join_banner";
$settings["join_fad"] = "$join_fad";
$settings["join_cash"] = "$join_cash";
$settings["join_fban"]		=	"$join_fban";
$settings["join_mailc"]	=	"$join_mailc";
$settings["join_points"] = "$join_points";
$settings["join_ptr"] = "$join_ptr";
$settings["join_ptsu"] = "$join_ptsu";
$settings["join_ptpc"] = "$join_ptpc";
$settings["ref_notifier"]			=	"$ref_notifier";
$settings["cheatfailed"]			=	"$cheatfailed";
$settings["nomfw"]			=		"$nomfw";

include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=member&saved=1&".$url_variables."");
}

for($x=1; $x<=5; $x++) {
	$reflevels.="<option value=\"$x\"".iif($x==$settings[ref_levels]," selected=\"selected\"").">$x";
}

$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=member&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Login Redirect: </b>".show_help("Where should members be redirected when they login? (must have a ? or & variable seperator at the end!)")."</td>
		<td><input type=\"text\" name=\"login_redirect\" value=\"$settings[login_redirect]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Downline Earnings: </b>".show_help("How much does each member earn their upline? 0.05 = 5%")."</td>
		<td><input type=\"text\" name=\"upline_earnings\" value=\"$settings[upline_earnings]\"> (0.05 = 5%)</td>
	</tr>

	<tr>
		<td width=\"250\"><b>Support Username: </b>".show_help("When a member needs to contact admin the message will go to this username straight into their onsite message inbox")."</td>
		<td><input type=\"text\" name=\"contact\" value=\"$settings[contact]\"> </td>
	</tr>
		<tr>
		<td width=\"250\"><b>Downline Levels: </b>".show_help("How many levels should there be?")."</td>
		<td><select name=\"ref_levels\">$reflevels</select></td>
	</tr>
        <tr>
		<td width=\"250\"><b>Warning Lockout Level: </b></small></td>
		<td><input type=\"text\" name=\"nomfw\" value=\"$settings[nomfw]\" size=\"3\"></td>
	</tr>
<tr>
		<td width=\"250\"><b>Cheat Check Fails For Suspension: </b></small></td>
		<td><input type=\"text\" name=\"cheatfailed\" value=\"$settings[cheatfailed]\" size=\"3\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Allow Credit Retractions: </b>".show_help("Can the members retract their ad credits?")."</td>
		<td><input type=\"checkbox\" name=\"allow_retract\" value=\"1\"".iif($settings[allow_retract] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Allow Self Referrals: </b>".show_help("If the member is in their own downline, should they receive referral comissions from themself?")."</td>
		<td><input type=\"checkbox\" name=\"allow_self_ref\" value=\"1\"".iif($settings[allow_self_ref] == 1," checked=\"checked\"")."></td>
	</tr>
	
	<tr><td style=\"height: 10px;\"></td></tr>
	
	<tr>
		<td width=\"250\"><b>Only Allow 1 Account Per IP: </b>".show_help("Deny user registration if their IP address is already in use on another account")."</td>
		<td><input type=\"checkbox\" name=\"deny_multiple_ips\" value=\"1\"".iif($settings[deny_multiple_ips] == 1," checked=\"checked\"")."></td>
	</tr>
	
	<tr><td style=\"height: 10px;\"></td></tr>
	
	<tr>
		<td width=\"250\"><b>New Ad Email Alerts: </b>".show_help("Email members when new ads are available?")."</td>
		<td><input type=\"checkbox\" name=\"new_ad_alert\" value=\"1\"".iif($settings[new_ad_alert] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Allow Alerts For: </b>".show_help("Which members should email alerts be available for?")."</td>
		<td><select name=\"ad_alert_group\">
			<option value=\"1\"".iif($settings[ad_alert_group] == 1," selected=\"selected\"").">Premium Members Only
			<option value=\"2\"".iif($settings[ad_alert_group] == 2," selected=\"selected\"").">All Members
		</select></td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>PTC Alerts: </b></td>
		<td><input type=\"checkbox\" name=\"ad_alert_ptc\" value=\"1\"".iif($settings[ad_alert_ptc] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>PTSU Alerts: </b></td>
		<td><input type=\"checkbox\" name=\"ad_alert_ptsu\" value=\"1\"".iif($settings[ad_alert_ptsu] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>PTRA Alerts: </b></td>
		<td><input type=\"checkbox\" name=\"ad_alert_ptra\" value=\"1\"".iif($settings[ad_alert_ptra] == 1," checked=\"checked\"")."></td>
	</tr><tr>
<td width=\"250\"><b>Minimum Required ads to click</b></td>
<td><input type=\"text\" size=\"4\" name=\"minimum_ads\" 
value=\"$settings[minimum_ads]\"></td></tr>


	<tr>
		<td width=\"250\"><b>Receive Payment Requests in email?: </b></td>
		<td><input type=\"checkbox\" name=\"payment_notifier\" value=\"1\"".iif($settings[payment_notifier] == 1," checked=\"checked\"")."></td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>Notifier e-mail: </b></td>
		<td><input type=\"text\" name=\"notifier_email\" value=\"$settings[notifier_email]\"> </td>
	</tr>


".iif(SETTING_SWAP==true,"
<tr>
<td width=\"250\"><b>Claim bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"bonusclaim\" 
value=\"$settings[bonusclaim]\"></td></tr>



<tr>
		<td width=\"250\"><b>Bonus Claim : </b></td>
		<td><input type=\"checkbox\" name=\"claimon\" value=\"1\"".iif($settings[claimon] == 1," checked=\"checked\"")."></td>
	</tr>")."
	<tr>
		<td width=\"250\"><b>Downline Shifter: </b></td>
		<td><input type=\"checkbox\" name=\"shifteron\" value=\"1\"".iif($settings[shifteron] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Disable Manual Admin Approval?: </b><br><small> For members joining-unchecking the box will make it so you have to approve them. </td>
		<td><input type=\"checkbox\" name=\"adminapprove\" value=\"1\"".iif($settings[adminapprove] == 1," checked=\"checked\"")."></td>
	</tr>

<tr>
		<td width=\"250\"><b>Display features disabled notice if pending/unapproved?</td>
		<td><input type=\"checkbox\" name=\"adminapproved\" value=\"1\"".iif($settings[adminapproved] == 1," checked=\"checked\"")."></td>
	</tr>
<tr>
		<td width=\"250\"><b>Notify Member on New Ref?: </b></td>
		<td><input type=\"checkbox\" name=\"ref_notifier\" value=\"1\"".iif($settings[ref_notifier] == 1," checked=\"checked\"")."></td>
	</tr>

<tr>
<td width=\"250\"><b>Sign up Cash Credit Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_cash\" 
value=\"$settings[join_cash]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up Point Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_points\" 
value=\"$settings[join_points]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up PTC Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_ptc\" 
value=\"$settings[join_ptc]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up PTR Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_ptr\" 
value=\"$settings[join_ptr]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up Email Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_mailc\" 
value=\"$settings[join_mailc]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up PTSU Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_ptsu\" 
value=\"$settings[join_ptsu]\"><small>&nbsp;0 for no signup bonus</small></td></tr>


<tr>
<td width=\"250\"><b>Sign up Xcredits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"xcreditjoin\" 
value=\"$settings[xcreditjoin]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up Banner Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_banner\" 
value=\"$settings[join_banner]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up F.Banner Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_fban\" 
value=\"$settings[join_fban]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

<tr>
<td width=\"250\"><b>Sign up Feat Ad Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_fad\" 
value=\"$settings[join_fad]\"><small>&nbsp;0 for no signup bonus</small></td></tr>


<tr>
<td width=\"250\"><b>Sign up PTP Credits Bonus</b></td>
<td><input type=\"text\" size=\"4\" name=\"join_ptpc\" 
value=\"$settings[join_ptpc]\"><small>&nbsp;0 for no signup bonus</small></td></tr>

	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	
<br>
	
</table>
<div align=\"right\"></div>
</form>
";
//**E**//
?>
