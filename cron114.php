<?
include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);

include("includes/globals.php");



if($settings[purchcon_time] == daily) $purchcontime="Daily";
if($settings[ref_contest_time] == daily) $refcontime="Daily";
if($settings[tickets_time] == daily) $ticketscontime="Daily";
if($settings[clickc_time] == daily) $clickctime="Daily";
	if($settings[purchcon_on] == 1 && $settings[purchcon_time] == daily) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type]=$settings[purchcon_type]+$settings[purchcon_amount] WHERE username='$purwinner[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner[username]."', log='Won 1st in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner[email]","You Have Won 1st In Our $purchcontime Purchase Contest!","Congratulations $purwinner[name]!\nThis is an automated email to inform you that you have won\n1st place ($settings[purchcon_amount] $settings[purchcon_type])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}

	if($settings[purchcon_on] == 1 && $settings[purchcon_draw] == 2 && $settings[purchcon_time] == daily) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner2=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type2]=$settings[purchcon_type2]+$settings[purchcon_amount2] WHERE username='$purwinner2[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner2[username]."', log='Won 2nd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner2[email]","You Have Won 2nd In Our $purchcontime Purchase Contest!","Congratulations $purwinner2[name]!\nThis is an automated email to inform you that you have won\n2nd place ($settings[purchcon_amount2] $settings[purchcon_type2])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[purchcon_on] == 1 && $settings[purchcon_draw] == 3 && $settings[purchcon_time] == daily) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner2=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type2]=$settings[purchcon_type2]+$settings[purchcon_amount2] WHERE username='$purwinner2[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner2[username]."', log='Won 2nd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner2[email]","You Have Won 2nd In Our $purchcontime Purchase Contest!","Congratulations $purwinner2[name]!\nThis is an automated email to inform you that you have won\n2nd place ($settings[purchcon_amount2] $settings[purchcon_type2])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
	flush();}
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner3=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type3]=$settings[purchcon_type3]+$settings[purchcon_amount3] WHERE username='$purwinner3[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner3[username]."', log='Won 3rd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner3[email]","You Have Won 3rd In Our $purchcontime Purchase Contest!","Congratulations $purwinner3[name]!\nThis is an automated email to inform you that you have won\n3rd place ($settings[purchcon_amount3] $settings[purchcon_type3])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[purchcon_on] == 1 && $settings[purchcon_time] == daily) {
	$sql=$Db1->query("UPDATE user SET purchcon_tic='0'");
}
	if($settings[clickc_on] == 1 && $settings[clickc_time] == daily){
		$sql=$Db1->query("SELECT * FROM user WHERE clickcon_clic>0 ORDER BY clickcon_clic DESC LIMIT $settings[clickc_draw]");
		$cliwinner=$Db1->fetch_array($sql);
		if($cliwinner[username] != "") {
			$sql=$Db1->query("UPDATE user SET $settings[clickc_type]=$settings[clickc_type]+$settings[clickc_amount] WHERE userid='$cliwinner[userid]'");
			@mail("$cliwinner[email]","You Have Won Our $clickctime Click Contest!","Congratulations $cliwinner[name]!\nThis is an automated email to inform you that you have won our $clickctime click contest!","From: $settings[admin_email]");
			$sql=$Db1->query("INSERT INTO logs SET username='".$cliwinner[username]."', log='Won the $clickctime click contest', dsub='".time()."'");
			echo "<!-- EMAILING MEMBER $cliwinner[username]-->";
		}
	}
	if($settings[clickc_on] == 1 && $settings[clickc_time] == daily) {
	$sql=$Db1->query("UPDATE user SET clickcon_clic='0'");
}
	if($settings[tickets_on] == 1 && $settings[tickets_time] == daily) {
		$sql=$Db1->query("SELECT * FROM user WHERE tickets>0 ORDER BY rand() LIMIT $settings[tickets_draw]");
		while($winner=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[tickets_win_type]=$settings[tickets_win_type]+$settings[tickets_win_amount] WHERE username='$winner[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$winner[username]."', log='Won the $ticketscontime ticket drawing.', dsub='".time()."'");
			@mail("$winner[email]","You Have Won Our $ticketscontime Ticket Drawing!","Congratulations $winner[name]!\nThis is an automated email to inform you that you have won our $ticketscontime ticket drawing!","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[tickets_on] == 1 && $settings[tickets_time] == daily) {
	$sql=$Db1->query("UPDATE user SET tickets='0'");
}
	if($settings[ref_contest_on] == 1 && $settings[ref_contest_time] == daily) {
		$sql=$Db1->query("SELECT * FROM user WHERE week_refs>0 ORDER BY week_refs DESC LIMIT 1");
		$refwinner=$Db1->fetch_array($sql);
		if($refwinner[username] != "") {
			$sql=$Db1->query("UPDATE user SET $settings[ref_contest_type]=$settings[ref_contest_type]+$settings[ref_contest_amount] WHERE userid='$refwinner[userid]'");
			@mail("$refwinner[email]","You Have Won Our $refcontime Referral Contest!","Congratulations $refwinner[name]!\nThis is an automated email to inform you that you have won our $refcontime referral contest!","From: $settings[admin_email]");
			$sql=$Db1->query("INSERT INTO logs SET username='".$refwinner[username]."', log='Won the $refcontime referral contest', dsub='".time()."'");
			echo "<!-- EMAILING MEMBER $refwinner[username]-->";
		}
		else {
			$sql=$Db1->query("INSERT INTO logs SET log='There was no referral contest winner', dsub='".time()."'");
		}
	}
    if($settings[ref_contest_on] == 1 && $settings[ref_contest_time] == daily) {
   echo "<!-- Resetting user daily stats -->\n"; flush();
   $sql=$Db1->query("UPDATE user SET week_refs=0");
}
	echo "<!-- Resetting Template Hits -->\n"; flush();
	$sql=$Db1->query("UPDATE templates SET hits_today=0");

	echo "<!-- Resetting  ad views-->\n"; flush();
	$Db1->query("UPDATE ads SET views_today=0");
	$Db1->query("UPDATE ads SET oviews_today=0");
	$Db1->query("UPDATE ptrads SET views_today=0");
	$Db1->query("UPDATE banners SET views_today=0");
	$Db1->query("UPDATE fads SET views_today=0");
    $Db1->query("UPDATE fbanners SET views_today=0");
	$Db1->query("UPDATE emails SET views_today=0");
    $Db1->query("DELETE FROM click_history ");
	$Db1->query("UPDATE xsites SET views_today=0");
	$Db1->query("UPDATE popups SET views_today=0");
	$Db1->query("UPDATE ptsuads SET signups_today=0");

	echo "<!-- Resetting user daily stats -->\n"; flush();
	$sql=$Db1->query("UPDATE user SET clicked_today=0, xclicked_today=0, ptphits_today=0, earned_today=0, ptra_clicks_today='0', emails_today='0', floodguard_today='0', ref_hits_unique='0', ref_hits_raw='0'");

	echo "<!-- Resetting ad click history -->\n"; flush();
	$browseval=$Db1->query("DELETE FROM click_history WHERE type!='ptre'");

	$sql=$Db1->query("DELETE FROM dailyhits");

	echo "<!-- Resetting orders -->\n"; flush();
	$sql=$Db1->query("DELETE FROM orders WHERE paid='0' and dsub<".(time()-604800)."");

	echo "<!-- Updating expired premiums -->\n"; flush();
	$sql=$Db1->query("UPDATE user SET type='0', membership='0' WHERE type='1' and pend<".time()."");

	if($settings["ptsu_mode"] == 2 && $settings[ptsuAdvTimeout] > 1) {
		$sql = $Db1->query("SELECT * FROM ptsu_log WHERE status='2' and dsub<='".(time()-(60*60*24*$settings[ptsuAdvTimeout]))."'");
		while($temp = $Db1->fetch_array($sql)) {
			processSignup($temp[id], 1);
		}
	}


	echo "<!-- unsuspending timed suspensions -->\n"; flush();
	$Db1->query("UPDATE user SET suspended=0, suspendTime=0, suspendMsg='' WHERE suspendTime>100 and suspendTime<".time()."  and suspended='1'");

	echo "<!-- starting membership benefits loops -->\n"; flush();
	$sql=$Db1->query("SELECT * FROM membership_benefits WHERE
			(time_type='D') or
			(time_type='W' and time='".(date('w')+1)."') or
			(time_type='M' and time='".(date('j'))."')
	");
	while($temp=$Db1->fetch_array($sql)) {
		echo " <!-- Updating Premium members -->\n";
		$Db1->query("UPDATE user SET $temp[type]=$temp[type]+$temp[amount] WHERE membership='$temp[membership]' and type='1'");
		$Db1->query("INSERT INTO logs SET log='Assigning Membership Bonus [$temp[membership]] [$temp[amount] $temp[type]]', dsub='".time()."'");
	}
	echo "<!-- membership benefits loops done -->\n"; flush();


	$sql=$Db1->query("INSERT INTO logs SET log='Cron [Daily] Completed Successfully', dsub='".time()."'");
	echo "<!-- Cron completed successfully -->\n"; flush();

// End Of Dsily / Start of Weekly
$weekday = date("w");
if ($weekday == "6"){
    if($settings[purchcon_time] == weekly) $purchcontime="Weekly";
if($settings[ref_contest_time] == weekly) $refcontime="Weekly";
if($settings[tickets_time] == weekly) $ticketscontime="Weekly";
if($settings[clickc_time] == weekly) $clickctime="Weekly";
	if($settings[purchcon_on] == 1 && $settings[purchcon_time] == weekly) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type]=$settings[purchcon_type]+$settings[purchcon_amount] WHERE username='$purwinner[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner[username]."', log='Won 1st in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner[email]","You Have Won 1st In Our $purchcontime Purchase Contest!","Congratulations $purwinner[name]!\nThis is an automated email to inform you that you have won\n1st place ($settings[purchcon_amount] $settings[purchcon_type])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}

	if($settings[purchcon_on] == 1 && $settings[purchcon_draw] == 2 && $settings[purchcon_time] == weekly) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner2=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type2]=$settings[purchcon_type2]+$settings[purchcon_amount2] WHERE username='$purwinner2[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner2[username]."', log='Won 2nd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner2[email]","You Have Won 2nd In Our $purchcontime Purchase Contest!","Congratulations $purwinner2[name]!\nThis is an automated email to inform you that you have won\n2nd place ($settings[purchcon_amount2] $settings[purchcon_type2])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[purchcon_on] == 1 && $settings[purchcon_draw] == 3 && $settings[purchcon_time] == weekly) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner2=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type2]=$settings[purchcon_type2]+$settings[purchcon_amount2] WHERE username='$purwinner2[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner2[username]."', log='Won 2nd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner2[email]","You Have Won 2nd In Our $purchcontime Purchase Contest!","Congratulations $purwinner2[name]!\nThis is an automated email to inform you that you have won\n2nd place ($settings[purchcon_amount2] $settings[purchcon_type2])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
	flush();}
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner3=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type3]=$settings[purchcon_type3]+$settings[purchcon_amount3] WHERE username='$purwinner3[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner3[username]."', log='Won 3rd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner3[email]","You Have Won 3rd In Our $purchcontime Purchase Contest!","Congratulations $purwinner3[name]!\nThis is an automated email to inform you that you have won\n3rd place ($settings[purchcon_amount3] $settings[purchcon_type3])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[purchcon_on] == 1 && $settings[purchcon_time] == weekly) {
	$sql=$Db1->query("UPDATE user SET purchcon_tic='0'");
}
	if($settings[clickc_on] == 1 && $settings[clickc_time] == weekly){
		$sql=$Db1->query("SELECT * FROM user WHERE clickcon_clic>0 ORDER BY clickcon_clic DESC LIMIT $settings[clickc_draw]");
		$cliwinner=$Db1->fetch_array($sql);
		if($cliwinner[username] != "") {
			$sql=$Db1->query("UPDATE user SET $settings[clickc_type]=$settings[clickc_type]+$settings[clickc_amount] WHERE userid='$cliwinner[userid]'");
			@mail("$cliwinner[email]","You Have Won Our $clickctime Click Contest!","Congratulations $cliwinner[name]!\nThis is an automated email to inform you that you have won our $clickctime click contest!","From: $settings[admin_email]");
			$sql=$Db1->query("INSERT INTO logs SET username='".$cliwinner[username]."', log='Won the $clickctime click contest', dsub='".time()."'");
			echo "<!-- EMAILING MEMBER $cliwinner[username]-->";
		}
	}
	if($settings[clickc_on] == 1 && $settings[clickc_time] == weekly) {
	$sql=$Db1->query("UPDATE user SET clickcon_clic='0'");
}
	if($settings[tickets_on] == 1 && $settings[tickets_time] == weekly) {
		$sql=$Db1->query("SELECT * FROM user WHERE tickets>0 ORDER BY rand() LIMIT $settings[tickets_draw]");
		while($winner=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[tickets_win_type]=$settings[tickets_win_type]+$settings[tickets_win_amount] WHERE username='$winner[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$winner[username]."', log='Won the $ticketscontime ticket drawing.', dsub='".time()."'");
			@mail("$winner[email]","You Have Won Our $ticketscontime Ticket Drawing!","Congratulations $winner[name]!\nThis is an automated email to inform you that you have won our $ticketscontime ticket drawing!","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[tickets_on] == 1 && $settings[tickets_time] == weekly) {
	$sql=$Db1->query("UPDATE user SET tickets='0'");
}
	if($settings[ref_contest_on] == 1 && $settings[ref_contest_time] == weekly) {
		$sql=$Db1->query("SELECT * FROM user WHERE week_refs>0 ORDER BY week_refs DESC LIMIT 1");
		$refwinner=$Db1->fetch_array($sql);
		if($refwinner[username] != "") {
			$sql=$Db1->query("UPDATE user SET $settings[ref_contest_type]=$settings[ref_contest_type]+$settings[ref_contest_amount] WHERE userid='$refwinner[userid]'");
			@mail("$refwinner[email]","You Have Won Our $refcontime Referral Contest!","Congratulations $refwinner[name]!\nThis is an automated email to inform you that you have won our $refcontime referral contest!","From: $settings[admin_email]");
			$sql=$Db1->query("INSERT INTO logs SET username='".$refwinner[username]."', log='Won the $refcontime referral contest', dsub='".time()."'");
			echo "<!-- EMAILING MEMBER $refwinner[username]-->";
		}
		else {
			$sql=$Db1->query("INSERT INTO logs SET log='There was no referral contest winner', dsub='".time()."'");
		}
	}
	$sql=$Db1->query("DELETE FROM error_log");
	$sql=$Db1->query("DELETE FROM footprints");
	if($settings[ref_contest_on] == 1 && $settings[ref_contest_time] == weekly) {
	$sql=$Db1->query("UPDATE user SET week_refs='0'");
		}
	$sql=$Db1->query("INSERT INTO logs SET log='Cron [Weekly] Completed Successfully', dsub='".time()."'");
	echo "<!-- Cron completed successfully -->\n"; flush();
    }
 
 // End Of Weekly Start of Monthly
 $weekday = date("j");
if ($weekday == "1"){
    
if($settings[purchcon_time] == monthly) $purchcontime="Monthly";
if($settings[ref_contest_time] == monthly) $refcontime="Monthly";
if($settings[tickets_time] == monthly) $ticketscontime="Monthly";
if($settings[clickc_time] == monthly) $clickctime="Monthly";
	if($settings[purchcon_on] == 1 && $settings[purchcon_time] == monthly) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type]=$settings[purchcon_type]+$settings[purchcon_amount] WHERE username='$purwinner[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner[username]."', log='Won 1st in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner[email]","You Have Won 1st In Our $purchcontime Purchase Contest!","Congratulations $purwinner[name]!\nThis is an automated email to inform you that you have won\n1st place ($settings[purchcon_amount] $settings[purchcon_type])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}

	if($settings[purchcon_on] == 1 && $settings[purchcon_draw] == 2 && $settings[purchcon_time] == monthly) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner2=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type2]=$settings[purchcon_type2]+$settings[purchcon_amount2] WHERE username='$purwinner2[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner2[username]."', log='Won 2nd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner2[email]","You Have Won 2nd In Our $purchcontime Purchase Contest!","Congratulations $purwinner2[name]!\nThis is an automated email to inform you that you have won\n2nd place ($settings[purchcon_amount2] $settings[purchcon_type2])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[purchcon_on] == 1 && $settings[purchcon_draw] == 3 && $settings[purchcon_time] == monthly) {
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner2=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type2]=$settings[purchcon_type2]+$settings[purchcon_amount2] WHERE username='$purwinner2[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner2[username]."', log='Won 2nd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner2[email]","You Have Won 2nd In Our $purchcontime Purchase Contest!","Congratulations $purwinner2[name]!\nThis is an automated email to inform you that you have won\n2nd place ($settings[purchcon_amount2] $settings[purchcon_type2])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
	flush();}
		$sql=$Db1->query("SELECT * FROM user WHERE purchcon_tic>0 ORDER BY rand() LIMIT 1");
		while($purwinner3=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[purchcon_type3]=$settings[purchcon_type3]+$settings[purchcon_amount3] WHERE username='$purwinner3[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$purwinner3[username]."', log='Won 3rd in the $purchcontime Purchase Contest.', dsub='".time()."'");
			@mail("$purwinner3[email]","You Have Won 3rd In Our $purchcontime Purchase Contest!","Congratulations $purwinner3[name]!\nThis is an automated email to inform you that you have won\n3rd place ($settings[purchcon_amount3] $settings[purchcon_type3])  \nin our $purchcontime Purchase Contest!\n$settings[base_url]","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[purchcon_on] == 1 && $settings[purchcon_time] == monthly) {
	$sql=$Db1->query("UPDATE user SET purchcon_tic='0'");
}
	if($settings[clickc_on] == 1 && $settings[clickc_time] == monthly){
		$sql=$Db1->query("SELECT * FROM user WHERE clickcon_clic>0 ORDER BY clickcon_clic DESC LIMIT $settings[clickc_draw]");
		$cliwinner=$Db1->fetch_array($sql);
		if($cliwinner[username] != "") {
			$sql=$Db1->query("UPDATE user SET $settings[clickc_type]=$settings[clickc_type]+$settings[clickc_amount] WHERE userid='$cliwinner[userid]'");
			@mail("$cliwinner[email]","You Have Won Our $clickctime Click Contest!","Congratulations $cliwinner[name]!\nThis is an automated email to inform you that you have won our $clickctime click contest!","From: $settings[admin_email]");
			$sql=$Db1->query("INSERT INTO logs SET username='".$cliwinner[username]."', log='Won the $clickctime click contest', dsub='".time()."'");
			echo "<!-- EMAILING MEMBER $cliwinner[username]-->";
		}
	}
	if($settings[clickc_on] == 1 && $settings[clickc_time] == monthly) {
	$sql=$Db1->query("UPDATE user SET clickcon_clic='0'");
}
	if($settings[tickets_on] == 1 && $settings[tickets_time] == monthly) {
		$sql=$Db1->query("SELECT * FROM user WHERE tickets>0 ORDER BY rand() LIMIT $settings[tickets_draw]");
		while($winner=$Db1->fetch_array($sql)) {
			$sql=$Db1->query("UPDATE user SET $settings[tickets_win_type]=$settings[tickets_win_type]+$settings[tickets_win_amount] WHERE username='$winner[username]'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$winner[username]."', log='Won the $ticketscontime ticket drawing.', dsub='".time()."'");
			@mail("$winner[email]","You Have Won Our $ticketscontime Ticket Drawing!","Congratulations $winner[name]!\nThis is an automated email to inform you that you have won our $ticketscontime ticket drawing!","From: $settings[admin_email]");
			echo "<!-- EMAILING MEMBER $winner[username]-->";
			flush();
		}
	}
	if($settings[tickets_on] == 1 && $settings[tickets_time] == monthly) {
	$sql=$Db1->query("UPDATE user SET tickets='0'");
}
	if($settings[ref_contest_on] == 1 && $settings[ref_contest_time] == monthly) {
		$sql=$Db1->query("SELECT * FROM user WHERE week_refs>0 ORDER BY week_refs DESC LIMIT 1");
		$refwinner=$Db1->fetch_array($sql);
		if($refwinner[username] != "") {
			$sql=$Db1->query("UPDATE user SET $settings[ref_contest_type]=$settings[ref_contest_type]+$settings[ref_contest_amount] WHERE userid='$refwinner[userid]'");
			@mail("$refwinner[email]","You Have Won Our $refcontime Referral Contest!","Congratulations $refwinner[name]!\nThis is an automated email to inform you that you have won our $refcontime referral contest!","From: $settings[admin_email]");
			$sql=$Db1->query("INSERT INTO logs SET username='".$refwinner[username]."', log='Won the $refcontime referral contest', dsub='".time()."'");
			echo "<!-- EMAILING MEMBER $refwinner[username]-->";
		}
		else {
			$sql=$Db1->query("INSERT INTO logs SET log='There was no referral contest winner', dsub='".time()."'");
		}
	}
       if($settings[ref_contest_on] == 1 && $settings[ref_contest_time] == monthly) {
   $sql=$Db1->query("UPDATE user SET week_refs='0'");
      }
	$tables = $Db1->get_tables();
	for($x=0; $x<count($tables); $x++) {
	//	echo "<li>".$tables[$x]."<br /><menu>";
		if($x < (count($tables)-1)) {
			$xtra=", ";
		}
		else {
			$xtra="";
		}
		$optimize.=" `".$tables[$x]."`".$xtra;
		$fields=$Db1->get_fields($tables[$x]);
		for($y=0; $y<count($fields); $y++) {
	//		echo "<li>".$fields[$y]."";
		}
	//	echo "</menu>";
	}
	$Db1->query("REPAIR TABLE $optimize;");
	$Db1->query("OPTIMIZE TABLE $optimize;");
	$sql=$Db1->query("INSERT INTO logs SET log='Cron [Monthly] Completed Successfully', dsub='".time()."'");
	echo "<!-- Cron completed successfully -->\n"; flush();
    }
 // End Of Monthly / Start of Paid Emails
 
 function get_users($count, $country) {
	global $Db1;
	$sql=$Db1->query("SELECT username, name, email FROM user WHERE suspended=0 and optin='1' ".iif($country != ""," and country='$country'")." ORDER BY rand() LIMIT $count");
	for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
		$list[$x]=$temp;
	}
	return $list;
}




	$sql=$Db1->query("DELETE FROM pending_emails");
	$sql=$Db1->query("SELECT * FROM emails WHERE credits>=1");
	while($mail=$Db1->fetch_array($sql)) {
		$mailid=$mail[id];
		echo "<!-- Starting Email Loop -->\n\n"; flush();
		$emailsubject = "$mail[title]";
		$emailbody = "".stripslashes($mail[description])."\n\n";
		$users = get_users($mail[credits], $mail[country]);
		$user_index=0;
		echo ceil($mail[credits]/100);
		for($x=0; $x<ceil($mail[credits]/100); $x++) {
			if($user_index < count($users)) {
				echo "<!-- Starting Email Loop 2 -->\n\n"; flush();
				$list="";
				for ($y=0; $y<100; $y++) {
					echo "<!-- Starting Email Loop 3 -->\n\n"; flush();
					if($user_index < count($users)) {
						$list .= $users[$user_index][name].":".$users[$user_index][email].":".$users[$user_index][username]."\n";
						$user_index++;
					}
				}
				echo "<!-- Creating Entry -->\n\n"; flush();
				$Db1->query("INSERT INTO pending_emails SET
					mailid='".$mailid."',
					subject='".addslashes($emailsubject)."',
					body='".addslashes($emailbody)."',
					tolist='".addslashes($list)."'
				");
			}
		}
	}

 
   

$Db1->sql_close();
exit;
?>
