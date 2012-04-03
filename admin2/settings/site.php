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
$includes[title]="Site Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["homepage_stats"] 	= 		"$homepage_stats";
$settings["track_refers"]		=		"$track_refers";
$settings["block_domains"]		=		"$block_domains";
$settings["banned_goto"]		=		"$banned_goto";
$settings["verify_emails"]		=		"$verify_emails";
$settings["template"]			=		"$template";
$settings["site_title"] 	 	= 		"$site_title";
$settings["base_url"]			=		"$base_url";
$settings["domain_name"]		=		"$domain_name";
$settings["admin_email"] 	 	= 		"$admin_email";
$settings["flinkdefault"]		=		"$flinkdefault";
$settings["flinkdefaulturl"]	=		"$flinkdefaulturl";
$settings["floodguard_on"]			=		"$floodguard_on";
$settings["floodguard_hits"]		=		"$floodguard_hits";
$settings["floodguard_seconds"]	=		"$floodguard_seconds";
$settings["floodguard_foward"]		=		"$floodguard_foward";
$settings["orphan_allow"]			=		"$orphan_allow";
$settings["flink_style"] 	=	"$flink_style";
$settings["flink_show"] 	=	"$flink_show";
$settings["balance"]		=	"$balance";
$settings["points"]		=	"$points";
$settings["code_rotator"]	= "$code_rotator";
$settings["fbanner_show"] 		=		"$fbanner_show";
$settings["fbanner_w"] 			=		"$fbanner_w";
$settings["fbanner_h"] 			=		"$fbanner_h";
$settings["fads_show"] 			=		"$fads_show";
$settings["fads_title"] 		=		"$fads_title";
$settings["fads_desc"] 			=		"$fads_desc";

$settings["fad_title_limit"]	=	"$fad_title_limit";
$settings["fad_desc_limit"]	=	"$fad_desc_limit";
$settings["login_route"]	=	"$login_route";
$settings["footprints"]	=	"$footprints";
$settings["banner_cr_rotate"]	=	"$banner_cr_rotate";

$settings["nem_goto"]	=	"$nem_goto";
$settings["block_nem"]	=	"$block_nem";
$settings["lbref_on"]		=	"$lbref_on";
$settings["forum_on"]		=	"$forum_on";
$settings["apass"]			=		"$apass";

include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=site&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=site&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Homepage Stats:</b><br /><small>Do you want site stats to be displayed on the homepage?</small></td>
		<td><input type=\"checkbox\" name=\"homepage_stats\" value=\"1\"".iif($settings[homepage_stats]==1," Checked=\"Checked\"")."></td>
	</tr>
<tr>
		<td width=\"250\"><b>Enable Site Forum: </b><br /><small>Do you Want to enable integrated forum ?</td>
		<td><input type=\"checkbox\" name=\"forum_on\" value=\"1\"".iif($settings[forum_on] == 1," checked=\"checked\"")."></td>
	</tr>
<tr>
		<td width=\"250\"><b>Show Referral Leaderboard: </b><br /><small>Do you Want to Show Ref Leader board on My Account Section ?</td>
		<td><input type=\"checkbox\" name=\"lbref_on\" value=\"1\"".iif($settings[lbref_on] == 1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Balance Options:</b><br /><small>Allow members to carry cash balance and request payout?</small></td>
		<td><input type=\"checkbox\" name=\"balance\" value=\"1\"".iif($settings[balance]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Points Options:</b><br /><small>Allow members to carry a point balance?</small></td>
		<td><input type=\"checkbox\" name=\"points\" value=\"1\"".iif($settings[points]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Rotate Code Rotator With Banners:</b><br /><small>Rotate the code rotator and banners?</small></td>
		<td><input type=\"checkbox\" name=\"banner_cr_rotate\" value=\"1\"".iif($settings[banner_cr_rotate]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Code Rotator:</b><br /><small>Enable the banner code rotator?</small></td>
		<td><input type=\"checkbox\" name=\"code_rotator\" value=\"1\"".iif($settings[code_rotator]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Require Email Verification:</b></td>
		<td><input type=\"checkbox\" name=\"verify_emails\" value=\"1\"".iif($settings[verify_emails]==1," Checked=\"Checked\"")."></td>
	</tr>
    
       
	<tr>
		<td width=\"250\"><b>Track Footprints: ".show_help("This will log every page viewed by members. The logging includes the URL, their username, and the ip address accessed from. This is a good feature to investigating cheaters.")."</b></td>
		<td><input type=\"checkbox\" name=\"footprints\" value=\"1\"".iif($settings[footprints]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Login Route Code:</b> ".show_help("This option allows you to require all members to enter a random 4 digit code in order to login. The GD image library must be installed on your server! If you see a 4 digit code displayed to the right, then your server is compatible with this feature.")."</td>
		<td><input type=\"checkbox\" name=\"login_route\" value=\"1\"".iif($settings[login_route]==1," Checked=\"Checked\"")."> <img src=\"captcha.jpg\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Track Referrer Domains:</b><br /><small>Do you want to track the sites where hits come from?</small></td>
		<td><input type=\"checkbox\" name=\"track_refers\" value=\"1\"".iif($settings[track_refers]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Block Domains:</b><br /><small>Do you want a visitor to be denied if they come from a banned domain?</small></td>
		<td><input type=\"checkbox\" name=\"block_domains\" value=\"1\"".iif($settings[block_domains]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Denied Foward URL: </b><br /><small>If a visitor is sent from a banned domain, where should they be directed?</small></td>
		<td><input type=\"text\" name=\"banned_goto\" value=\"$settings[banned_goto]\" size=\"30\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Defer Traffic:</b><br /><small>Should a visitor be denied if they are sent to a referral URL of a non-exsistent, deleted, or suspended member??</small></td>
		<td><input type=\"checkbox\" name=\"block_nem\" value=\"1\"".iif($settings[block_nem]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Defered Foward URL: </b><br /><small>If a visitor is defered from above setting, where should they be directed?</small></td>
		<td><input type=\"text\" name=\"nem_goto\" value=\"$settings[nem_goto]\" size=\"30\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Floodguard Protection:</b><br /><small>Foward a viewer if they load the site too many times?</small></td>
		<td>
				<input type=\"checkbox\" name=\"floodguard_on\" value=\"1\"".iif($settings[floodguard_on]==1," Checked=\"Checked\"").">
				Allow <input type=\"text\" name=\"floodguard_hits\" value=\"$settings[floodguard_hits]\" size=3> Hits Per 
				<input type=\"text\" name=\"floodguard_seconds\" value=\"$settings[floodguard_seconds]\" size=3> Seconds
			</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Floodguard Foward: </b><br /><small>If a visitor is blocked from the floodguard, where should they be directed?</small></td>
		<td><input type=\"text\" name=\"floodguard_foward\" value=\"$settings[floodguard_foward]\" size=\"30\"></td>
	</tr>
<tr>
		<td width=\"250\"><b>Admin Panel Password: </b></small></td>
		<td><input type=\"text\" name=\"apass\" value=\"$settings[apass]\" size=\"20\"> <small>If Edited Clear Your Browser Cookies after you have Saved to avoid lockout</small></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Template Name: </b></small></td>
		<td><input type=\"text\" name=\"template\" value=\"$settings[template]\" size=\"20\"> <small>Editing this will change the Site Template! Ensure this setting matches the name of the template in /templates/ folder.</small></td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>Site Title: </b></small></td>
		<td><input type=\"text\" name=\"site_title\" value=\"$settings[site_title]\" size=\"30\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Base Url: </b></small></td>
		<td><input type=\"text\" name=\"base_url\" value=\"$settings[base_url]\" size=\"30\"> <small>e.g. http://domain.com (No Forward Slash at the end)</small></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Domain: </b></small></td>
		<td><input type=\"text\" name=\"domain_name\" value=\"$settings[domain_name]\" size=\"30\"> <small>e.g. domain.com (No http://)</small></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Admin Email Address: </b></small></td>
		<td><input type=\"text\" name=\"admin_email\" value=\"$settings[admin_email]\" size=\"30\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Orphan Referrals To Allocate: </b><br /><small>How many signups with no referrer should be registered with no upline? (for selling)</small></td>
		<td><input type=\"text\" name=\"orphan_allow\" value=\"$settings[orphan_allow]\" size=\"2\">%</td>
	</tr>
	<tr>
	<td><u><b>Featured Ads</b></u></tr>
	</tr>
	<tr>
		<td width=\"250\"><b>F. Ad Title Char Limit: </b></small></td>
		<td><input type=\"text\" name=\"fad_title_limit\" value=\"$settings[fad_title_limit]\" size=\"3\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>F. Ad Desc Char Limit: </b></small></td>
		<td><input type=\"text\" name=\"fad_desc_limit\" value=\"$settings[fad_desc_limit]\" size=\"3\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Feat. Ads To Show: </b><br /><small>0 = All</small></td>
		<td><input type=\"text\" name=\"fads_show\" value=\"$settings[fads_show]\" size=\"3\"></td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<table>
				<tr>
					<td colspan=\"2\"><b>Featured Ads Color</b></td>
				</tr>
				<tr>
					<td>Title
					</td>
					<td><input type=\"text\" name=\"fads_title\" value=\"$settings[fads_title]\" size=\"12\">
					</td>
				</tr>
				<tr>
					<td>Description
					</td>
					<td><input type=\"text\" name=\"fads_desc\" value=\"$settings[fads_desc]\" size=\"12\">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	<td><u><b>Featured Links</b></u></tr>
	</tr>
	<tr>
		<td width=\"250\"><b>Feat. Links To Show: </b><br /><small>0 = All</small></td>
		<td><input type=\"text\" name=\"flink_show\" value=\"$settings[flink_show]\" size=\"3\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Feat. Link Style: </b></small></td>
		<td>
			<select name=\"flink_style\">
				<option value=\"1\"".iif($settings[flink_style] == 1," selected=\"selected\"").">Table Below Content
				<option value=\"2\"".iif($settings[flink_style] == 2," selected=\"selected\"").">Menu Box
			</select>
		</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Static Feat. Link URL: </b></small></td>
		<td><input type=\"text\" name=\"flinkdefaulturl\" value=\"$settings[flinkdefaulturl]\" size=\"30\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Static Feat. Link: </b></small></td>
		<td><input type=\"text\" name=\"flinkdefault\" value=\"$settings[flinkdefault]\" size=\"30\"></td>
	</tr>
	<tr>
	<td><u><b>Featured Banners</b></u></tr>
	</tr>
	<tr>
		<td width=\"250\"><b>Fea. Banners To Show: </b><br /><small>0 = All</small></td>
		<td><input type=\"text\" name=\"fbanner_show\" value=\"$settings[fbanner_show]\" size=\"3\"></td>
	</tr>
	<tr>
		<td>
		</td>
		<td>
			<table>
				<tr>
					<td colspan=\"2\"><b>Banner size Configure</b></td>
				</tr>
				<tr>
					<td style=\"width:80px;\">Width
					</td>
					<td><input type=\"text\" name=\"fbanner_w\" value=\"$settings[fbanner_w]\" size=\"12\"> px
					</td>
				</tr>
				<tr>
					<td>Height
					</td>
					<td><input type=\"text\" name=\"fbanner_h\" value=\"$settings[fbanner_h]\" size=\"12\"> px
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
<div align=\"right\"></div>
</form>
";
?>