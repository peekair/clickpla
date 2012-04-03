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
//**VS**//$setting[ptsu]//**VE**//
if($settings[ptsuon] == 1) {
//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if($sort == "") $sort=2;

if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="pamount";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";


$subDomainEx = array(
"myworldresults.com",
"yourgiftsfree.com",
"prowealthsuccess.com",
"prowealthresults.com",
"myworldpower.com",
"myworldmovie.com",
"getacaiplus.com",
"freestoreclub.com",
"edcgold.com",
"payitforward4profits.com"
);

function isDomainEx($domain) {
	global $subDomainEx;
	$return = false;
	for($x=0; $x<count($subDomainEx); $x++) {
		if(substr_count($domain, $subDomainEx[$x]) > 0) {
			$return = $subDomainEx[$x];
		}
	}
	return $return;
}

/*
$sql=$Db1->query("SELECT * FROM ptsuads");
while($temp=$Db1->fetch_array($sql)) {
	$tmp = parse_url($temp[target]);
	$tmp2 = strtolower(str_replace("www.","",$tmp[host]));
	if($tmp2 == " http") {
		$temp[target] = trim($temp[target]);
		$tmp = parse_url($temp[target]);
		$tmp2 = str_replace("www.","",$tmp[host]);
	}
	if(($tmp[host] != "") && ($tmp2 != "")) {
		if($tmp2 == " http") {echo "<b style=\"color: red\">$temp[target]</b><br />";}
//		echo "$tmp2 : $temp[target]<br />";
		
		
		$tmp3 = isDomainEx($tmp2);
		if($tmp3 != false) {
			$tmp2 = $tmp3;
			echo "$tmp2<br />";
		}
		
		$Db1->query("UPDATE ptsuads SET domain='".ucfirst($tmp2)."' WHERE id='$temp[id]'");
	}
}*/



$sql=$Db1->query("SELECT * FROM ptsu_history WHERE username='$username'");
if($Db1->num_rows() != 0) {
	$temp=$Db1->fetch_array($sql);
	$preclicked=$temp[clicks];
}
if($preclicked == "") {
	$preclicked=":0:";
}

$totalptc=0;
$sql=$Db1->query("SELECT * FROM ptsuads WHERE credits>=1 and active='1' GROUP BY domain");
$totalSpons = $Db1->num_rows();
if($totalSpons != 0) {
	for($x=0; $ad=$Db1->fetch_array($sql); $x++) {
		if(findclick($preclicked, $ad[id]) == 0) {
			$totalptc++;
			$adsptc.="
	<tr".iif($ad[bgcolor]!=""," bgcolor=\"$ad[bgcolor]\"")." id=\"col$x\">
		<td height=21 nowrap=\"nowrap\"><a href=\"index.php?view=account&ac=do_ptsu&id=$ad[id]&".$url_variables."\">".parse_link(ucwords(strtolower(stripslashes($ad[domain]))))."</a></td>
		<td width=100>".iif($ad['class']=="P","$ad[pamount] Points","$cursym $ad[pamount]")."</td>
	</tr>
		";
		}
	}
}


$sql=$Db1->query("SELECT COUNT(id) as total FROM ptsuads WHERE credits>=1 and active='1'");




//**E**//

$includes[title]="Get Paid To Signup";
$includes[content].="

<style>
.ptsuSortBox {
	float: right; 
	border: 1px solid black; 
	padding: 0 5 0 5px; 
	background-color: white;
	margin: 0 5 0 10px;
	font-weight: bold;
}
.ptsuSortBox a {
	color: black;
}


.ptsuSortBox2 {
	float: right; 
	border: 1px solid black; 
	padding: 0 5 0 5px; 
	background-color: black;
	margin: 0 5 0 10px;
	font-weight: bold;
}
.ptsuSortBox2 a {
	color: white;
}

</style>

<div style=\"float: right\" style=\"font-size: 13px;\">
<a href=\"index.php?view=account&ac=ptsu_history&".$url_variables."\">View Offer Completion History & Stats</a>
</div>



".iif($totalptc>0, "
<table width=\"300\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=\"left\">$totalSpons Current Sponsors</td>
	</tr>
</table>
")."

<hr>

<div style=\"padding: 2 5 2 5px\">
	<div class=\"ptsuSortBox".iif($sort==1,"2")."\"><a href=\"index.php?view=account&ac=ptsu&sort=1&".$url_variables."\">Costs To Join</a></div>
	<div class=\"ptsuSortBox".iif($sort==0,"2")."\"><a href=\"index.php?view=account&ac=ptsu&sort=0&".$url_variables."\">Free To Join</a></div>
	<div class=\"ptsuSortBox".iif($sort==2,"2")."\"><a href=\"index.php?view=account&ac=ptsu&sort=2&".$url_variables."\">View All</a></div>
	
	<div style=\"float: right; padding: 2 0 0 0px\">Sort Offers By:</div>

	<div style=\"clear: both;\"></div>
</div>

<hr>

".iif($totalptc==0, "There are no PTSU offers available for you at this time.","<small>$totalptc Offers Available</small>")."


".iif($settings[ptc_list] && $totalptc>0,"

".iif($totalptc>0,"<div style=\"height: ".iif($totalptc < 8,($totalptc*22+1),170)."; overflow: auto; border: 1px solid gray; padding: 0 5 0 5px;\">")."
<table width=\"100%\" cellpadding=0 cellspacing=0>
	$adsptc
</table>
</div>")."




";
}
else {
	$includes[content]="PTSU is currently disabled by admin!";
}

?>
