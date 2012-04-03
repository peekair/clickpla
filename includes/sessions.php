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
//**S**//
session_start();

if($sid != "") {
	$dt=$sid;
}
else  {
	$dt=$c_sid;
	$sid=$dt;
}


if($sid2 != "") {
	$dt2=$sid2;
}
else {
	$dt2=$c_sid2;
	$sid2=$dt2;
}


if($siduid != "") {
	$dtuid=$siduid;
}
else {
	$dtuid=$c_siduid;
	$siduid=$dtuid;
}



function get_userid_from_session($sessid, $sessid2, $uid) {
	global $vip, $Db1;
	$mintime = time() - 36000;
// AND (remote_ip = '$vip')
	$sql = $Db1->query("SELECT user_id FROM sessions WHERE (sess_id = '$sessid') AND (sess_id2='$sessid2') AND (user_id='$uid') and (remote_ip='$vip' or ipvoid='1')");
	$row = $Db1->fetch_array($sql);
	return $row[user_id];
}


function update_session_time($sessid, $sessid2) {
	global $Db1;
	$newtime = time();
	$result = $Db1->query("UPDATE sessions SET start_time='$newtime' WHERE (sess_id = '$sessid') AND (sess_id2='$sessid2')");
	return 1;
}

if($dt) {
	$userid=0;
	$sessid = $dt;
	$sessid2 = $dt2;
	$sessiduid = $dtuid;
	$userid = get_userid_from_session($sessid, $sessid2, $sessiduid);
	if (($userid != 0) && (isset($userid))) {
	   $sql=$Db1->query("SELECT * FROM user WHERE userid='$userid'");
	   $thismemberinfo=$Db1->fetch_array($sql);
	   if ($thismemberinfo[suspended] == 1) {
	   		$Db1->query("DELETE FROM sessions WHERE (sess_id = '$sessid') AND (sess_id2='$sessid2') ");
	   		$LOGGED_IN=false;
	}
	else {
		$LOGGED_IN = true;
		update_session_time($sessid, $sessid2, $sessiduid);
		$userid=$thismemberinfo[userid];
		$siduid=$userid;
		$username=$thismemberinfo[username];
		$permission=$thismemberinfo[permission];
		$sql=$Db1->query("UPDATE user SET last_ip='$vip', ad_alert_login='1' WHERE userid='$userid'");
	   } 
	 }
	 else {
	 	$HTTP_SESSION_VARS["sessid"]=0;
	 	$HTTP_SESSION_VARS["sessid2"]=0;
	 	$HTTP_SESSION_VARS["sessiduid"]=0;
		$sid="";
		$dt="";
	 }
}

else {
	$LOGGED_IN=false;
	$HTTP_SESSION_VARS["sessid"]=0;
	$HTTP_SESSION_VARS["sessid2"]=0;
	$HTTP_SESSION_VARS["sessiduid"]=0;
	$sid="";
	$sid2="";
	$siduid="";
	$dt="";
	$dt2="";
	$dtuid="";
}
//**E**//
?>