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
function get_banner() {
	global $settings, $Db1, $username, $LOGGED_IN;
	$sql=$Db1->query("SELECT * FROM banners WHERE credits>=1 and (daily_limit>views_today or daily_limit=0) ".iif($LOGGED_IN==true," and username!='$username'")." order by rand() limit 1");
	$banner = $Db1->fetch_array($sql);
	$Db1->query("UPDATE banners SET credits=credits-1, views=views+1, views_today=views_today+1 WHERE id='$banner[id]'");
	if($banner[banner] != "") {
		$banner[html] = "<a href=\"bannerclick.php?id=$banner[id]\" target=\"_blank\"><img src=\"$banner[banner]\" border=0\" width=\"468\" height=\"60\"></a>";
	}
	return $banner[html];
}


function get_cr() {
	global $settings, $Db1;
	$sql=$Db1->query("SELECT * FROM code_rotator WHERE (wcount < weight) and (tcount < `limit` or `limit`=0) LIMIT 1");
	if($Db1->num_rows() !=0) {
		$temp=$Db1->fetch_array($sql);
		$rcode=$temp[code];
	}
	else {
		$Db1->query("UPDATE code_rotator SET wcount='0' WHERE wcount >= weight");
		$sql=$Db1->query("SELECT * FROM code_rotator WHERE (wcount < weight) and (tcount < `limit` or `limit`=0) LIMIT 1");
		if($Db1->num_rows() !=0) {
			$temp=$Db1->fetch_array($sql);
			$rcode=$temp[code];
		}
	}
	if($rcode != "") {
		$rcode=stripslashes($rcode);
		$sql=$Db1->query("UPDATE code_rotator SET tcount=tcount+1, wcount=wcount+1 WHERE id='$temp[id]'");
	}
	return $rcode;
}

function get_content($title="",$content="", $width="100%", $height="100%") {
return "
<table cellpadding=0 cellspacing=0 class=\"contentareaborder\" width=\"$width\">
	<tr>
		<td>
			<table cellpadding=0 cellspacing=1 width=\"100%\">
				<tr>
					<td valign=\"top\" align=\"center\" class=\"titlebar\"><b>$title</b></td>
				</tr>
				<tr>
					<td bgcolor=\"white\" valign=\"top\">
						<table cellpadding=2 width=\"100%\" height=\"$height\" class=\"contentarea\">
							<tr>
								<td valign=\"top\">$content</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>	
";
}

$includes[admin_js]="
<script>
	var url_vars = \"".$url_variables."\";
	var ptc = ".iif(SETTING_PTC==true,"1","0").";
	var ptsu = ".iif(SETTING_PTSU==true,"1","0").";
	var ptp = ".iif(SETTING_PTP==true,"1","0").";
	var se  = ".iif(SETTING_SE==true,"1","0").";
	var ce  = ".iif(SETTING_CE==true,"1","0").";
	var ptr = ".iif(SETTING_PTR==true,"1","0").";
	var ptra = ".iif(SETTING_PTRA==true,"1","0").";
</script>
<script language=\"javascript\" src=\"sniffer.js\"></script>
<script language=\"javascript\" src=\"menu_vars.js\"></script>
<script language=\"javascript\" src=\"style.js\"></script>
";



##################### BANNER AD ##########################
$showbanner = 0;
$showcr = 0;


if($settings[banner_cr_rotate] == 1) {
	srand(time());
	$random = (rand()%2);
	if($random) $showbanner=1;
	else $showcr=1;
}
else {
	$showbanner=1;
}
if($showbanner == 1) {
	$pagebanner648 = get_banner();
	if($pagebanner648 == "") {
		if($settings[banner_cr_rotate] == 1) {
			$showcr=1;
		}
	}
}
if($showcr == 1) {
	$pagebanner648 = get_cr();
	if($pagebanner648 == "") {
		$pagebanner648 = get_banner();
	}
}


##################### CODE ROTATOR ##########################
if($settings[code_rotator] == 1) {
	$rcode=get_cr();
}




##################### FEATURED ADS ##########################
$sql=$Db1->query("SELECT * FROM fads WHERE credits>=1 and (daily_limit>views_today or daily_limit=0) ".iif($LOGGED_IN==true," and username!='$username'")." order by rand() limit 1");
$pagefad=$Db1->fetch_array($sql);
$sql=$Db1->query("UPDATE fads SET credits=credits-1, views=views+1, views_today=views_today+1 WHERE id='$pagefad[id]'");


##################### TOP CLICKERS ##########################
if($settings[top_clickers] == 1) {
	$sql=$Db1->query("SELECT username, clicked_today FROM user ORDER BY clicked_today DESC LIMIT $settings[top_clickers_show]");
	for($d=1; $temp=$Db1->fetch_array($sql); $d++) {
		$honored.="$d. $temp[username] ".iif($settings[top_clickers_show_clicks]==1, "(".$temp[clicked_today].")")."<br />";
	}
}


##################### FEATURED LINKS ##########################
if($settings[flink_style] == 2) {
	$sql=$Db1->query("SELECT * FROM flinks WHERE dend>'".time()."' order by rand() ".iif($settings[flink_show]!=0,"limit $settings[flink_show]")."");
	while($temp=$Db1->fetch_array($sql)) {
		$idlist.=", $temp[id]";
		$linklist.="<div".iif($temp[bgcolor]!=""," style=\"background-color: $temp[bgcolor]\"")."><a href=\"flinkclick.php?id=$temp[id]\" target=\"_blank\">".iif($temp[marquee]==1,"<marquee>".ucwords(strtolower($temp[title]))."</marquee>","$temp[title]")."</a></div><hr>";
	}
	$sql=$Db1->query("UPDATE flinks SET views=views+1 WHERE id IN (0".$idlist.")");
	
	srand(time());
	$random = (rand()%2);
}
else if($settings[flink_style] == 1) {
	$sql=$Db1->query("SELECT * FROM flinks WHERE dend > '".time()."' order by dsub ".iif($settings[flink_show]!=0,"limit $settings[flink_show]")."");
	$totalt=$Db1->num_rows();
	for($x=0; $x<(ceil($totalt/4)); $x++) {
		$flinks.="<tr>";	
		for($y=0; $y<4; $y++) {
			$temp=$Db1->fetch_array($sql);
			if($temp[title]=="") {
				$flinks.="<td bgcolor=\"white\" align=\"center\" width=100><marquee><b><a href=\"$settings[flinkdefaulturl]\">$settings[flinkdefault]</a></b></marquee></td>";
			}
			else {
				$flinks.="<td width=\"100\" align=\"center\"".iif($temp[bgcolor]!=""," style=\"background-color: $temp[bgcolor]\"")."><a href=\"flinkclick.php?id=$temp[id]\" target=\"_blank\">".iif($temp[marquee]==1,"<marquee>".ucwords(strtolower($temp[title]))."</marquee>","$temp[title]")."</a></div></td>";
			}
		}
		$flinks.="</tr>";
	}
	$sql=$Db1->query("UPDATE flinks SET views=views+1");
}





if(($settings[poll_active] == 1) && (($random == 1) || ($settings[alt_fb_poll] == 0))) {
	$pollshow=0;
}
if(($settings[poll_active] == 0) || ($random == 0) || ($settings[alt_fb_poll] == 0)) {
	$fbannershow=1;
}


$areacontent="";


if($pollshow == 1) {
	$sql=$Db1->query("SELECT * FROM poll_history WHERE ip='$vip'");
	if($Db1->num_rows() == 0) {
		$polltitle="Poll";
		$polltext="
		<b>$settings[poll_title]</b><br />
		<small>
		".iif($settings[poll_a1] != "", "<input type=\"radio\" name=\"pollres\" value=\"1\" onclick=\"document.pollvote.sub.disabled=false\">$settings[poll_a1]<br />")."
		".iif($settings[poll_a2] != "", "<input type=\"radio\" name=\"pollres\" value=\"2\" onclick=\"document.pollvote.sub.disabled=false\">$settings[poll_a2]<br />")."
		".iif($settings[poll_a3] != "", "<input type=\"radio\" name=\"pollres\" value=\"3\" onclick=\"document.pollvote.sub.disabled=false\">$settings[poll_a3]<br />")."
		".iif($settings[poll_a4] != "", "<input type=\"radio\" name=\"pollres\" value=\"4\" onclick=\"document.pollvote.sub.disabled=false\">$settings[poll_a4]<br />")."
		".iif($settings[poll_a5] != "", "<input type=\"radio\" name=\"pollres\" value=\"5\" onclick=\"document.pollvote.sub.disabled=false\">$settings[poll_a5]<br />")."
		</small>
		<div align=\"center\"><input type=\"submit\" value=\"Vote!\" name=\"sub\" disabled=\"true\"></div>
		";
	}
	else {
		$polltitle="Poll Results";
		
		if($settings[poll_votes] == "") $settings[poll_votes]="0:0:0:0:0";
		$ptemp=explode(":",$settings[poll_votes]);
		for($x=0; $x<5; $x++) {
			if($ptemp[$x] == "") {
				$ptemp[$x]="0";
			}
			$pollresults[$x+1]=$ptemp[$x];
		}
		$polltext="
		<b>$settings[poll_title]</b><br />
		<small>
		".iif($settings[poll_a1] != "", "<li>$settings[poll_a1] : $pollresults[1]<br />")."
		".iif($settings[poll_a2] != "", "<li>$settings[poll_a2] : $pollresults[2]<br />")."
		".iif($settings[poll_a3] != "", "<li>$settings[poll_a3] : $pollresults[3]<br />")."
		".iif($settings[poll_a4] != "", "<li>$settings[poll_a4] : $pollresults[4]<br />")."
		".iif($settings[poll_a5] != "", "<li>$settings[poll_a5] : $pollresults[5]<br />")."
		</small>
		";
	}
	$areacontent.= "<form name=\"pollvote\" action=\"pollvote.php?action=vote&".$url_variables."\" method=\"post\">".get_content("$polltitle", "$polltext", 180)."</form>";
}

if($fbannershow == 1) {
	$sql=$Db1->query("SELECT * FROM fbanners WHERE credits>=1 and (daily_limit>views_today or daily_limit=0) ".iif($LOGGED_IN==true," and username!='$username'")." order by rand() limit 1");
	$pagebanner180=$Db1->fetch_array($sql);
	$sql=$Db1->query("UPDATE fbanners SET credits=credits-1, views=views+1, views_today=views_today+1 WHERE id='$pagebanner180[id]'");
	if($pagebanner180[id] != "") {
		$areacontent.="<a href=\"fbannerclick.php?id=$pagebanner180[id]\" target=\"_blank\"><img src=\"$pagebanner180[banner]\" border=0\" width=\"180\" height=\"100\"></a><br /><br />";
	}
}

?>