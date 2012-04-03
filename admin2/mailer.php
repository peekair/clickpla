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
$includes[title]="Member Mailer";

$success=0;
$failed=0;


function send_the_mail($username, $mail) {
	global $Db1, $total, $total_sent;
	$sql=$Db1->query("SELECT * FROM user WHERE username='".addslashes($username)."'");
	$userinfo=$Db1->fetch_array($sql);
	$success=0;
	$mail[message]=addslashes(addslashes($mail[message]));
	echo '<script>if (document.getElementById("status_total")) document.getElementById("status_total").innerHTML="'.$total.'"</script>';
	eval("\$tempmsg = \"$mail[message]\";");
	eval("\$tempsubject = \"$mail[subject]\";");
	$tempmsg=stripslashes(stripslashes($tempmsg));

	if(send_mail($userinfo[email],$userinfo[name],$tempsubject,$tempmsg,$mail[from])) {
		$total_sent++;
		echo '<script>if (document.getElementById("status_percent")) document.getElementById("status_percent").innerHTML="'.@round(@($total_sent)/$total*100).'"</script>';
		echo '<script>if (document.getElementById("status_sent")) document.getElementById("status_sent").innerHTML="'.@($total_sent).'"</script>';
		echo '<script>if (document.getElementById("status_bar")) document.getElementById("status_bar").style.width='.@(round(@($total_sent)/$total*100)*3).'</script>';
		flush();
	}
	return $success;
}



if($action == "create_session") {
	$time=time();

	$subject = addslashes(stripslashes(stripslashes($subject)));
	$msg = addslashes(stripslashes(stripslashes($msg)));

	$sql=$Db1->query("SELECT COUNT(userid) AS total FROM user WHERE suspended=0 ".iif($condition!="","and ".(stripslashes($condition)))."");
	$total=$Db1->fetch_array($sql);

	$Db1->query("INSERT INTO mailer_sessions SET
		subject='$subject',
		`from`='$fromaddr',
		message='$msg',
		dsub='$time',
		`total`='$total[total]'
	");

	echo "Creating Mailer Session...<br />";
	flush();

	$sql=$Db1->query("SELECT id FROM mailer_sessions WHERE dsub='$time'");
	$temp=$Db1->fetch_array($sql);
	$id=$temp[id];
	$sql=$Db1->query("SELECT username FROM user ".iif($condition!="","WHERE ".(stripslashes($condition)))."");
	echo "Compiling Mailing List (this may take a moment)<br />";
	flush();
	for($x=0; $temp=$Db1->fetch_array($sql); $x++) {

		echo ". ";
		flush();

		$Db1->query("INSERT INTO mailer_lists SET
			mail_id='$id',
			username='".addslashes($temp[username])."'
		");
	}

	echo "<br />Redirecting To Next Step...<br />
	<script>location.href='admin.php?view=admin&ac=mailer&action=send&id=$id&".$url_variables."';</script>";
	flush();
	$Db1->sql_close();
	exit;
}



if($action == "send") {
	if($id == "") {
		$Db1->sql_close();
		echo "There was an error! A mailer session ID was not detected.";
		exit;
	}
	else {
		$sql=$Db1->query("SELECT * FROM mailer_sessions WHERE id='$id'");
		$mail_info=$Db1->fetch_array($sql);

		$total=$mail_info[total];
		$total_sent=$mail_info[sent];

		echo "Your message is being sent to $total. Do not close this window or hit any browse button (back, forward, stop, ect)<br />This can take SEVERAL minutes depending on the number of emails being sent.<br /><br />
<b><span id=\"status_sent\"></span></b> / <b><span id=\"status_total\"></span></b> sent!<br />

<div style=\"background-color: gray; width: 300; height: 15; padding: 0px; margin: 0px;\">
			<div style=\"background-color: darkblue; width: 1; height: 15;\" id=\"status_bar\"></div>
</div>
<span id=\"status_percent\"></span>% Complete<br /><br />If this page times out, you can simply refresh this URL and it will pick up where it left off.
	";
		flush();

		$sql=$Db1->query("SELECT * FROM mailer_lists WHERE mail_id='$id' LIMIT 100");
		if($Db1->num_rows() > 0) {
			while($temp=$Db1->fetch_array($sql)) {
				send_the_mail($temp[username], $mail_info);
				$Db1->query("DELETE FROM mailer_lists WHERE mail_id='$id' AND username='".addslashes($temp[username])."'");
			}
			$Db1->query("UPDATE mailer_sessions SET sent='$total_sent' WHERE id='$id'");
			echo "Redirecting To Next Step...<br />
			<script>location.href='admin.php?view=admin&ac=mailer&action=send&id=$id&".$url_variables."';</script>";
			flush();
			$Db1->sql_close();
			exit;
		}
		else {
			$Db1->query("UPDATE mailer_sessions SET status='1' WHERE id='$id'");
			echo "Completing...<br />
			<script>location.href='admin.php?view=admin&ac=mailer&action=complete&id=$id&".$url_variables."';</script>";
			flush();
			$Db1->sql_close();
			exit;
		}
	}
}


if($action == "complete") {
	$sql=$Db1->query("SELECT * FROM mailer_sessions WHERE id='$id'");
	$mail_info=$Db1->fetch_array($sql);
	$includes[content]="<div style=\"color: darkred;\"><b>All Done!</b><br />The mailer has sent $mail_info[sent] emails!</div><br />";
}


$msg = "\n\nAdmin@$settings[domain_name]\nhttp://$settings[domain_name]";

$includes[content].="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=mailer&action=create_session&".$url_variables."\" method=\"post\">



			<table cellspacing=\"1\" cellpadding=\"0\" border=0>
				<tr>
					<td valign=\"top\">Subject:</td>
					<td><input type=\"text\" name=\"subject\" size=\"35\"></td>
				</tr>
				<tr>
					<td valign=\"top\">From Address:</td>
					<td><input type=\"text\" name=\"fromaddr\" value=\"no-reply@$settings[domain_name]\" size=\"35\"></td>
				</tr>
				<tr>
					<td valign=\"top\">Condition: </td>
					<td><input type=\"text\" name=\"condition\" value=\"\" size=\"35\"> ".show_help('Only use this option if you know what you are doing? This field allows you to add conditions to the select user query. An example condition is:\\'.'nverified=\\\'0\\\'')."</td>
				</tr>
				<tr>
										<td colspan=2 align=\"left\"><textarea cols=50 rows=13 name=\"msg\">$msg</textarea></td>
				</tr>
				<tr>
					<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Mail Them Now\"></td>
				</tr>
			</table>

</form>
</div>
<div align=\"left\">
<b>Variables Help</b><br />
You can have each email be unique to the member it is being sent to. Simpy enter any of the following variables in the subject or message body where you want the corresponding text to be shown.<br />
<br />
<table>
	<tr>
		<td width=180>\$userinfo[username]</td>
		<td>Username</td>
	</tr>
	<tr>
		<td>\$userinfo[email]</td>
		<td>Email</td>
	</tr>
	<tr>
		<td>\$userinfo[name]</td>
		<td>Full Name</td>
	</tr>
	<tr>
		<td>\$userinfo[password]</td>
		<td>Password</td>
	</tr>
	<tr>
		<td>\$userinfo[balance]</td>
		<td>Balance</td>
	</tr>
</table>
</div>

";

?>
