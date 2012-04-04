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
$specialPTP=true;

//$includes[title]="My Account";
$includes[title]="My Account Panel - ".$thismemberinfo[name];
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

//**S**//

$newmsgs=0;

$sql=$Db1->query("SELECT * FROM messages WHERE username='$username' ORDER BY dsub DESC");
$total = $Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
   if($temp[read] == 0) $newmsgs++;
}


$fee=0;

if($action == "save_auto" && getGroupPerm($username, 'denyRequests') != 1 && $settings[auto_pay_on]) {
		$Db1->query("UPDATE user SET
			auto_pay='".iif($auto_method!=0,"1","0")."',
			auto_account='".addslashes($auto_account)."',
			auto_method='".addslashes($auto_method)."'
		WHERE
			username='$username'
		");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=profile&".$url_variables."");
		exit;
}

if($action == "withdraw" && getGroupPerm($username, 'denyRequests') != 1 && $settings[request_pay_on]) {
	$hold="Withdraw";
	if($amount < $settings[withdraw_min]) {
		$error_msg="You must request at least $cursym $settings[withdraw_min]!";
	}
	else if(!isset($account) || $account=="") {
		$error_msg="You must enter a valid account id!";
	}
        else if(md5($spin) != $thismemberinfo[pin]) {
		$error_msg="You must enter a valid 4 digit pin number!";
	}
	else if($thismemberinfo[balance] >= $amount) {
		$sql=$Db1->query("SELECT * FROM withdraw_options WHERE id='$accounttype'");
		if($Db1->num_rows() != 0) {
			$method = $Db1->fetch_array($sql);
			
			if($thismemberinfo[type] == 0) {
					$fee=$method[fee];
					$min=$method[minimum];
			}
			else { 
				$fee=$method[fee_premium];
				$min = $method[minimum_premium];
			}
			
		
			if($min <= $amount) {
				$sql=$Db1->query("UPDATE user SET balance=balance-$amount WHERE username='$username'");

				$fee = ($fee/100);
				
				if($fee < $method[fee_min] && $fee > 0) $fee = $method[fee_min];
                
                $fee = $amount * $fee;
				
				$ramount=$amount-$fee;

				$sql=$Db1->query("INSERT INTO requests SET dsub='".time()."', fee='$fee', `amount`='$ramount', accounttype='$accounttype', username='$username', status='0', account='$account'");
				header("Location: index.php?view=account&ac=pendingwithdraw&hold=Withdraw&".$url_variables."&msg=$cursym $amount has been removed from your account and put in queue for payment");
			}
			else {
				$error_msg="You must withdraw at least !$method[minimum] with this payment method!";
			}
		}
		else {
			$error_msg="There was an error with the payment method you selected.";
		}
	}
	else {
		$includes[content]="You do not have sufficient funds available!";
	}
}

if($action == "ptr") {
	$hold="Pref";
	$Db1->query("UPDATE user SET optin='".addslashes($to)."' WHERE username='$username'");
	$Db1->sql_close();
	header("Location: index.php?view=account&hold=Pref&ac=profile&".$url_variables."");
}

if($action == "mailer") {
	$hold="Pref";
	$Db1->query("UPDATE user SET moptin='".addslashes($to)."' WHERE username='$username'");
	$Db1->sql_close();
	header("Location: index.php?view=account&hold=Pref&ac=profile&".$url_variables."");
}

if($action == "ref_notifier") {
	$hold="Pref";
	$Db1->query("UPDATE user SET ref_notifier='".addslashes($to)."' WHERE username='$username'");
	$Db1->sql_close();
	header("Location: index.php?view=account&hold=Pref&ac=profile&".$url_variables."");
}



if($action == "ad_alert") {
	$hold="Pref";
	$Db1->query("UPDATE user SET ad_alert='".addslashes($to)."' WHERE username='$username'");
	$Db1->sql_close();
	header("Location: index.php?view=account&hold=Pref&ac=profile&".$url_variables."");
}



if($action == "targeting") {
	$Db1->query("UPDATE user SET ".iif($sex!="","sex='".addslashes($sex)."',")." ".iif($birth!="","birth='".addslashes($birth)."',")." username='$username' WHERE username='$username'");
	$Db1->sql_close();
	header("Location: index.php?view=account&hold=Account&ac=profile&".$url_variables."");
}



//**E**//

if($action == "email") {
	$hold="Account";
	if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$cursym", $email)) {
		$error_msg="Enter a valid email address";
	}
else if(md5($spin) != $thismemberinfo[pin]) {
		$error_msg="You must enter a valid 4 digit pin number!";
	}
	else {
		$sql=$Db1->query("UPDATE user SET email='$email' WHERE username='$username'");
		if($settings[verify_emails] == 1) {
			$Db1->query("UPDATE user SET verified='0' WHERE username='$username'");
			send_act_email($username);
			$Db1->query("DELETE FROM sessions WHERE user_id = '$userid'");
			$Db1->sql_close();
			header("Location: index.php?view=verify&uname=$form_username");
			exit;
		}
		$Db1->sql_close();
		header("Location: index.php?view=account&hold=Account&ac=profile&".$url_variables."");
		exit;
	}
}
if($action == "set_pin") {
	$hold="Account";
	if (!eregi("^[0-9]{8}", $set_pin)) {
		$error_msg="Enter a valid pin number 4 digits long";
	}
	else {
		$sql=$Db1->query("UPDATE user SET pin='".md5($set_pin)."' WHERE username='$username'");
		$Db1->sql_close();
		header("Location: index.php?view=account&hold=Account&ac=profile&".$url_variables."");
		exit;
	}
}

if($action == "pwd") {
	$hold="Account";
	if((strlen($pwd) < 5)) {
		$error_msg="Enter a password at least 5 characters long.";
	}
	else if($pwd != $pwd2) {
		$error_msg="Your Passwords Did Not Match!";
	}
	else {
		$sql=$Db1->query("UPDATE user SET password='".md5($pwd)."' WHERE username='$username'");
		$Db1->sql_close();
		header("Location: index.php?view=account&hold=Account&ac=profile&".$url_variables."");
	}
}

$sql=$Db1->query("SELECT * FROM withdraw_options WHERE active='1' ORDER BY title");
while($temp=$Db1->fetch_array($sql)) {
//	$withdraw_options.="<option value=\"$temp[id]\">$temp[title] [$cursym $temp[minimum] Minimum]";



	if($thismemberinfo[type] == 0) {
			$fee=$temp[fee];
			$min=$temp[minimum];
	}
	else { 
		$fee=$temp[fee_premium];
		$min = $temp[minimum_premium];
	}

			
	if($fee > 0) $fee_min = $temp['fee_min'];
	else $fee_min=0;

	$withdraw_options.="
		<tr class=\"tableHL2\">
			<td width=2><input type=\"radio\" name=\"accounttype\" value=\"$temp[id]\" onclick=\"update($min,$fee,$fee_min,'$temp[verif]')\"></td>
			<td>$temp[title]</td>
			<td>$cursym ".number_format($min,2)."</td>
			<td>$fee %</td>
			<td align=\"center\" style=\"padding: 0 0 0 0\">".iif(($temp[minimum] > $thismemberinfo[balance]),"<img src=\"images/ball_red.gif\">")."".iif(($temp[minimum] <= $thismemberinfo[balance]),"<img src=\"images/ball_green.gif\">")."</td>
		</tr>
		";
	$withdraw_options2.="
		<tr class=\"tableHL2\">
			<td width=2><input type=\"radio\" name=\"auto_method\" value=\"$temp[id]\"".iif($temp[id] == $thismemberinfo[auto_method]," checked=checked")."></td>
			<td>$temp[title]</td>
			<td>$cursym ".number_format($min,2)."</td>
			<td>$fee %</td>
		</tr>
		";
}


$sql=$Db1->query("SELECT SUM(amount) AS total FROM requests WHERE username='$username'");
$temp=$Db1->fetch_array($sql);
$thismemberinfo['pending_payments']=$temp[total];

$sql=$Db1->query("SELECT SUM(amount) AS total FROM payment_history WHERE username='$username' and status=1");
$temp=$Db1->fetch_array($sql);
$thismemberinfo['completed_payments']=$temp[total];

$sql=$Db1->query("SELECT SUM(amount) AS total FROM payment_history WHERE username='$username' and status=2");
$temp=$Db1->fetch_array($sql);
$thismemberinfo['cancelled_payments']=$temp[total];


$sql=$Db1->query("SELECT SUM(fee) AS total FROM payment_history WHERE username='$username' and status=1");
$temp=$Db1->fetch_array($sql);
$thismemberinfo['fee']=$temp[total];

if($settings[lbref_on] == 1) {
	$sql=$Db1->query("SELECT username, lbref FROM user ORDER BY lbref DESC LIMIT 5");
	for($d=1; $temp=$Db1->fetch_array($sql); $d++) {
		$lboard.="$d. $temp[username] ".iif($settings[lbref_on]==1, "(".$temp[lbref].")")."<br />";
	}
}
if($thismemberinfo[type] == 1) {
	$sql=$Db1->query("SELECT * FROM memberships WHERE id='$thismemberinfo[membership]'");
	$temp=$Db1->fetch_array($sql);
	$membershipName=$temp[title];
}


if($hold == "") $grabHeader = "Stats";
else $grabHeader = $hold;


$includes[content]="
".iif($newmsgs > 0,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><a href=\"index.php?view=account&ac=messages&".$url_variables."\"><center><font color=black><b>You Have</font>&nbsp;<font color=red> $newmsgs</font>&nbsp;New messages Click here to read!</b></a></div>")."

".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if you are unable to use our member features!</div>")."
".iif($error_msg,"<script>alert('$error_msg');".iif($foward,"location.href='$foward';")."</script>")."






<script>
function deselectAllHeaders() {
	var headerList = document.getElementById('dropBoxHeaderCont').getElementsByTagName(\"div\");
	for (var i=0; i<headerList.length; i++)	{
		if(headerList[i].className == 'dropBoxHeaderSelected') {
			headerList[i].className='dropBoxHeader';
		}
	}


	var boxList = document.getElementById('dropBoxContMain').getElementsByTagName(\"div\");
	for (var i=0; i<boxList.length; i++)	{
		if(boxList[i].className == 'dropBoxCont') {
			boxList[i].style.display='none';
		}
	}


}


function loadDropBox(rel) {
	deselectAllHeaders()
	document.getElementById('dropBoxHeader'+rel).className='dropBoxHeaderSelected'
	document.getElementById('profile'+rel).style.display='block';
}
</script>
<br>

<table width=\"570\" height=\"600\" cellspacing=5 cellpadding=0 align=\"center\">
	<tr>


".iif($thismemberinfo[confirm] ==1,"
		<td width=\"155\" valign=\"top\">
		<div id=\"dropBoxHeaderCont\">
		".iif($settings[lbref_on] ==1,"
<center><div class=\"refstat\"><b>Ref Contest Stats</b><br>
$lboard</div></center><br>")."
				<div id=\"dropBoxHeaderAccount\" class=\"dropBoxHeader\"><img src=\"images/icons/about.gif\"/> <a href=\"\" onclick=\"loadDropBox('Account'); return false;\">Account</a></div>
				<div id=\"dropBoxHeaderPref\" class=\"dropBoxHeader\"><img src=\"images/icons/preferences.gif\"/> <a href=\"\" onclick=\"loadDropBox('Pref'); return false;\">Preferences</a></div>
				<div id=\"dropBoxHeaderWithdraw\" class=\"dropBoxHeader\"><img src=\"images/icons/money.gif\"/> <a href=\"\" onclick=\"loadDropBox('Withdraw'); return false;\">Withdraw</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/chart.gif\"/> <a href=\"\" onclick=\"loadDropBox('Stats'); return false;\">Stats</a></div>
                                ".iif($settings["point_on"]==1,"<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/cart.gif\"/> <a href=\"index.php?view=account&ac=store&".$url_variables."\">Point Store</a></div>")."
				".iif($settings["imOn"]==1,"<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/message.gif\"/> <a href=\"index.php?view=account&ac=messages&".$url_variables."\">Messages</a></div>")."
                                ".iif($settings["forum_on"]==1,"<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/forum.gif\"/> <a href=\"index.php?view=account&ac=forumindex&".$url_variables."\">Forum</a></div>")."
                                <div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/warnings.gif\"/> <a href=\"index.php?view=account&ac=mywarnings&".$url_variables."\">My Warnings</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/upgrade.gif\"/> <a href=\"index.php?view=account&ac=membership&".$url_variables."\">Membership</a></div>
                                 <div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/users2.gif\"/> <a href=\"index.php?view=buyreferrals&".$url_variables."\">Buy Referrals</a></div>
                                ".iif($settings["lottery_enabled"]==1,"<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/lottery2.gif\"/> <a href=\"index.php?view=account&ac=lottery&".$url_variables."\">Lottery</a></div>")."
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/earn.gif\"/> <a href=\"index.php?view=account&ac=earn&".$url_variables."\">Earnings Area</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/ads.gif\"/> <a href=\"index.php?view=account&ac=myads&".$url_variables."\">Manage Ads</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/web_link.gif\"/> <a href=\"index.php?view=account&ac=banners&".$url_variables."\">Promote</a></div>

				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/book.gif\"/> <a href=\"index.php?view=account&ac=order_ledger&".$url_variables."\">Order Ledger</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/users.gif\"/> <a href=\"index.php?view=account&ac=downline&".$url_variables."\">Your Downline</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/map.gif\"/> <a href=\"index.php?view=account&ac=referralbuilder&".$url_variables."\">Referral Builder</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/auction.gif\"/> <a href=\"index.php?view=account&ac=shoppingcenter&".$url_variables."\">Auctions</a></div>
                                 <div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/tools.gif\"/> <a href=\"index.php?view=account&ac=converter&".$url_variables."\">Converter</a></div>
                                 <div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/contest.gif\"/> <a href=\"index.php?view=account&ac=contest&".$url_variables."\">Contests</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/polls.gif\"/> <a href=\"index.php?view=polls&".$url_variables."\">Polls</a></div>

	<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/leader.gif\"/> <a href=\"index.php?view=account&ac=leaderboard&".$url_variables."\">Leader Board</a></div>

			</div>
		</td>")."
		<td valign=\"top\">
			<div class=\"accountRightCont\">
			<div style=\" padding: 5px;\" id=\"dropBoxContMain\">

                                       <p align=\"center\"><img src=/images/logo.png></p>
					<div id=\"profileAccount\" class=\"dropBoxCont\">
						<table class=\"tableStyle2\" style=\"width: 100%\">
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Your Account</b></td>
							</tr>
							<tr>
								<td><b>Username: </b></td>
								<td>$thismemberinfo[username]</td>
							</tr>
							<tr>
								<td><b>Name: </b></td>
								<td>$thismemberinfo[name]</td>
							</tr>
							<tr>
								<td><b>Ip Address: </b></td>
								<td>$vip</td>
							</tr>
						</table>

						<form action=\"index.php?view=account&ac=profile&action=targeting&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\" >
						<table class=\"tableStyle2\" style=\"width: 100%\">
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Targeting</b></td>
							</tr>
							<tr>
								<td><b>Gender: </b></td>
								<td>";
									if($thismemberinfo[sex] != "") {
										if($thismemberinfo[sex] == "M") $includes[content].="Male";
										else $includes[content].="Female";
									}
									else {
										$showTargetSubmit=true;
										$includes[content].="
											<input type=\"radio\" name=\"sex\" label=\"Male\" value=\"M\"> Male
											<input type=\"radio\" name=\"sex\" label=\"Female\" value=\"F\"> Female";
									}

									$includes[content].="
								</td>
							</tr>
							<tr>
								<td><b>Birth Year: </b></td>
								<td>";

									if($thismemberinfo[birth] != 0) $includes[content].="$thismemberinfo[birth]";
									else {
										$showTargetSubmit=true;
										$includes[content].="<select name=\"birth\" style=\"width: 80px;\"><option value=\"\">";
										for($x=date('Y')-13; $x>1900; $x--) {
											$includes[content].="<option value=\"$x\">$x\n";
										}
										$includes[content].="</select>";
									}

								$includes[content].="</td>
							</tr>
							<tr>
								<td><b>Country: </b></td>
								<td>$thismemberinfo[country]</td>
							</tr>
							".iif($showTargetSubmit==true,"
								<tr>
									<td align=\"center\" colspan=2><input type=\"submit\" value=\"Save Data\"></td>
								</tr>
							")."
						</table>
						</form>

							<form action=\"index.php?view=account&ac=profile&action=email&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\" >
							<table class=\"tableStyle2\">
								<tr>
									<td colspan=2 class=\"tableHead\"><b>Your Email</b></td>
								</tr>
								<tr>
									<td>Current Email: </td>
									<td>$thismemberinfo[email]</td>
								</tr>
								<tr>
									<td>New Email</td>
									<td><input type=\"text\" name=\"email\" value=\"\" style=\"width: 200px\"></td>
								</tr>
<tr>
	<td>Pin Number:</td>
	<td><input type=\"text\" name=\"spin\" style=\"width: 200px\"></td>
</tr>
								<tr>
									<td align=\"center\" colspan=2><input type=\"submit\" value=\"Save New Email\"></td>
								</tr>
							</table>
							</form>
                                                         ".iif($thismemberinfo[pin] == "","
<form action=\"index.php?view=account&ac=profile&action=set_pin&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\" >
<table class=\"tableStyle2\">
	<tr>
		<td colspan=2 class=\"tableHead\"><b>Set Your Pin Number</b></td>
	</tr>
	<tr>
		<td>Your Pin Number(4 digits long):</td>
		<td><input type=\"text\" name=\"set_pin\" value=\"\" style=\"width: 200px\"></td>
	</tr>
	<tr>
		<td align=\"center\" colspan=2><input type=\"submit\" value=\"Set As Pin\"></td>
	</tr>
</table>
</form>")."

							<form action=\"index.php?view=account&ac=profile&action=pwd&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
							<table class=\"tableStyle2\">
								<tr>
									<td colspan=2 class=\"tableHead\"><b>Your Password</b></td>
								</tr>
								<tr>
									<td>New Password: </td>
									<td><input type=\"password\" name=\"pwd\" value=\"\" style=\"width: 200px\"></td>
								</tr>
								<tr>
									<td>Repeat: </td>
									<td><input type=\"password\" name=\"pwd2\" value=\"\" style=\"width: 200px\"></td>
								</tr>
								<tr>
									<td align=\"center\" colspan=2><input type=\"submit\" value=\"Change Password\"></td>
								</tr>
							</table>
							</form>
                                                        <table class=\"tableStyle2\" style=\"width: 100%\">
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Reset Account PIN</b></td>
							</tr>
							<tr>
								<td colspan=2>
									<input type=\"button\" value=\"Click Here To Reset Your Account Pin\" onclick=\"location.href='index.php?view=lostpin&".$url_variables."'\">
								</td>
							</tr>
						</table>

						<table class=\"tableStyle2\" style=\"width: 100%\">
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Delete Your Account</b></td>
							</tr>
							<tr>
								<td colspan=2>
									<input type=\"button\" value=\"Click Here To Delete Your Account\" onclick=\"location.href='index.php?view=account&ac=delete&".$url_variables."'\">
								</td>
							</tr>
						</table>

					</div>













					<div id=\"profilePref\" class=\"dropBoxCont\">
						<div class=\"dropBoxTitle\">Account Preferences</div>
							".iif(SETTING_PTR==true && $settings["ptron"],"
								<table class=\"tableStyle1\">
									<tr>
										<td style=\"width: 350px\">
												<b>".iif($thismemberinfo[optin]==1,"
												<font color=\"darkgreen\">Paid emails are turned on!</font>","
												<font color=\"darkred\">Paid emails are turned off!</font>")."</b>
										</td>
										<td>
											<input type=\"button\" value=\"".iif($thismemberinfo[optin]==1,"Turn OFF","Turn ON")."\" onclick=\"location.href='index.php?view=account&ac=profile&action=ptr&to=".iif($thismemberinfo[optin]==1,"0","1")."&".$url_variables."'\">
										</td>
									</tr>
								</table>

							")."


					<table class=\"tableStyle1\">
									<tr>
										<td style=\"width: 350px\">
												<b>".iif($thismemberinfo[moptin]==1,"
												<font color=\"darkgreen\">Admin Mailer is turned on!</font>","
												<font color=\"darkred\">Admin Mailer is turned off!</font>")."</b>
										</td>
										<td>
											<input type=\"button\" value=\"".iif($thismemberinfo[moptin]==1,"Turn OFF","Turn ON")."\" onclick=\"location.href='index.php?view=account&ac=profile&action=mailer&to=".iif($thismemberinfo[moptin]==1,"0","1")."&".$url_variables."'\">
										</td>
									</tr>
								</table>

							





								".iif($settings[new_ad_alert]==1,"



								<table class=\"tableStyle1\">
									<tr>
										<td style=\"width: 350px\">
											".iif($settings[ad_alert_group] == 1 && $thismemberinfo[type] == 0,
											"Upgrade your membership and you can be notified via email whenever new ads are available!","
												<b>".iif($thismemberinfo[ad_alert]==1,"
												<font color=\"darkgreen\">Ad alerts are turned on!</font>","
												<font color=\"darkred\">Ad alerts are turned off!</font>")."</b>
										</td>
										<td>
											<input type=\"button\" value=\"".iif($thismemberinfo[ad_alert]==1,"Turn OFF","Turn ON")."\" onclick=\"location.href='index.php?view=account&ac=profile&action=ad_alert&to=".iif($thismemberinfo[ad_alert]==1,"0","1")."&".$url_variables."'\">
										")."
										</td>
									</tr>
								</table>

									
					



	".iif($settings[ref_notifier]==1,"



								<table class=\"tableStyle1\">
									<tr>
										<td style=\"width: 350px\">
										<b>".iif($thismemberinfo[ref_notifier]==1,"
										<font color=\"darkgreen\">Referral Notifications Are Turned On!</font>","
												<font color=\"darkred\">Referral Notifications Are Turned Off!</font>")."</b>
											</td>
										<td>
											<input type=\"button\" value=\"".iif($thismemberinfo[ref_notifier]==1,"Turn OFF","Turn ON")."\" onclick=\"location.href='index.php?view=account&ac=profile&action=ref_notifier&to=".iif($thismemberinfo[ref_notifier]==1,"0","1")."&".$url_variables."'\">
										")."
										</td>
									</tr>
								</table>

									")."
					</div>










					<div id=\"profileStats\" class=\"dropBoxCont\">

					<table class=\"tableStyle2\" style=\"width: 100%;\">

						".iif($settings[balance]==1,"
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Your Membership</b></td>
							</tr>
							<tr>
								<td>
									".iif($thismemberinfo[type] == 0,
										"You are currently a Free Member. <a href=\"index.php?view=account&ac=membership&".$url_variables."\"><strong>Upgrade Today!</strong></a>",
										"Premium Membership: <a href=\"index.php?view=account&ac=membership&".$url_variables."\"><strong>".$membershipName."</strong></a>"
									)."
								</td>
								<td>
									".iif($thismemberinfo[type] == 0,
										"Upgrade to Premium today!!!",
										"Membership Ends In:<br> ".floor(($thismemberinfo[pend]-time())/24/60/60)." Days"
									)."
								</td>
							</tr>
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Cash Balance Stats</b></td>
							</tr>
							<tr>
								<td>Balance: </td>
								<td>$".number_format($thismemberinfo[balance],5)."</td>
							</tr>


	<tr>
								<td>Clicks: </td>
								<td><font color=\"red\">$thismemberinfo[clicks]</font></td>
							</tr>
							<tr>
								<td>Pending Withdrawls:</td>
								<td><a href=\"index.php?view=account&ac=pendingwithdraw&".$url_variables."\">\$".number_format($thismemberinfo['pending_payments'],2)."</a></td>
							</tr>
							<tr>
								<td>Payments Received:</td>
								<td><a href=\"index.php?view=account&ac=pendingwithdraw&".$url_variables."\">\$".number_format($thismemberinfo['completed_payments'],2)."</a></td>
							</tr>
							<tr>
								<td>Payments Cancelled:</td>
								<td><a href=\"index.php?view=account&ac=pendingwithdraw&".$url_variables."\">\$".number_format($thismemberinfo['cancelled_payments'],2)."</a></td>
							</tr>

	<tr>
								<td>Payout fees:</td>
								<td><a href=\"index.php?view=account&ac=pendingwithdraw&".$url_variables."\">\$".number_format($thismemberinfo['fee'],2)."</a></td>
							</tr>
						")."

						".iif(SETTING_PTP == true,"
							<tr>
								<td colspan=2 class=\"tableHead\"><b>PTP Stats</b></td>
							</tr>
							<tr>
								<td>Raw PTP Hits:</td>
								<td>".$thismemberinfo['ref_hits_raw']."</td>
							</tr><tr>
<td>PTP Hits Today:</td><td>{$thismemberinfo['ptphits_today']}</td>
</tr>
<tr>
<td>PTP Hits:</td><td>{$thismemberinfo['ptphits']}</td>
</tr>
<tr>
<td>PTP Earnings:</td><td>\${$thismemberinfo['ptpearns']}</td>
</tr>

							",iif($thismemberinfo['ref_hits_unique']!=0,"
								<tr>
									<td>Raw PTP Hits:</td>
									<td>".$thismemberinfo['ref_hits_unique']."</td>
								</tr>")."
						")."

							<tr>
								<td colspan=2 class=\"tableHead\"><b>Credit Balance Stats</b></td>
							</tr>
						".iif($settings[points]==1,"
							<tr>
								<td>Points: </td>
								<td>$thismemberinfo[points]</td>
							</tr>
						")."
						".iif(SETTING_CE == true && $settings[ce_on]==1,"
							<tr>
								<td>Exchange Credits: </td>
								<td>$thismemberinfo[xcredits]</td>
							</tr>
						")."
						".iif(SETTING_PTC==true && $settings[ptcon]==1,"
							<tr>
								<td>PTC Credits: </td>
								<td>$thismemberinfo[link_credits]</td>
							</tr>
						")."
						".iif(SETTING_PTR==true && $settings[ptron]==1,"
							<tr>
								<td>Email Credits: </td>
								<td>$thismemberinfo[ptr_credits]</td>
							</tr>
						")."
						".iif(SETTING_PTRA==true && $settings[ptraon]==1,"
							<tr>
								<td>PTRA Credits</td>
								<td>$thismemberinfo[ptra_credits]</td>
							</tr>
						")."
						".iif(SETTING_PTSU==true && $settings[ptsuon]==1,"
							<tr>
								<td>PTSU Credits</td>
								<td>$thismemberinfo[ptsu_credits]</td>
							</tr>
						")."
						".iif($settings[sellbanner] == 1,"
							<tr>
								<td>Banner Credits: </td>
								<td>$thismemberinfo[banner_credits]</td>
							</tr>
						")."
						".iif($settings[sellfbanner] == 1,"
							<tr>
								<td>Featured Banner Credits: </td>
								<td>$thismemberinfo[fbanner_credits]</td>
							</tr>
						")."
						".iif($settings[sellfad] == 1,"
							<tr>
								<td>Featured Ad Credits: </td>
								<td>$thismemberinfo[fad_credits]</td>
							</tr>
						")."
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Contest Stats</b></td>
							</tr>
						".iif($settings[purchcon_on],"
							<tr>
								<td>Purchase Contest: </td>
								<td>$thismemberinfo[purchcon_tic] Entry(s)</td>
							</tr>
						")."

						".iif($settings[ref_contest],"
							<tr>
								<td>Referral Contest: </td>
								<td>$thismemberinfo[week_refs] Referral(s)</td>
							</tr>
						")."

						".iif($settings[clickc_on],"
							<tr>
								<td>Click Contest: </td>
								<td>$thismemberinfo[clickcon_clic] Click(s)</td>
							</tr>
						")."

						".iif($settings[tickets_on],"
							<tr>
								<td>Tickets Drawing: </td>
								<td>$thismemberinfo[tickets] Ticket(s)</td>
							</tr>
						")."


							<tr>
								<td colspan=2 class=\"tableHead\"><b>Downline Stats</b></td>
							</tr>
							<tr>
								<td>Level 1 Referrals: </td>
								<td>$thismemberinfo[referrals1]</td>
							</tr>
					
							<tr>
								<td>Total Downline Clicks: </td>
								<td>$thismemberinfo[reftotcli]</td>
							</tr>
							<tr>
								<td>Downline Earnings: </td>
								<td>$cursym $thismemberinfo[referral_earns]</td>
							</tr>




						</table>



					</div>

					<div id=\"profileWithdraw\" class=\"dropBoxCont\" style=\"text-align: center\">

		".iif(getGroupPerm($username, 'denyRequests')==1,"You do not have permission to withdraw!","
			".iif($settings[balance] == 1,"
				".iif((($settings[withdraw_premium] == 0) || ($thismemberinfo[type] == 1)), "
					".iif($settings[request_pay_on]==1,"
						<div class=\"dropBoxTitle\">Withdraw Earnings</div>
						<form action=\"index.php?view=account&ac=profile&action=withdraw&".$url_variables."\" method=\"post\" name=\"form\" onSubmit=\"return dosub(this)\">

						<script>
						var withdraw = 0;
						var fee = 0;
						var feemin = 0;
						var pmin = 0;
						var veriftype;

						function dosub(form) {
							if(veriftype == '') {
								return true;
								submitonce(form);
							}
							else {
								if(veriftype == 'email') {
									if(
										((document.form.account.value.length <= 1) || (document.form.account.value.indexOf('@') == -1) || (document.account.email.value.indexOf('.') == -1))
									) {
										alert('You have not entered a correct account ID!\\"."nYour account ID must be an email address!');
										return false;
									}
									else {
										return true;
									}
								}
								if(veriftype == 'int') {
									if(((document.form.account.value*1) != document.form.account.value) || (document.form.account.value.length <1)) {
										alert('You have not entered a correct account ID!\\"."nYour account ID must be a number!');
										return false;
									}
									else {
										return true;
									}
								}
							}
						}

						function update(min,thefee,thefeemin,verif) {
							veriftype=verif;
							if(min <= $thismemberinfo[balance]) {
								fee=thefee*1;
								feemin=thefeemin*1;
								pmin=min;
								document.getElementById('wtable').style.display='';
								document.getElementById('warn').style.display='none';
								calculate2();
							}
							else {
								fee=0;
								withdraw=0;
								pmin=0;
								document.getElementById('wtable').style.display='none';
								document.getElementById('warn').style.display='';
							}
						}

						function calculate2() {
							if(document.form.amount.value < pmin) {
								document.form.amount.value = pmin;
							}
							calculate();
						}

						function calculate() {
						
							document.getElementById('feeOut').innerHTML=fee+'%';
							document.getElementById('feeminOut').innerHTML='$'+feemin;
							
							var tempfee = document.form.amount.value*(fee/100);
							
							if(tempfee < feemin && fee > 0) tempfee=feemin;
							
							document.form.net.value=Math.round(((document.form.amount.value*1)-(tempfee))*100)/100;
						}
						</script>


						<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\" class=\"tableStyle withdraw\">
							<tr>
								<th></th>
								<th>Method</th>
								<th>Minimum</th>
								<th>Fee</th>
								<th width=5></th>
							</tr>
							$withdraw_options
						</table>
")."


						<div style=\"display: none;\" id=\"wtable\">
						<table width=\"100%\" class=\"tableStyle withdraw\">
							<tr>
								<th>Account Id:</th>
								<td><input type=\"text\" name=\"account\"></td>
							</tr>
                                                        <tr>
	                                              <td>Pin Number:</td>
	                                             <td><input type=\"text\" name=\"spin\"></td>
                                                        </tr>
							<tr>
								<th>Gross Withdraw: </th>
								<td>$cursym <input type=\"text\" name=\"amount\" size=4  value=\"".(floor($thismemberinfo[balance]*100)/100)."\" onkeyup='calculate()' onchange='calculate2()'></td>
							</tr>
							<tr>
								<th>Fee: </th>
								<td>
									<span id=\"feeOut\"></span> or <span id=\"feeminOut\"></span> 
								</td>
							</tr>
							<tr>
								<th>Net Withdraw: </th>
								<td>$cursym <input type=\"text\" name=\"net\" size=4 onkeyup='calculate()'></td>
							</tr>
							<tr>
								<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Request\"></td>
							</tr>
						</table>
						</div>

						<div style=\"display: none;\" id=\"warn\">
							<b style=\"color: red\">You do not have enough earnings to request with this payment method!</b>
						</div>


						</form>

						<hr>
						")."

						".iif($settings[auto_pay_on]==1,"
						<div class=\"dropBoxTitle\">Auto Withdraw Earnings</div>

						<form action=\"index.php?view=account&ac=profile&action=save_auto&".$url_variables."\" method=\"post\">

						<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\" class=\"tableStyle withdraw\">
							<tr>
								<th></th>
								<th>Method</th>
								<th>Minimum</th>
								<th>Fee</th>
							</tr>
							<tr class=\"tableHL2\">
								<td width=2><input type=\"radio\" name=\"auto_method\" value=\"0\"".iif(0 == $thismemberinfo[auto_method]," checked=checked")."></td>
								<td colspan=3>Turned Off</td>
							</tr>
							$withdraw_options2
						</table>


						<table width=\"100%\">
							<tr>
								<td>Account Id:</td>
								<td><input type=\"text\" name=\"auto_account\" value=\"$thismemberinfo[auto_account]\"></td>
							</tr>
                                                        <tr>
	                                              <td>Pin Number:</td>
	                                              <td><input type=\"text\" name=\"spin\"></td>
                                                       </tr>
							<tr>
								<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
							</tr>
						</table>
						</form>
						<hr>


					
")."

						","<br />You must be a Premium Member to request your account earnings!")."

						<a href=\"index.php?view=account&ac=pendingwithdraw&".$url_variables."\">Click Here To View History</a>

					")."
			
					</div>





			</div>
			</div>
		</td>
	</tr>
</table>

<div style=\"clear: both;\"></div>


<script>

loadDropBox('$grabHeader');

</script>


";

?>