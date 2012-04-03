<?
//**S**//
$headers .= "From: $settings[domain_name] Admin <$settings[admin_email]>\n";
$headers .= "Reply-To: <$settings[admin_email]>\n";
$headers .= "X-Sender: <$settings[admin_email]>\n";
$headers .= "X-Mailer: PHP4\n"; //mailer
$headers .= "X-Priority: 1\n"; //1 UrgentMessage, 3 Normal
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

function bought_link($order) {
	global $procs, $Db1, $headers, $secondamount, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] link credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
			
	$sql=$Db1->query("UPDATE ads SET
			credits=credits+($order[amount]*$settings[bog_amount]),
			class='$order[class]',
			".iif($order[bgcolor]!="","bgcolor='$order[bgcolor]',")."
			".iif($order[subtitle]!="","subtitle_on='1',").iif($order[icon]!="","icon_on='1',")."
			pamount='$order[pamount]',
			timed='".$order[timed]."'
		WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Link Credits For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_ptra($order) {
	global $procs, $Db1, $headers, $secondamount, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] paid ad credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE ptrads SET credits=credits+($order[amount]*$settings[bog_amount]), class='$order[class]', ".iif($order[bgcolor]!="","bgcolor='$order[bgcolor]',")."".iif($order[subtitle]!="","subtitle_on='1',").iif($order[icon]!="","icon_on='1',")."  pamount='$order[pamount]', timed='".$order[timed]."' WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Paid Ad Credits For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_popups($order) {
	global $procs, $Db1, $headers,$settings;
	if(SETTING_PTP != true) {
		haultscript();
	}
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] popup credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE popups SET credits=credits+($order[amount]*$settings[bog_amount]) WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Popup Credits For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}


function bought_ptsu($order) {
	global $procs, $Db1, $headers, $settings;
	if(SETTING_PTSU != true) {
		haultscript();
	}
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] Guaranteed Signups; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE ptsuads SET credits=credits+($order[amount]*$settings[bog_amount]), class='C', ".iif($order[subtitle]!="","subtitle_on='1',").iif($order[icon]!="","icon_on='1',")." pamount='$settings[ptsu_value]'  WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Guaranteed Signups For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_ptsuc($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] Signup credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'Signup Offers'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET ptsu_credits=ptsu_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Signup Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}



function bought_ptr($order) {
	global $procs, $Db1, $headers, $settings;
	if(SETTING_PTR != true) {
		haultscript();
	}
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] paid email credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE emails SET credits=credits+($order[amount]*$settings[bog_amount]) WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Paid Email Credits For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_linkc($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] link credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'Link Ads'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET link_credits=link_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account Link Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}



function bought_surfc($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] surf site credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET surf_credits=surf_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account Surf Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}



function bought_xcredits($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] x-credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET xcredits=xcredits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." X-Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}


function bought_bannerc($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] banner credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'Banner Ads'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET banner_credits=banner_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account Banner Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_fbannerc($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] featured banner credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'Featured Banner Ads'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET fbanner_credits=fbanner_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account Featured Banner Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_fadc($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] featured ad credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'Featured Ads'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET fad_credits=fad_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account Featured Ad Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_popupsc($order) {
	global $procs, $Db1, $headers, $settings;
	if(SETTING_PTP != true) {
		haultscript();
	}
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] popup credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'PTP Ads'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET popup_credits=popup_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account Popup Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_ptrc($order) {
	global $procs, $Db1, $headers, $settings;
	if(SETTING_PTR != true) {
		haultscript();
	}
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] paid email credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'Email Ads'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET ptr_credits=ptr_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account Paid Email Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_ptrac($order) {
	global $procs, $Db1, $headers, $settings;
	if(SETTING_PTRA != true) {
		haultscript();
	}
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] ptr credits; Your business is appreciated!

To add these credits to your ad:
1. Log into your account
2. Click on 'Manage Ads'
3. Click 'PTR Ads'
4. Find the ad you wish to credit and click 'Add Credits'
5. Fill out the form

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE user SET ptra_credits=ptra_credits+($order[amount]*$settings[bog_amount]) WHERE username='$order[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Account PTR Credits For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}


function bought_banner($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] banner ad credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE banners SET credits=credits+($order[amount]*$settings[bog_amount]) WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Banner Credits For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_fbanner($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] featured banner ad credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE fbanners SET credits=credits+($order[amount]*$settings[bog_amount]) WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Featured Banner Credits For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_fad($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing $order[amount] featured ad credits; Your business is appreciated!

-$settings[domain_name] Bot",$headers);

	$sql=$Db1->query("UPDATE fads SET credits=credits+($order[amount]*$settings[bog_amount]) WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought ".$order[amount]." Featured Ad Credits For $cursym".$order[cost]." (".$order[ad_id].") (".$procs[$order[proc]].")', dsub='".time()."'");
}

function bought_flink($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);

	$sql=$Db1->query("SELECT * FROM flinks WHERE id='$order[ad_id]'");
	$ad=$Db1->fetch_array($sql);

	$duration=2678400*2678400*($order[amount]*$settings[bog_amount]);

	if($ad[pend] < time()) {
		$pend=time()+$duration;
	}
	else {
		$pend=$ad[pend]+$duration;
	}

	@mail($user[email],"Notification Of Purchase!","
Hello $user[name],
Thank you for purchasing a $order[amount] month featured link rotation; Your business is appreciated!

-$settings[domain_name] Bot",$headers);
	$sql=$Db1->query("UPDATE flinks SET ".iif($order[bgcolor]!="","bgcolor='$order[bgcolor]',")."  ".iif($order[marquee]==1,"marquee='1',")." dend='$pend' WHERE id='$order[ad_id]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought A ".$order[amount]." Month Featured Link Rotation For $cursym".$order[cost]." (".$procs[$order[proc]].")', dsub='".time()."'");
}



function bought_upgrade($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);
	$sql=$Db1->query("SELECT * FROM memberships WHERE id='$order[premium_id]'");
	$membership=$Db1->fetch_array($sql);

	$sql=$Db1->query("SELECT * FROM membership_benefits WHERE membership='$order[premium_id]' and time_type='U'");
		while($benefit = $Db1->fetch_array($sql)) {
			if($benefit[type] != "") {
				$sql=$Db1->query("UPDATE user SET $benefit[type]=$benefit[type]+$benefit[amount] WHERE username='$order[username]'");
			}
		}

	$duration=
		(
			iif($membership[time_type] == "D",86400).
			iif($membership[time_type] == "W",604800).
			iif($membership[time_type] == "M",2678400).
			iif($membership[time_type] == "Y",31536000).
			iif($membership[time_type] == "L",2365200000)
		)
	* ($order[amount] * $settings[bogomembership]);
	
	if(($user[pend] < time()) || ($user[membership] != $order[premium_id])) {
		$pend=time()+$duration;
	}
	else {
		$pend=$user[pend]+$duration;
	}

/*
	if(isset($user[refered])) {
		$sql=$Db1->query("SELECT type FROM user WHERE username='$user[refered]'");
		$referrerinfo=$Db1->fetch_array($sql);
		if($referrerinfo[type] == 1) {
			$sql=$Db1->query("UPDATE user SET
					points=points+$settings[premium_dl_upgrade]
					 WHERE username='$user[refered]'");
		}
	}
*/

	@mail($user[email],"Notification Of Account Upgrade!","
Hello $user[name],
Thank you for upgrading your account to $membership[title] at $settings[domain_name]

-$settings[domain_name] Bot
	",$headers);
	$sql=$Db1->query("UPDATE user SET
					type=1,
					membership='$order[premium_id]',
					pend='$pend'
					WHERE username='".$order[username]."'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought $membership[title] Membership For $cursym".$order[cost]." ($order[amount] ".
								iif($membership[time_type]=="D","Day").
								iif($membership[time_type]=="W","Week").
								iif($membership[time_type]=="M","Month").
								iif($membership[time_type]=="Y","Year").
								iif($membership[time_type]=="L","Lifetime").
							") (".$procs[$order[proc]].")', dsub='".time()."'");
}



function bought_special($order) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM specials WHERE id='$order[special_id]'");
	$special=$Db1->fetch_array($sql);
	$sql=$Db1->query("SELECT * FROM special_benefits WHERE special='$order[special_id]'");
		while($benefit = $Db1->fetch_array($sql)) {
if($benefit[type] != "") {
				if($benefit[type] == "tokens") {
					$Db1->query("INSERT INTO tokens SET 
						username='$order[username]',
						amount='$benefit[amount]',
						returnmin='$settings[token_min]',
						returnmax='$settings[token_max]',
						dsub='".time()."',
						payable='".(mktime(0,0,0,(date(m)+2),1,date(Y)))."',
						status='0'
					");
				}
}
			if($benefit[type] != "") {
			if($benefit[type] == "referrals") {
					$sql2=$Db1->query("SELECT userid FROM user WHERE refered='' and username!='$order[username]'");
					$totalrefsavailable=$Db1->num_rows();
					$refstoassign = $benefit[amount]* (($benefit[amount]*$order[amount])*$settings[bog_amount]);
					if($totalrefsavailable < $refstoassign) {
						$refstoassign=$totalrefsavailable;
						$amounts=1;
					}
					for($x=0; $x<$refstoassign; $x++) {
						assign($order[username]);
					}
				}
				else {
					$sql=$Db1->query("UPDATE user SET $benefit[type]=$benefit[type]+".((($benefit[amount]*$order[amount])*$settings[bog_amount]))." WHERE username='".addslashes($order[username])."'");
				}
			}
		}




	$sql=$Db1->query("SELECT * FROM user WHERE username='".$order[username]."'");
	$user=$Db1->fetch_array($sql);

	@mail($user[email],"Notification Of Account Upgrade!","
Hello $user[name],
Thank you for purchasing the advertising special entitled '$special[title]'

-$settings[domain_name] Bot
	",$headers);

	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought $special[title] Advertising Special For $cursym".$order[cost]." ($order[amount]) (".$procs[$order[proc]].")', dsub='".time()."'");
	
	$query=mysql_query("UPDATE specials SET buys=buys+1 WHERE title='$special[title]'");
}



function update_upline($username,$referrals1=0,$referrals2=0,$referrals3=0,$referrals4=0,$referrals5=0,$level) {
	global $procs, $Db1, $headers, $settings;
	if($level < 5) {
		$sql=$Db1->query("UPDATE user SET
			referrals1=referrals1+$referrals1,
			referrals2=referrals2+$referrals2,
			referrals3=referrals3+$referrals3,
			referrals4=referrals4+$referrals4,
			referrals5=referrals5+$referrals5,
			referrals=referrals+".($referrals1+$referrals2+$referrals3+$referrals4+$referrals5)."

		WHERE
		username='$username'
		");
		$sql=$Db1->query("SELECT refered FROM user WHERE username='$username'");
		$refered=$Db1->fetch_array($sql);
		if(($refered[refered] != $username)) {
			update_upline($refered[refered],0,$referrals1,$referrals2,$referrals3,$referrals4,($level+1));
		}
	}
}

function assign($username) {
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE refered='' and username!='$username' ORDER BY last_act DESC LIMIT 1");
	$referral=$Db1->fetch_array($sql);
	$sql=$Db1->query("UPDATE user SET refered='$username' WHERE username='$referral[username]'");

	update_upline($username,1,
		iif($referral['referrals1']=="",0,$referral['referrals1']),
		iif($referral['referrals2']=="",0,$referral['referrals2']),
		iif($referral['referrals3']=="",0,$referral['referrals3']),
		iif($referral['referrals4']=="",0,$referral['referrals4']),
	1);

}

function referrals($order) {
	global $procs, $Db1, $headers, $settings;
    $temp_refs = ($order[amount]*$settings[bogorefs]);
	for($x=0; $x<$temp_refs; $x++) {
		$return .= assign($order[username]);
	}
	$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Bought $order[amount] Referrals (".$procs[$order[proc]].")', dsub='".time()."'");
}


function doswitch($order) {
	switch($order[ad_type]) {
		case "link":
			bought_link($order);
		break;
		case "ptra":
			bought_ptra($order);
		break;
		case "ptrac":
			bought_ptrac($order);
		break;
		case "banner":
			bought_banner($order);
		break;
		case "fbanner":
			bought_fbanner($order);
		break;
		case "fad":
			bought_fad($order);
		break;
		case "linkc":
			bought_linkc($order);
		break;
		case "bannerc":
			bought_bannerc($order);
		break;
		case "fbannerc":
			bought_fbannerc($order);
		break;
		case "fadc":
			bought_fadc($order);
		break;
		case "ghitsc":
			bought_ghitsc($order);
		break;
		case "surfc":
			bought_surfc($order);
		break;
		case "flink":
			bought_flink($order);
		break;
		case "credits":
			bought_credits($order);
		break;
		case "upgrade":
			bought_upgrade($order);
		break;
		case "special":
			bought_special($order);
		break;
		case "ghits":
			bought_ghits($order);
		break;
		case "surf":
			bought_surf($order);
		break;
		case "popups":
			bought_popups($order);
		break;
		case "popupsc":
			bought_popupsc($order);
		break;
		case "ptr":
			bought_ptr($order);
		break;
		case "ptrc":
			bought_ptrc($order);
		break;
		case "ptsu":
			bought_ptsu($order);
		break;
		case "ptsuc":
			bought_ptsuc($order);
		break;
		case "gpoints":
			bought_gpoints($order);
		break;
		case "xcredits":
			bought_xcredits($order);
		break;
		case "referrals":
			referrals($order);
		break;
	}
}

if($haultswitch != true) {
	doswitch($order);
}
//**E**//
?>