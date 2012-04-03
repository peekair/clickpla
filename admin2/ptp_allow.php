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
$includes[title]="PTP Allowed Domains";
//**VS**//$setting[ptr]//**VE**//
//**S**//

if($action == "block") {
	if($domain != "") {
		$Db1->query("DELETE FROM ptp_allow WHERE domain='$domain'");
		$Db1->query("INSERT INTO ptp_allow SET domain='$domain'");
	}
}

if($action == "unblock") {
	$Db1->query("DELETE FROM ptp_allow WHERE domain='$domain'");
}

$sql = $Db1->query("SELECT * FROM ptp_allow ORDER BY domain");
while($temp=$Db1->fetch_array($sql)) {
	$list.="<option value=\"$temp[domain]\">$temp[domain]";
}

$includes[content]="
<small>This tool allows you to add domains to the PTP allowed list. Note: Be sure that the PTP settings are correct and that \"Only Pay for Allowed Referrers\" is selected.</small>

<div align=\"center\">

<form action=\"admin.php?view=admin&ac=ptp_allow&action=block&".$url_variables."\" method=\"post\">
<b>Add Domain</b><br />
Domain: <input type=\"text\" name=\"domain\"> <input type=\"submit\" value=\"Add Domain\"><br />
<small>Enter just the domain, no 'www.'  Example: <b>domain.com</b></small>
</form>


<form action=\"admin.php?view=admin&ac=ptp_allow&action=unblock&".$url_variables."\" method=\"post\" name=\"form2\">
<select name=\"domain\" size=5>
	$list
</select>
<br />
<input type=\"submit\" value=\"Remove Domain\"><br />
<input type=\"button\" value=\"View Domain\" onclick=\"window.open('http://'+document.form2.domain.value)\">

</form>

</div>
";

//**E**//

?>
