<?
//$includes[title]="My Account";
$includes[title]=$thismemberinfo[name];

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
	else if($thismemberinfo[balance] >= $amount) {
		$sql=$Db1->query("SELECT * FROM withdraw_options WHERE id='$accounttype'");
		if($Db1->num_rows() != 0) {
			$method = $Db1->fetch_array($sql);
			if($method[minimum] <= $amount) {
				$sql=$Db1->query("UPDATE user SET balance=balance-$amount WHERE username='$username'");
				if($thismemberinfo[type] == 0) {
					if($amount <= 1) 		$fee=$method[fee]/100;
					else if($amount > 1) 	$fee=$amount*$method[fee]/100;
					$ramount=$amount-$fee;
				}
				else {
					$ramount=$amount;
				}
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
	if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$cursym ", $email)) {
		$error_msg="Enter a valid email address";
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
	$withdraw_options.="
		<tr class=\"tableHL2\">
			<td width=2><input type=\"radio\" name=\"accounttype\" value=\"$temp[id]\" onclick=\"update($temp[minimum],$temp[fee],'$temp[verif]')\"></td>
			<td>$temp[title]</td>
			<td>$cursym ".number_format($temp[minimum],2)."</td>
			<td>$temp[fee] %</td>
			<td align=\"center\" style=\"padding: 0 0 0 0\">".iif(($temp[minimum] > $thismemberinfo[balance]),"<img src=\"images/ball_red.gif\">")."".iif(($temp[minimum] <= $thismemberinfo[balance]),"<img src=\"images/ball_green.gif\">")."</td>
		</tr>
		";
	$withdraw_options2.="
		<tr class=\"tableHL2\">
			<td width=2><input type=\"radio\" name=\"auto_method\" value=\"$temp[id]\"".iif($temp[id] == $thismemberinfo[auto_method]," checked=checked")."></td>
			<td>$temp[title]</td>
			<td>$cursym ".number_format($temp[minimum],2)."</td>
			<td>$temp[fee] %</td>
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


if($hold == "") $grabHeader = "Stats";
else $grabHeader = $hold;


$sql=$Db1->query("SELECT COUNT(id) as total FROM ptp_hits WHERE ref='$username'");
$temp=$Db1->fetch_array($sql);
$thismemberinfo[unprocptp] = $temp[total];

$includes[content]="
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

<table width=\"570\" height=\"600\" cellspacing=5 cellpadding=0 align=\"center\">
	<tr>
		<td width=\"155\" valign=\"top\">
			<div id=\"dropBoxHeaderCont\">
				<div id=\"dropBoxHeaderAccount\" class=\"dropBoxHeader\"><img src=\"images/icons/about.gif\"/> <a href=\"\" onclick=\"loadDropBox('Account'); return false;\">Account</a></div>
				<div id=\"dropBoxHeaderPref\" class=\"dropBoxHeader\"><img src=\"images/icons/preferences.gif\"/> <a href=\"\" onclick=\"loadDropBox('Pref'); return false;\">Preferences</a></div>
				<div id=\"dropBoxHeaderWithdraw\" class=\"dropBoxHeader\"><img src=\"images/icons/money.gif\"/> <a href=\"\" onclick=\"loadDropBox('Withdraw'); return false;\">Withdraw</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/chart.gif\"/> <a href=\"\" onclick=\"loadDropBox('Stats'); return false;\">Stats</a></div>

				<div style=\"height: 10px\"></div>

				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/calculator.gif\"/> <a href=\"index.php?view=account&ac=earn&".$url_variables."\">Earnings Area</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/data.gif\"/> <a href=\"index.php?view=account&ac=myads&".$url_variables."\">Manage Ads</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/web_link.gif\"/> <a href=\"index.php?view=account&ac=banners&".$url_variables."\">Promote</a></div>

				<div style=\"height: 10px\"></div>

				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/book.gif\"/> <a href=\"index.php?view=account&ac=order_ledger&".$url_variables."\">Order Ledger</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/users.gif\"/> <a href=\"index.php?view=account&ac=downline&".$url_variables."\">Your Downline</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/map.gif\"/> <a href=\"index.php?view=account&ac=referralbuilder&".$url_variables."\">Referral Builder</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/tools.gif\"/> <a href=\"index.php?view=account&ac=converter&".$url_variables."\">Converter</a></div>
				<div id=\"dropBoxHeaderStats\" class=\"dropBoxHeader\"><img src=\"images/icons/user.gif\"/> <a href=\"index.php?view=account&ac=membership&".$url_variables."\">Membership</a></div>


				
			</div>
		</td>
		<td valign=\"top\">
			<div class=\"accountRightCont\">
			<div style=\" padding: 5px;\" id=\"dropBoxContMain\">
			
			
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
									<td align=\"center\" colspan=2><input type=\"submit\" value=\"Save New Email\"></td>
								</tr>
							</table>
							</form>						
						
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

									")."						
					</div>
					
					
					
					
					
					
					
					
					
					
					
					
					
					<div id=\"profileStats\" class=\"dropBoxCont\">
						
						<table class=\"tableStyle2\" style=\"width: 100%;\">
						
						".iif($settings[balance]==1,"
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Cash Balance Stats</b></td>
							</tr>
							<tr>
								<td>Balance: </td>
								<td>\$".number_format($thismemberinfo[balance],5)."</td>
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
						")."
							<tr>
								<td colspan=2 class=\"tableHead\"><b>PTP Stats</b></td>
							</tr>
							<tr>
								<td>Unprocessed Hits: </td>
								<td>$thismemberinfo[unprocptp]</td>
							</tr>
							<tr>
								<td colspan=2 class=\"tableHead\"><b>Credit Balance Stats</b></td>
							</tr>
						".iif($settings[points]==1,"
							<tr>
								<td>Points: </td>
								<td>$thismemberinfo[points]</td>
							</tr>
						")."
						".iif(SETTING_GAMES == true,"
							<tr>
								<td>Game Points: </td>
								<td>$thismemberinfo[game_points]</td>
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
							<tr>
								<td>Banner Credits: </td>
								<td>$thismemberinfo[banner_credits]</td>
							</tr>
							<tr>
								<td>Featured Banner Credits: </td>
								<td>$thismemberinfo[fbanner_credits]</td>
							</tr>
							<tr>
								<td>Featured Ad Credits: </td>
								<td>$thismemberinfo[fad_credits]</td>
							</tr>
						".iif($settings[tickets_on],"
							<tr>
								<td>Tickets: </td>
								<td>$thismemberinfo[tickets]</td>
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
								<td>Total Downline: </td>
								<td>".($thismemberinfo[referrals1]+$thismemberinfo[referrals2]+$thismemberinfo[referrals3]+$thismemberinfo[referrals4]+$thismemberinfo[referrals5])."</td>
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
						<table width=\"100%\">
							<tr>
								<td align=\"center\" width=\"100%\">
						<form action=\"index.php?view=account&ac=profile&action=withdraw&".$url_variables."\" method=\"post\" name=\"form\" onSubmit=\"return dosub(this)\">
						
							<table cellspacing=\"0\" cellpadding=\"0\" border=0  style=\"width: 100%\">
								<tr>
									<td width=\"100%\">
										<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
											<tr class=\"tableHL1\">
												<td><b></b></tD>
												<td><b>Method</b></tD>
												<td><b>Minimum</b></tD>
												<td><b>Fee</b></tD>
												<td width=5></td>
											</tr>
											$withdraw_options
										</table>
									</td>
								</tr>
							</table>
						
						<script>
						var withdraw = 0;
						var fee = 0;
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
						
						function update(min,thefee,verif) {
							veriftype=verif;
							if(min <= $thismemberinfo[balance]) {
								fee=".iif($thismemberinfo[type]==1,"0","thefee*1").";
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
							document.form.fee.value=fee+'%';
							var tempfee = document.form.amount.value*(fee/100);
							".iif($thismemberinfo[type]!=1,"
								if(tempfee < (fee/100)) {
									tempfee = (fee/100);
								}
							")."
							document.form.net.value=Math.round(((document.form.amount.value*1)-(tempfee))*100)/100;
						}
						</script>
							
						<div style=\"display: none;\" id=\"wtable\">
						<table width=\"100%\">
							<tr>
								<td>Account Id:</td>
								<td><input type=\"text\" name=\"account\"></td>
							</tr>
							<tr>
								<td width=150>Gross Withdraw: </td>
								<td width=150>$cursym <input type=\"text\" name=\"amount\" size=4  value=\"".(floor($thismemberinfo[balance]*100)/100)."\" onkeyup='calculate()' onchange='calculate2()'></td>
							</tr>
							<tr>
								<td width=150>Fee: </td>
								<td width=150>$cursym <input type=\"text\" name=\"fee\" size=4 onkeyup='calculate()'></td>
							</tr>
							<tr>
								<td width=150>Net Withdraw: </td>
								<td width=150>$cursym <input type=\"text\" name=\"net\" size=4 onkeyup='calculate()'></td>
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
						
														</td>
							</tr>
						</table>
						<hr>
						")."
												
						".iif($settings[auto_pay_on]==1,"
						<div class=\"dropBoxTitle\">Auto Withdraw Earnings</div>
						
						<form action=\"index.php?view=account&ac=profile&action=save_auto&".$url_variables."\" method=\"post\">
							<table cellspacing=\"0\" cellpadding=\"0\" border=0  style=\"width: 100%\">
								<tr>
									<td width=\"100%\">
										<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
											<tr class=\"tableHL1\">
												<td><b></b></tD>
												<td><b>Method</b></tD>
												<td><b>Minimum</b></tD>
												<td><b>Fee</b></tD>
											</tr>
											<tr class=\"tableHL2\">
												<td width=2><input type=\"radio\" name=\"auto_method\" value=\"0\"".iif(0 == $thismemberinfo[auto_method]," checked=checked")."></td>
												<td colspan=3>Turned Off</td>
											</tr>
											$withdraw_options2
										</table>
									</td>
								</tr>
							</table>
													
						
						<table width=\"100%\">
							<tr>
								<td>Account Id:</td>
								<td><input type=\"text\" name=\"auto_account\" value=\"$thismemberinfo[auto_account]\"></td>
							</tr>
							<tr>
								<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
							</tr>
						</table>
						</form>
						<hr>
						
						
						")."
						
						","<br />You must be a premium member to request your account earnings!")."
						
						<a href=\"index.php?view=account&ac=pendingwithdraw&".$url_variables."\">Click Here To View History</a>
						
					")."	
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
