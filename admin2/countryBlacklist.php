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

if($_POST) {
	if($_POST['delete']) {
		$Db1->query("DELETE FROM country_blacklist WHERE id='{$_POST['blacklist']}'");
	}
	if($_POST['add']) {
		$country = mysql_real_escape_string(strtolower($_POST['country']));
		if($Db1->querySingle("SELECT count(id) as total FROM country_blacklist WHERE country='{$country}'","total") == 0) {
			$Db1->query("INSERT INTO country_blacklist SET country='{$country}'");
		}
	}
	$Db1->sql_close();
	header("Location: admin.php?ac=countryBlacklist&{$url_variables}");
	exit;
}

$sql = $Db1->query("SELECT * FROM country_blacklist ORDER BY country");
while(($row = $Db1->fetch_array($sql))) {
	$countryBlacklist.="<option value=\"{$row['id']}\">{$row['country']}</option>";
}

?>

<form action="admin.php?ac=countryBlacklist&{$url_variables}" method="post" onsubmit="return confirm('Are you sure?')">
<fieldset>
	<legend>Currently Blacklisted</legend>
		<select size="10" name="blacklist" style="width: 100%;">
			<?=$countryBlacklist;?>
		</select><br/>
		<input type="submit" value="Remove" name="delete"> 
</fieldset>
</form>


<form action="admin.php?ac=countryBlacklist&{$url_variables}" method="post" onsubmit="return confirm('Are you sure?')">
<fieldset>
	<legend>Add Country</legend>
	Country: <input type="text" name="country" /> <input type="submit" value="Blacklist" name="add" />
</fieldset>
</form>