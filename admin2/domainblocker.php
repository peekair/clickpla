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
$includes[title]="Domain Blocker";

if($action == "block") {
	if($domain != "") {
		$Db1->query("DELETE FROM blocklist WHERE domain='$domain'");
		$Db1->query("INSERT INTO blocklist SET domain='$domain'");
	}
}

if($action == "unblock") {
	$Db1->query("DELETE FROM blocklist WHERE domain='$domain'");
}

$sql = $Db1->query("SELECT * FROM blocklist ORDER BY domain");
while($temp=$Db1->fetch_array($sql)) {
	$list.="<option value=\"$temp[domain]\">$temp[domain]";
}

$includes[content]="
<div align=\"center\">

<form action=\"admin.php?view=admin&ac=domainblocker&action=block&".$url_variables."\" method=\"post\" onsubmit=\"return confirm('Are you sure you want to block this domain?')\">
<b>Block Domain</b><br />
Domain: <input type=\"text\" name=\"domain\"> <input type=\"submit\" value=\"Block Domain\"><br />
<small>Enter just the domain, no 'www.'  Example: <b>domain.com</b></small>
</form>


<form action=\"admin.php?view=admin&ac=domainblocker&action=unblock&".$url_variables."\" method=\"post\" name=\"form2\">
<select name=\"domain\" size=5>
	$list
</select>
<br />
<input type=\"submit\" value=\"Unblock Domain\"><br />
<input type=\"button\" value=\"View Domain\" onclick=\"window.open('http://'+document.form2.domain.value)\">

</form>

</div>
";

?>
