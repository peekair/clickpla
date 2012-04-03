 <script type="text/javascript">
function nospaces(t){
if(t.value.match(/\s/g)){
$error_msg="Sorry, you are not allowed to enter any spaces";
t.value=t.value.replace(/\s/g,'');
}
}
</script>
<?
//##########################################################################
//#    AURORAGPT Script Copyright owned by Mike Pratt & John Terrell       #
//#                        ALL RIGHTS RESERVED 2007-2014                   #
//#                                                                        #
//#        Any illegal use of this script is strictly prohibited unless    # 
//#        permission is given by the owner of this script.  To sell       # 
//#        this script you must have a resellers license. Your site        #
//#        must also use a unique encrypted license key for your           #
//#        site. Your site must also have site_info module and             #
//#        key.php file must be in the script unedited. Otherwise          #
//#        it will be considered as unlicensed and can be shut down        #
//#        legally by Illusive Web Services. By using AuroraGPT            #
//#        script you agree not to copy infringe any of the coding         #
//#        and or create a clone version is also copy infringement         #
//#        and will be considered just that and legal action will be       #
//#        taken if neccessary. 					   #
//########################################################################// 

$includes['title']="Register A Free Account";
function edit_upline($x, $ref) {
	global $uUsername, $Db1;
	if($x <= 5) {
		if($uUsername != $ref) {
			$sql=$Db1->query("SELECT * FROM user WHERE username='$ref'");
			$thisuser=$Db1->fetch_array($sql);
			$sql=$Db1->query("UPDATE user SET referrals".($x)."=referrals".($x)."+1".iif($x==1,", week_refs=week_refs+1").", referrals=referrals+1 WHERE username='$ref'");
			if((isset($thisuser[refered])) && ($thisuser[refered] != $ref)) {
				edit_upline(($x+1), $thisuser[refered]);
			}
		}
	}
}
if($action == "join") {

    //------------------------------------------
    // By default, captchas failed / not enabled
    //------------------------------------------
    $recaptcha_pass = 0;
    $old_captcha_pass = 0;

    //------------------------------------------
    // Validate old style captcha
    //------------------------------------------
    if($settings['login_router2'] == 1) {

        if((int)$rid > 0) {

            $sql=$Db1->query("SELECT * FROM route_codes WHERE id='$rid'");
            $temp=$Db1->fetch_array($sql);

            if($routing_code == $temp['code']) {
                $old_captcha_pass = 1;
            }

            $Db1->query("DELETE FROM route_codes WHERE id='$rid'");
        }

		$Db1->query("DELETE FROM route_codes WHERE dsub<".(time()-600)."");
	}

    //------------------------------------------
    // Validate recaptcha
    //------------------------------------------
    if($settings['login_router'] == 1) {

        require_once('./includes/recaptchalib.php');
        $privatekey = "6Ld8BQYAAAAAACuqMQrofE-yfMCC_4T5HFCHXDA_";
        $resp = recaptcha_check_answer ($privatekey,
                                    $_SERVER["REMOTE_ADDR"],
                                    $_POST["recaptcha_challenge_field"],
                                    $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
            $recaptcha_pass = 1;
        }
    }

    //------------------------------------------
    // Determine captcha pass
    //------------------------------------------
    if((int)$settings['login_router'] == $recaptcha_pass AND (int)$settings['login_router2'] == $old_captcha_pass) {
        $correct_code = 1;
    } else {
        $correct_code = 0;
    }

	$uName = trim($_POST['uName']);
	$uEmail = $_POST['uEmail'];
	$uUsername = $_POST['uUsername'];
	$uPassword = $_POST['uPassword'];
	$uVPassword = $_POST['uVPassword'];
        $uPin = $_POST['uPin'];
	$uVPin = $_POST['uVPin'];
	$reff = $_POST['reff'];
include("./geoip.inc");
$handle = geoip_open("./GeoIP.dat", GEOIP_STANDARD);
$co = geoip_country_name_by_addr($handle, $vip);

    if($reff == $uUsername) {
		$reff="";
	}

    if(!$correct_code) {
        $error="<div align=\"center\"><b>Login Error!</b></div><br />You did not enter the correct routing number! Please try again.";
    }
	if($Db1->querySingle("SELECT count(id) as total FROM country_blacklist WHERE country='".mysql_real_escape_string(strtolower($co))."'","total") > 0) {
		$error = "Sorry, your country has been blacklisted from our program.";
	}    
	else if($Db1->querySingle("SELECT COUNT(id) as total FROM email_block WHERE account='$uEmail'","total") != 0) {
		$error="The email address you have entered is banned!";
	}
	else if(($settings["deny_multiple_ips"] == 1) && (($Db1->querySingle("SELECT COUNT(userid) as total FROM user WHERE last_ip='$vip'","total")>0?true:false) == true)) {
		$error="Your IP address is already in use! We only allow 1 account per IP address.";
	}
	else if(is_email_blocked($uEmail) > 0) {
		$error="You have been banned from our program.";
		$sql=$Db1->query("INSERT INTO logs SET username='".$uUsername."', log='Attempted to join with blocked email address ($uEmail)', dsub='".time()."'");
	}
	else if($uVPassword != $uPassword) {
		$error="Your passwords do not match!";
	}
        	else if($uVPin != $uPin) {
		$error="Your personal pin codes do not match!";
	}
	else if((strlen($uUsername) < 4)) {
		$error="Your username has to be at least 4 characters long.";
	}
	else if((strlen($uPassword) < 5)) {
		$error="Enter a password at least 5 characters long.";
	}
	else if((strlen($uPin) < 4)) {
		$error="Enter a personal pin at least 4 characters long.";
	}
	else if(empty($uName)) {
		$error="Enter your full name.";
	}
	else if( ereg("[^A-Za-z0-9\]", $uUsername) ){
  		$error="Your username can only contain A-Z, a-z, 0-9";
	}  
	else if (Verify_Email_Address($uEmail) == false) {
		$error="Enter a valid email address.";
	}
	else if($uTerms != "yes") {
		$error="You must agree to the terms.";
	}
	else  {
		if($reff == "") {
			srand((double)microtime()*1000000); 
			$num = mt_rand(1,100);
			if($num > $settings['orphan_allow']) {
				$sql=$Db1->query("SELECT username FROM user WHERE type='1' ORDER BY rand() LIMIT 1");
				$newref=$Db1->fetch_array($sql);
				$reff=$newref[username];
			}
		}
                			       $Db1->query("UPDATE user SET lbref=lbref+1 WHERE username='$reff'");
			
             if($settings[ref_notifier] == "1" ){
			 
			 $email=$Db1->query("SELECT * FROM user WHERE username='$reff'");

			$ur=$Db1->fetch_array($email);
                       if ($ur[ref_notifier] == "1"){
			$mm = "	$uUsername just joined under you on $settings[site_title] / Admin Bot ";
			$from="$settings[domain_name] Admin <$settings[admin_email]>";
			$to = "$ur[email]";
			$headers = "From: $from\r\n" . "Reply-To: $from\r\n" . "X-Mailer: Php";
			$subject="You Have A New Referral on $settings[domain_name]!";
			@mail($to,$subject,$mm,$headers);
}
			 }
		$sql=$Db1->query("SELECT userid FROM user WHERE username='$uUsername' OR email='$uEmail'");
		if($Db1->num_rows() == 0) {
			$sql=$Db1->query("INSERT INTO user SET
			name='".htmlentities(addslashes($uName))."',
			username='".htmlentities(addslashes($uUsername))."',
			password='".md5($uPassword)."',
                        pin='".md5($uPin)."',
			email='".htmlentities(addslashes($uEmail))."',
			refered='".htmlentities(addslashes($reff))."',
			last_ip='$vip',
			join_ip='$vip',
			balance='$settings[join_cash]',
			country='$co', 
			verifyCo='1',
			verified='".iif($settings[verify_emails] == 1,"0","1")."',
			joined='".time()."',
			last_act='".time()."',
			optin='1',
			moptin='1',
			xcredits='$settings[xcreditjoin]',
			link_credits='$settings[join_ptc]',
			banner_credits='$settings[join_banner]',
			ptra_credits='$settings[join_ptr]',
           	points='$settings[join_points]',
           	ptsu_credits='$settings[join_ptsu]',
           	ptr_credits='$settings[join_mailc]',
           	fbanner_credits='$settings[join_fban]',
           	fad_credits='$settings[join_fad]',
    	    confirm='$settings[adminapprove]'
			

");
			$sql=$Db1->query("SELECT * FROM user WHERE username='$uUsername'");
			$user=$Db1->fetch_array($sql);
			if($reff != "") {
				if($settings[tickets_ref] > 0) {
					$Db1->query("UPDATE user SET tickets=tickets+$settings[tickets_ref] WHERE username='$reff'");
				}
				edit_upline(1, $reff);
			}
			$sql=$Db1->query("SELECT * FROM tracker WHERE ip='$vip' ORDER BY dsub DESC LIMIT 1");
			if($Db1->num_rows() > 0) {
				$trackid=$Db1->fetch_array($sql);
				$sql=$Db1->query("UPDATE tracker SET register=register+1 WHERE id='$trackid[id]'");
			}
			$today_date=date("d/m/y");
			$sql=$Db1->query("SELECT id FROM stats WHERE date='$today_date'");
			if($Db1->num_rows() == 0) {
				$sql-$Db1->query("INSERT INTO stats SET date='$today_date'");
			}
			$sql=$Db1->query("UPDATE stats SET new_members=new_members+1 WHERE date='$today_date'");
			
			if($settings[verify_emails] == 1) {
				send_act_email($uUsername);
				$Db1->sql_close();
				header("Location: index.php?view=verify&uname=$uUsername");
			}
			else {
				$Db1->sql_close();
				header("Location: index.php?view=welcome&uname=$uUsername");
			}
		}
		else {
			$error="There is already an open account using the username or email address you entered.";
		}
	}
}
else {
	$reff=$ref;
}

if($error != "") $includes[content].="<div class=\"error\">Error: $error</div>";
if($settings[login_router2]==1){
//	srand((double)microtime()*1000000);
//	$number = rand(1000,9999);
	$number = getrandRoute();
	$Db1->query("INSERT INTO route_codes SET
		code='$number',
		dsub='".time()."'
	");
	$sql=$Db1->query("SELECT id FROM route_codes WHERE
		code='$number' and
		dsub='".time()."'
	");
	$temp=$Db1->fetch_array($sql);
	$rid=$temp[id];
$cp="<img src=\"router.php?rid=$rid\"><br />
						Enter the routing code:
                        <input type='hidden' name='rid' value='$rid'>
						<input type=\"text\" name=\"routing_code\" size=4>
						<br />
						<small><a href=\"\" onclick=\"document.location.reload(); return false;\">Routing code not loading? Click Here To Refresh</a></small><br>";
}

?>
<form action="index.php?view=join&amp;action=join&amp;<?=$url_variables;?>" method="post">
<fieldset class="form signupForm">
	<h3>Account Details</h3>
	<div><label for="uUsername">Username</label> <input type="text" name="uUsername" id="uUsername" value="<?=$uUsername;?>" onkeyup="nospaces(this)"/><br /><p>Please select a unique username. You may only use letters and numbers.</p></div>
	<div><label for="uPassword">Password</label> <input type="password" name="uPassword" id="uPassword" value="<?=$uPassword;?>" />
	<br /><p>Please choose a unique password for your account.</p></div>
	<div><label for="uVPassword">Verify Password</label> <input type="password" name="uVPassword" id="uVPassword" value="<?=$uVPassword;?>" /><br /><p>Please re-enter your password.</p></div>
	<div><label for="uPassword">Personal Pin</label> <input type="pin" name="uPin" id="uPin" value="<?=$uPin;?>" /><br /><p>Please choose a unique personal pin for your account.<br>This will be used for withdrawals and updates to your account.</p></div>
	<div><label for="uVPassword">Verify Personal Pin</label> <input type="pin" name="uVPin" id="uVPin" value="<?=$uVPin;?>" /><br /><p>Please re-enter your pin.</p></div>
	<div><label for="reff">Referrer</label> <? echo ($reff==""?"<input type=\"text\" name=\"reff\" value=\"$reff\" />":"<input type=\"hidden\" name=\"reff\" value=\"$reff\" />$reff"); ?><br /><p>The member who referred you.</p></div>
	<h3>Personal Details</h3>
	<div><label for="uName">Your Name</label> <input type="text" name="uName" id="uName" value="<?=$uName;?>" /><br /><p>Please enter your full name.</p></div>
	<div><label for="uEmail">Your Email Address</label> <input type="text" name="uEmail" id="uEmail" value="<?=$uEmail;?>" /><br /><p>We will send you an activation email so be sure to enter a valid and current address.</p></div>
	<h3>Legal</h3>
	<div><label for="">I accept the <a href="index.php?view=terms&amp;<?=$url_variables;?>">Terms of Service</a></label>
		<select name="uTerms" id="uTerms">
			<option value="" selected="selected"></option>
			<option value="no">No, I Do Not Accept</option>
			<option value="yes">Yes, I Accept</option>
		</select><br /><p>Please take a moment and read the terms of service.</p></div>
</fieldset>
<center><?
require_once('./includes/recaptchalib.php');
if($settings[login_router]==1){
// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "6Ld8BQYAAAAAAEUxF638INVi-Jo8kTKX8s2PnoJU";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

echo recaptcha_get_html($publickey, $error);}?>
<?=$cp;?>
<div class="submit"><input type="submit" value="Create Account" /></div></center>
</form><br /><Br>
<? if ($settings[verify_emails]==1 ) echo "<p><strong>Important!</strong> - If you are using any sort of spam blocker or filters, your activation email may get filtered as junk, so be sure to check your junk folders if the email is not arriving to your inbox.</p>"; ?>