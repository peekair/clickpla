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
$includes[title]="Country Targeting";

if($action == "save") {
	$Db1->query("DELETE FROM target_co");
	for($x=0; $x<count($newList); $x++) {
//		echo $newList[$x]."<br />";
		$Db1->query("INSERT INTO target_co SET country='".$newList[$x]."'");
	}
	$msg = "Your changes have been saved!<br /><br />";
}

$sql=$Db1->query("SELECT * FROM target_co");
while($temp=$Db1->fetch_array($sql)) {
	$target[$temp[country]]=true;
}
$total_country=$Db1->querySingle("SELECT COUNT(id) AS total FROM target_co WHERE country=''$target[country]","total");

$sql=$Db1->query("SELECT DISTINCT country FROM user WHERE country!='' ORDER BY country");
while($temp=$Db1->fetch_array($sql)) {
	$list.="<option value=\"$temp[country]\" ".iif($target[$temp[country]]==true," selected=\"selected\"").">$temp[country] - $total_country[country]</option>";
}

$includes[content]="
$msg

<form action=\"admin.php?ac=settings&type=targeting&action=save&".$url_variables."\" method=\"post\">

Targeting Allowed For Selected Countries:<br />
<select name=\"newList[]\" size=20 multiple=\"true\">
	$list
</select>

<input type=\"submit\" value=\"Save\">

</form>

";

?>