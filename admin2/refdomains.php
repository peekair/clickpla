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
$includes[title]="Top Referral Domains";

if($action == "clear") {
	$Db1->query("DELETE FROM refdomains");
}

$sql=$Db1->query("SELECT COUNT(domain) AS total FROM refdomains");
$temp1=$Db1->fetch_array($sql);
$total=$temp1[total];

if($count == "") {
	$count=20;
}

$sql=$Db1->query("SELECT * FROM refdomains ORDER BY hits DESC LIMIT $count");
while($domain = $Db1->fetch_array($sql)) {
	
	$list.="
	<tr>
		<td>".iif($domain[domain]=="","No Referer","<a href=\"http://$domain[domain]\" target=\"_blank\">$domain[domain]</a>")."</td>
		<td>$domain[hits]</td>
		<td>".iif($domain[domain]!="","<a href=\"admin.php?view=admin&ac=domainblocker&action=block&domain=$domain[domain]&".$url_variables."\" onclick=\"return confirm('Are you sure you want to block $domain[domain] ?')\">Block Domain</a>")."</td>
	</tr>
	";
}

$includes[content]="
<form action=\"admin.php?view=admin&ac=refdomains&".$url_variables."\" method=\"post\">
Referral Domains Logged: $total<br />
View Top <input type=\"text\" value=\"$count\" name=\"count\" size=3> <input type=\"submit\" value=\"Update\">
</form>

<table>
	<tr>
		<td width=100><b>Domain</b></td>
		<td width=50><b>Hits</b></td>
		<td></td>
	</tr>
	$list
</table>

<br/><br/>

<a href=\"admin.php?ac=refdomains&action=clear\" onclick=\"return confirm('Are you sure?')\">Clear History</a>

";

?>
