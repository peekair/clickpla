<?
include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
include("includes/globals.php");

$mpp = 50;
$success=0;
$fail=0;

function send_the_mail($username, $mail) {

	global $Db1, $success, $fail;

	$sql=$Db1->query("SELECT * FROM user WHERE username='".addslashes($username)."'");
	$userinfo=$Db1->fetch_array($sql);
	$mail[message]=addslashes(addslashes($mail[message]));
	eval("\$tempmsg = \"$mail[message]\";");
	eval("\$tempsubject = \"$mail[subject]\";");
	$tempmsg=stripslashes(stripslashes($tempmsg));
	echo "."; flush();
	if(send_mail($userinfo[email],$userinfo[name],$tempsubject,$tempmsg)) {
		$success+=1;
	}
	else {
		$fail+=1;
	}
}
// End of Admin Mailer

		$mail_info=$Db1->query_first("SELECT * FROM user, mailer_sessions WHERE status='0' and moptin='1' ORDER BY dsub LIMIT 1");
		$id = $mail_info['id'];

		$total=$mail_info[total];
		$total_sent=$mail_info[sent];

		$sql=$Db1->query("SELECT * FROM mailer_lists WHERE mail_id='$id' LIMIT $mpp");
		$count = $Db1->num_rows();
		if($count > 0) {
			while($temp=$Db1->fetch_array($sql)) {
				send_the_mail($temp[username], $mail_info);
				$Db1->query("DELETE FROM mailer_lists WHERE id='{$temp[id]}'");
			}
			$Db1->query("UPDATE mailer_sessions SET sent=sent+{$success}, failed=failed+{$fail} WHERE id='$id'");
		}
		if($count < $mpp) {
			$Db1->query("UPDATE mailer_sessions SET status='1' WHERE id='$id'");
		}
	
    	$sql=$Db1->query("SELECT COUNT(id) AS total FROM pending_emails");
	$total=$Db1->fetch_array($sql);
	
	$timeend=mktime(0,0,0,date("n"),(date("j")+1),date("y"));
	$runs_left=(($timeend-time())/60/5)-2;
	$entries=ceil(($total[total]/$runs_left));
	
	$sql=$Db1->query("SELECT * FROM pending_emails LIMIT $entries");
	for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
		$emails[$x]=$temp;
		$Db1->query("DELETE FROM pending_emails WHERE id='".$emails[$x][id]."'");
	}
	$Db1->sql_close();
	for($x=0; $x<count($emails); $x++) {
		$subject1 = $emails[$x][subject];
		$mailid = $emails[$x][mailid];
		$body1 = $emails[$x][body];
		$tolist = $emails[$x][tolist];
		$users=explode("\n",$tolist);
		for($y=0; $y<count($users); $y++) {
			$user=explode(":",$users[$y]);
			$subject = "$settings[site_title] Paid Email: $subject1";
			$body = "".stripslashes($body1)."\n\n
To receive credit for this email, Please click the following URL
$settings[base_url]/gpt.php?v=entry&type=ptre&user=$user[2]&id=$mailid
\n
--------------------------------------------------------------
$settings[site_title] Paid Email
You are receiving this email because you are a member of
$settings[domain_name] and have opted in to receiving paid emails. If
you want to stop receiving emails, please login to your account turn
off paid emails in your profile page. DO NOT REPLY TO THIS EMAIL, IT WILL NEVER BE SEEN!
--------------------------------------------------------------";
			send_mail($user[1],$user[0],$subject,$body);
			echo ".";

		}
	}
// End of Paid Email Mailer
if($settings[new_ad_alert]!=1) {
	$Db1->sql_close();
	exit;
}
else {

	$sql=$Db1->query("SELECT * FROM ad_alert_sessions");
	if($Db1->num_rows() > 0) {
		echo "Session Found!<br />";
		flush();
		$email=$Db1->fetch_array($sql);
		$sql=$Db1->query("SELECT userid, name, email FROM user WHERE ad_tag='1' and ad_alert_login='1' LIMIT 100");
		if($Db1->num_rows() == 0 || $Db1->num_rows() < 100) {
			$Db1->query("DELETE FROM ad_alert_sessions");
			echo "No Members Found To Email!<br />";
			flush();
		}
		while($temp = $Db1->fetch_array($sql)) {
			echo "Emailing $temp[email]";
			flush();
			$suc = send_mail($temp[email],$temp[name],"New Ad Alert!",$email[email]);
			echo iif($suc==0,".... failed",".... success")."<br />";
			flush();
			$Db1->query("UPDATE user SET ad_tag='0', ad_alert_login='0' WHERE userid='$temp[userid]'");
		}
		$Db1->sql_close();
		exit;
	}
	else {
		echo "No sessions found<br />";
		flush();
		$adListing="";
		$adCount=0;
		if($settings[ad_alert_ptc]) {
			$sql=$Db1->query("SELECT COUNT(id) AS total FROM ads WHERE new=1 and credits>0");
			$temp = $Db1->fetch_array($sql);
			$adCount+=$temp[total];
			if($temp[total] > 0) $adListing.="New Paid To Click Ads: ".$temp[total]."\n";
			$Db1->query("UPDATE ads SET new=0 WHERE new=1 and credits>0");
		}
		if($settings[ad_alert_ptsu]) {
			$sql=$Db1->query("SELECT COUNT(id) AS total FROM ptsuads WHERE  new=1 and credits>0 and active='1'");
			$temp = $Db1->fetch_array($sql);
			$adCount+=$temp[total];
			if($temp[total] > 0) $adListing.="New Paid To Signup Offers: ".$temp[total]."\n";
			$Db1->query("UPDATE ptsuads SET new=0 WHERE new=1 and credits>0");
		}
		if($settings[ad_alert_ptra]) {
			$sql=$Db1->query("SELECT COUNT(id) AS total FROM ptrads WHERE  new=1 and credits>0");
			$temp = $Db1->fetch_array($sql);
			$adCount+=$temp[total];
			if($temp[total] > 0) $adListing.="New Paid To Read Ads: ".$temp[total]."\n";
			$Db1->query("UPDATE ptrads SET new=0 WHERE new=1 and credits>0");
		}
		
		if($adCount > 0) {
			echo "$adCount Ads Found!<br />";
			flush();
			$adListing="This is an automated message to inform you that there are $adCount new ads available to click at $settings[site_title]!

$adListing


$settings[base_url]";
		
			$Db1->query("INSERT INTO ad_alert_sessions SET
				email='$adListing',
				dsub='".time()."'
			");
			$Db1->query("UPDATE user SET ad_tag='1' WHERE ad_alert='1' ".iif($settings[ad_alert_group] != 2,"and type='1'")."");
		}
	}
    }
    // End of Ad Alerts
    

$Db1->sql_close();
exit;

//**E**//


?>