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
$includes[title]="Cheat Check Failures";

if($action == "suspend") {
	for($y=0; $y<count($selected); $y++) {
		echo "<!-- Checking Acount -->\n";
		flush();
		$x=$selected[$y];
		$id=$selectedid[$x];
		$sql=$Db1->query("SELECT * FROM cheat_failed WHERE id='$id'");
		$temp=$Db1->fetch_array($sql);
		$Db1->query("DELETE FROM cheat_failed WHERE id='$id'");
		$sql=$Db1->query("SELECT notes FROM user WHERE username='$temp[username]'");
		$user=$Db1->fetch_array($sql);
		$Db1->query("UPDATE user SET suspended='1',
             suspendTime='-1',
		suspendMsg='".addslashes(stripslashes(stripslashes($user[suspendMsg])))."\n\nTo many Cheat Check Fails!',
		notes='".addslashes(stripslashes(stripslashes($user[notes])))."\n\nSuspended by Cheat Check!'
		
		 WHERE username='$temp[username]'");
	 	$msg.="Suspending $temp[username]<br />";
	}
}
else if($action == "delete") {
	
	for($y=0; $y<count($selected); $y++) {
		
		flush();
		$x=$selected[$y];
		$id=$selectedid[$x];
		$sql=$Db1->query("SELECT * FROM cheat_failed WHERE id='$id'");
		$temp=$Db1->fetch_array($sql);
		$Db1->query("DELETE FROM cheat_failed WHERE id='$id'");
		$sql=$Db1->query("SELECT notes FROM user WHERE username='$temp[username]'");
		$user=$Db1->fetch_array($sql);
		$sql=$Db1->query("SELECT * FROM user WHERE username='$temp[username]'");
		$userinfo=$Db1->fetch_array($sql);
		if(SETTING_PTC == true)   $Db1->query("DELETE FROM ads WHERE username='$userinfo[username]'");
		if(SETTING_PTR == true)   $Db1->query("DELETE FROM emails WHERE username='$userinfo[username]'");
		if(SETTING_PTRA == true)  $Db1->query("DELETE FROM ptrads WHERE username='$userinfo[username]'");
		if(SETTING_PTSU == true)  $Db1->query("DELETE FROM ptsuads WHERE username='$userinfo[username]'");
		if(SETTING_PTP == true)   $Db1->query("DELETE FROM popups WHERE username='$userinfo[username]'");
		if(SETTING_CE == true)    $Db1->query("DELETE FROM xsites WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM banners WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM fbanners WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM fads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM flinks WHERE username='$userinfo[username]'");
		$Db1->query("UPDATE user SET refered='' WHERE refered='".$userinfo[username]."' ");
		$Db1->query("UPDATE user SET notes='".$userinfo[notes]."\n---------------\nDeleted By Cheat Check fails!' WHERE userid='$userinfo[userid]'");
		$Db1->query("INSERT INTO user_deleted SELECT * FROM user WHERE userid='$userinfo[userid]'");
		$Db1->query("DELETE FROM user WHERE userid='$userinfo[userid]'");
//		echo " : $k ";
	}
	$Db1->sql_close();
	$sql=$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=cheat_check_failed&".$url_variables."");
	
}
else if($action == "clean") {
	
	for($y=0; $y<count($selected); $y++) {
		
		flush();
		$x=$selected[$y];
		$id=$selectedid[$x];
		$sql=$Db1->query("SELECT * FROM cheat_failed WHERE id='$id'");
		$temp=$Db1->fetch_array($sql);
		$Db1->query("DELETE FROM cheat_failed WHERE id='$id'");

//		echo " : $k ";
	}
	$Db1->sql_close();
	$sql=$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=cheat_check_failed&".$url_variables."");
	
}




$sql=$Db1->query("SELECT cheat_failed.*, user.cheat_checks FROM cheat_failed, user WHERE user.username=cheat_failed.username ORDER BY cheat_failed.failed DESC");
for($x=0; $temp = $Db1->fetch_array($sql); $x++) {
	$list.="
	<tr>
		<td width=10>
			<input type=\"hidden\" name=\"selectedid[$x]\" value=\"".$temp['id']."\">
			<input type=\"checkbox\" name=\"selected[]\" value=\"$x\"></td>
		<td><a href=\"admin.php?view=admin&ac=edit_user&uname=$temp[username]&".$url_variables."\">$temp[username]</td>
		<td>$temp[failed]</td>
		<td>$temp[failed_today]</td>
		<td>$temp[cheat_checks]</td>
		<td>".date('M d, Y', mktime(0,0,$temp[last_failed],1,1,1970))."</td>
	</tr>
	";
}
if($Db1->num_rows() == 0) $list="<tr><td colspan=6>No logs found</td></tr>";

$includes[content]="
$msg
<form action=\"admin.php?view=admin&ac=cheat_check_failed&".$url_variables."\" method=\"post\">
<table  class=\"tableData\">
	<tr>
		<th></th>
		<th><b>Username</b></th>
		<th><b>Failed</b></th>
		<th><b>Today</b></th>
		<th><b>Checks</b></th>
		<th><b>Last Fail</b></th>
	</tr>
$list
</table>
<hr>
With selected: <select name=\"action\">
	<option value=\"suspend\">Suspend Users
	<option value=\"delete\">Delete Users
	<option value=\"clean\">Just Clean the Fails
</select>
<input type=\"submit\" value=\"Go\">
</form>
";

?>
