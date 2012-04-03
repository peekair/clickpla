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

$sql=$Db1->query("SELECT userid, last_ip FROM user WHERE verifyCo='0' LIMIT 100");
$count = $Db1->num_rows();
while($tmp = $Db1->fetch_array($sql)) {
	$co = lookupIp($tmp[last_ip]);
	if($co) {
		echo "$tmp[userid] : $tmp[last_ip] : $co <br />";
		$Db1->query("UPDATE user SET verifyCo='1', country='$co' WHERE userid='".$tmp[userid]."'");
	}
	else {
		$Db1->query("UPDATE user SET verifyCo='2' WHERE userid='".$tmp[userid]."'");
		echo "$tmp[userid] : $tmp[last_ip] : <b>not found</b><br />";
	}
}

if($count > 0) {
	$Db1->sql_close();
?>
<script>
setTimeout(function() {
	location.reload();
},500);
</script>
<?
	exit;
}
else $includes[content]="Done!";

//echo lookupIp("199.2.101.159");

?>