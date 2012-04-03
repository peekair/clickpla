		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="/js/jquery.sexy-captcha-0.1.js"></script>
		<link rel="stylesheet" type="text/css" media="all" href="/css/sexy-captcha/captcha.css" />
<?
//**S**//
function new_session($userid, $lifespan="3600", $ipvoid) {
	global $vip, $Db1;
	$expirytime = (string) (time() - $lifespan);
	$delresult = $Db1->query("DELETE FROM sessions WHERE start_time<$expirytime or user_id='$userid'");
	$found=false;
	do {
		$sessid = rand_string(20);
		$sessid2 = rand_string(5);
		$sql=$Db1->query("SELECT * FROM sessions WHERE (sess_id = '$sessid') AND (sess_id2='$sessid2')");
		if($Db1->num_rows() == 0) {
			$found=true;
		}
	} while ($found == false);
	$currtime = (string) (time());
	$sql = $Db1->query("INSERT INTO sessions SET
		sess_id='$sessid',
		sess_id2='$sessid2',
		user_id='$userid',
		start_time='$currtime',
		remote_ip='$vip',
		ipvoid='$ipvoid'
		");
	return array($sessid, $sessid2);
}



if($action == "login") {
	$Db1->query("UPDATE user SET lockout='' WHERE lockout!='' and lockout<".time()."");
	if($settings[login_route] == 1) {
		$correct_code=0;
		$sql=$Db1->query("SELECT * FROM route_codes WHERE id='$rid'");
		$temp=$Db1->fetch_array($sql);
		if(($routing_code != $temp[code]) || ($routing_code == "") || ($rid == "")) {
			$correct_code=0;
		}
		else {
			$correct_code=1;
		}
		$Db1->query("DELETE FROM route_codes WHERE id='$rid'");
		$Db1->query("DELETE FROM route_codes WHERE dsub<".(time()-600)."");
	}
	if(($correct_code==0) && ($settings[login_route] == 1)) {
		$msg="<div align=\"center\"><b>Login Error!</b></div><br />You did not enter the correct routing number! Please try again.";
	}
	elseif(($form_user != "") && ($form_pwd != "")) {
		$sql=$Db1->query("SELECT userid, password, username,suspended, suspendTime, suspendMsg,verified, permission, lockout FROM user WHERE username='$form_user'");
		if($Db1->num_rows() != 0) {
			$userinfo = $Db1->fetch_array($sql);
			if(($userinfo[username] == $form_user) && ($userinfo[password] == md5($form_pwd))) {
			
include("./geoip.inc");
$handle = geoip_open("./GeoIP.dat", GEOIP_STANDARD);
$co = geoip_country_name_by_addr($handle, $vip);
geoip_close($handle);
$Db1->query("UPDATE user SET country='$co' WHERE username='$form_user'");


				if($userinfo[suspended]==1) {
					$LOGGED_IN=false;
					$msg = "<div align=\"center\"><b>Login Error!</b></div><br />Your account has been suspended. ".iif($userinfo['suspendTime']>1,"Your suspension is only temporary and you will automatically be unsuspended in ".ceil( (($userinfo['suspendTime']-time())/60/60/24) )." days.")."
					<br/><br/>
					".iif($userinfo['suspendMsg']!="","<strong>Message From Admin: </strong> ".$userinfo['suspendMsg']."")."
					";
				}
				else if($userinfo[lockout] > time()) {
					$LOGGED_IN=false;
					$msg = "<div align=\"center\"><b>Login Error!</b></div><br />Your account is temporarily locked. Your account will be unlocked in ";
					$remaining=($userinfo[lockout]-time())/60;
					if($remaining < 1) $msg.="<b>Less than 1 minute.</b>";
					else $msg.="<b>".floor($remaining)." minutes.</b>";
				}
				else if(($userinfo[verified]==0) && ($settings[verify_emails] == 1)) {
					$Db1->sql_close();
					header("Location: index.php?view=resend_act&action=resend&uname=$form_user&".$url_variables."");
					exit;
					$LOGGED_IN=false;
					$msg = "<div align=\"center\"><b>Login Error!</b></div><br />Your email address has not been verified.<br />
						<li><a href=\"index.php?view=verify\">Enter Activation Code</a>
						<li><a href=\"index.php?view=resend_act\">Resend Activation Code</a>
						<li><a href=\"index.php?view=update_email\">Change My Email Address</a>
					";
				}
				else {
					$userid=$userinfo[userid];
					$username=$userinfo[username];
					$permission=$userinfo[permission];
					session_start();
					$sessids = new_session($userid,"3600",$ipvoid);
					$sessid=$sessids[0];
					$sessid2=$sessids[1];
					$sessiduid=$userid;
					session_register('sessid');
					session_register('sessid2');
					session_register('sessiduid');
					$session_sessid=$sessid;
					$session_sessid2=$sessid2;
					$session_sessiduid=$sessiduid;
					$_SESSION["sessid"] = $sessid;
					$_SESSION["sessid2"] = $sessid2;
					$_SESSION["sessiduid"] = $sessiduid;
					$Db1->sql_close();
					header("Location: setcookies.php?".iif(isset($returnTo),"view=$returnTo","view=account&ac=main")."".iif("$id","&id=$id").iif($ptype,"&ptype=$ptype").iif($step,"&step=$step")."".iif(isset($ac),"&ac=$ac")."&sid=$sessid&sid2=$sessid2&siduid=$userid");
					exit;
				}
			}
			else {
				$LOGGED_IN=false;
				$msg = "<div align=\"center\"><b>Login Error!</b></div><br />There was a problem signing in..";
			}

		}
		else {
			$sql=$Db1->query("SELECT * FROM user_deleted WHERE username='$form_user'");
			if($Db1->num_rows() != 0) {
				$msg = "<div align=\"center\"><b>Login Error!</b></div><br />This account has been deleted! If you find this to be a mistake, please contact us for more information..";
			}
			else {
				$msg = "<div align=\"center\"><b>Login Error!</b></div><br />Your account cannot be found in our database!";
			}
		}
	}
	else {
		$msg = "<div align=\"center\"><b>Login Error!</b></div><br />There was a problem signing in..";
	}

}

if($msg != "") {
	$Db1->query("UPDATE user SET failed_logins=failed_logins+1 WHERE username='$form_user'");
}





$includes[content]="
<font color=\"darkred\">$msg</font>
<div align=\"center\">
<form action=\"index.php?view=login&action=login&".iif($rid!="","rid=$rid&")."".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
	<input type=\"hidden\" value=\"$returnTo\" name=\"returnTo\">
	<input type=\"hidden\" value=\"$id\" name=\"id\">
	<input type=\"hidden\" value=\"$ac\" name=\"ac\">
	<input type=\"hidden\" value=\"$step\" name=\"step\">
	<input type=\"hidden\" value=\"$ptype\" name=\"ptype\">
			
			<table cellpadding=0 cellspacing=1 class=\"tableStyle loginTable\">
				<tr>
					<th colspan=2 class=\"main\">Member Login</th>
				</tr>
				<tr>
					<th>Username</th>
					<td><input type=\"text\" class=\"login\" size=\"15\" name=\"form_user\"></td>
				</tr>
				<tr>
					<th>Password</th>
					<td><input type=\"password\" class=\"login\" size=\"15\" name=\"form_pwd\"></td>
				</tr>
				<tr>
					<td colspan=2><input type=\"checkbox\" name=\"ipvoid\" value=\"1\"> Do not lock session to my IP address </td>
				</tr>


				".iif($settings[login_route]==1,"
			
            
          <tr>
				<td class=\"tableHL10\" align=\"center\">


<div style=\"font-family: arial; font-size: 12px; width: 433px; margin-bottom: 10px; padding: 0 10px;\">Let's make sure you're human.  Drag or click the correct shape on the left to move it to the grey drop area on the right.</div>
		<div class=\"myCaptcha\"></div>


		<script>
  $('document').ready(function() {
    $('.myCaptcha').sexyCaptcha('captcha.process.php');
  }); 
</script>
</td>
<td>

visitor ip proxy info






</td>
</tr>
			
            
            
            
            
            	")."

				<tr>
					<td colspan=2 class=\"submit\"><input type=\"submit\" value=\"Login\" class=\"login_submit\"></td>
				</tr>
			</table>

<small>
<a href=\"index.php?view=join&".$url_variables."\">Join Now</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"index.php?view=lostpwd&".$url_variables."\">Lost Password</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"index.php?view=verify&".$url_variables."\">Activate Account</a>
</small>


</form></div>

";
?>