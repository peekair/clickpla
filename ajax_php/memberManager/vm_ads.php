<?
include("ajax_php/memberManager/header.php");
global $user, $id;

if(SETTING_PTC == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM ads WHERE username='$user[username]'");
	$adstotal['links']=$Db1->fetch_array($sql);
}
if(SETTING_PTR == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM emails WHERE username='$user[username]'");
	$adstotal['emails']=$Db1->fetch_array($sql);
}
if(SETTING_PTRA == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM ptrads WHERE username='$user[username]'");
	$adstotal['ptrads']=$Db1->fetch_array($sql);
}
if(SETTING_PTP == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM popups WHERE username='$user[username]'");
	$adstotal['popups']=$Db1->fetch_array($sql);
}
if(SETTING_CE == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM xsites WHERE username='$user[username]'");
	$adstotal['xsites']=$Db1->fetch_array($sql);
}


$sql = $Db1->query("SELECT COUNT(id) AS total FROM banners WHERE username='$user[username]'");
$adstotal['banners']=$Db1->fetch_array($sql);

$sql = $Db1->query("SELECT COUNT(id) AS total FROM fbanners WHERE username='$user[username]'");
$adstotal['fbanners']=$Db1->fetch_array($sql);

$sql = $Db1->query("SELECT COUNT(id) AS total FROM flinks WHERE username='$user[username]'");
$adstotal['flinks']=$Db1->fetch_array($sql);

$sql = $Db1->query("SELECT COUNT(id) AS total FROM fads WHERE username='$user[username]'");
$adstotal['fads']=$Db1->fetch_array($sql);


echo "
<table>
<tr><td valign=\"top\">

<table width=200>
".iif(SETTING_PTC == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=links&search=1&search_str=$user[username]&search_by=username\">Paid Link Ads</a></td>
		<td>".$adstotal[links][total]."</td>
	</tr>
")."
".iif(SETTING_PTR == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=emails&search=1&search_str=$user[username]&search_by=username\">Email Ads</a></td>
		<td>".$adstotal[emails][total]."</td>
	</tr>
")."
".iif(SETTING_PTRA == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=ptrads&search=1&search_str=$user[username]&search_by=username\">PTR Ads</a></td>
		<td>".$adstotal[ptrads][total]."</td>
	</tr>
")."
".iif(SETTING_PTP == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=popups&search=1&search_str=$user[username]&search_by=username\">Popups</a></td>
		<td>".$adstotal[popups][total]."</td>
	</tr>
")."

</table>
</td>

<td width=20></td>

<td valign=\"top\">
<table width=200>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=banners&search=1&search_str=$user[username]&search_by=username\">Banners</a></td>
		<td>".$adstotal[banners][total]."</td>
	</tr>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=fbanners&search=1&search_str=$user[username]&search_by=username\">Featured Banners</a></td>
		<td>".$adstotal[fbanners][total]."</td>
	</tr>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=fads&search=1&search_str=$user[username]&search_by=username\">Featured Ads</a></td>
		<td>".$adstotal[fads][total]."</td>
	</tr>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=flinks&search=1&search_str=$user[username]&search_by=username\">Featured Links</a></td>
		<td>".$adstotal[flinks][total]."</td>
	</tr>
".iif(SETTING_CE == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=xsites&search=1&search_str=$user[username]&search_by=username\">Exchange Sites</a></td>
		<td>".$adstotal[xsites][total]."</td>
	</tr>
")."
</table>

</td></tr></table>";

?>