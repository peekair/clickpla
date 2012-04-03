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
$includes[title]="Referral Builder";

if($cat=="all") {
	$cat="%";
}

if($action == "update") {

	$sql=$Db1->query("SELECT db FROM user WHERE username='$username'");
	if($Db1->num_rows() != 0) {
		$temp=$Db1->fetch_array($sql);
		$temp2=explode("^^",$temp[db]);
		for($x=0; $x<count($temp2); $x++) {
			$temp3=explode("::",$temp2[$x]);
			$dbarray[$temp3[0]]=$temp3[1];
		}
	}

	for($x=0; $x<count($refid); $x++) {
		$dbarray[$dbid[$x]]=$refid[$x];
//		$newdblist[$x] .= $dbid[$x]."::".$refid[$x];
	}

	$x=0;
	foreach($dbarray as $tid => $tref) {
//		echo "<br /><br />$tid : $tref";
		$newdblist[$x]="$tid::$tref";
		$x++;
	}

	$thenew=implode("^^",$newdblist);
//	echo "<br /><br />new: ".$thenew;
	$sql=$Db1->query("UPDATE user SET db='".$thenew."' WHERE username='$username'");
	$Db1->sql_close();
	header("Location: index.php?view=account&ac=referralbuilder&".$url_variables."");

}

if($cat != "") {
	$sql=$Db1->query("SELECT * FROM dbl_cat WHERE id='$cat'");
	$category=$Db1->fetch_array($sql);

	$sql=$Db1->query("SELECT * FROM downline_builder WHERE category like '%:$cat:%' ORDER BY title");
	if($Db1->num_rows() != 0) {
		for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
			if($x%2) $color=1;
			else $color=2;

			$list.="
			<tr class=\"tableHL$color\">
				<td><li>$temp[title] ".iif($temp[description] != "",show_help($temp[description]))."</td>
				<td><input type=\"button\" value=\"Join\" onclick=\"window.open('$temp[url]".get_db_refid($temp[id])."')\"></td>
				<td>".iif($temp[type] == 0,"<input type=\"hidden\" name=\"dbid[$x]\" value=\"$temp[id]\"><input type=\"text\" name=\"refid[$x]\" value=\"".get_user_db_refid($temp[id])."\"> <input type=\"submit\" value=\"Update\">","non-affiliate")."</td>
			</tr>
			";
		}
	}

	$includes[content]="
<div align=\"right\">
	<a href=\"index.php?view=account&ac=referralbuilder&".$url_variables."\">Referral Builder</a> > ".iif($cat=="%","View All",$category[title])."
</div>
<div align=\"center\">

".iif($category[description] != "","<div class=\"tableHL1\" style=\"width: 300px; border: 1px black solid; padding: 5 5 5 5;\" align=\"left\"><b>$category[title]</b><br /><li>$category[description]</div>")."

<form action=\"index.php?view=account&ac=referralbuilder&action=update&".$url_variables."\" method=\"post\">
<table cellpadding=0 cellspacing=0>
	<tr>
		<td width=200><b>Program</b></td>
		<td width=70><b>Join</b></td>
		<td><b>Your Referral ID</b></td>
	</tr>
	$list

</table>
</form>
</div>
	";

}


if($cat == "") {
	$sql=$Db1->query("SELECT * FROM dbl_cat ORDER BY title");
	$totalc=$Db1->num_rows();
	$half=round($totalc/2);
	if($totalc%2 == 0) {
		$half++;
	}

	for($x=1; $cat=$Db1->fetch_array($sql); $x++) {
		$cats.="<li><a href=\"index.php?view=account&ac=referralbuilder&cat=$cat[id]&".$url_variables."\">$cat[title]</a>";
		if($x == $half) {
			$cats.="</td><td width=\"30\"></td><td valign=\"top\">";
		}
	}

$includes[content]="
<div align=\"center\">
<b>Select A Category:</b>
	<table>
		<tr>
			<td>
			$cats
			<li><a href=\"index.php?view=account&ac=referralbuilder&cat=all&".$url_variables."\">View All</a></td>
			</td>
			<td width=\"20\"></td>
		</tr>
	</table>
</div>

<small>
<br /><br />
<b>How It Works: </b><br />
In the categories above, you will find any great programs listed. If you are not already a member at any of the listed sites, click the \"join\" button and you will be directed to the program (in a new window). Once you are a member at a listed program, enter your referral ID in the provided box and update your information.
<br /><br />
Now whenever one of your referrals click on the \"join\" button, they will be sent to your referral URL at the listed program, in turn gaining you a new referral at the other program!
<br /><br />
This is a free feature for all of our members, so signup at all of the sites and add your referral ID to the system!
</small>
<div align=\"right\"><small><a href=\"index.php?view=contact&".$url_variables."\">If you would like to see a program added to the builder, contact us!</a></small></div>
";
}

?>