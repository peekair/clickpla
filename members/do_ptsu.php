<?
$includes[title]="Complete Signup Offer";
//**VS**//$setting[ptsu]//**VE**//
//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

$sql=$Db1->query("SELECT * FROM ptsuads WHERE id='$id'");
$ad=$Db1->fetch_array($sql);


$sql=$Db1->query("SELECT * FROM ptsu_history WHERE username='$username'");
if($Db1->num_rows() == 0) {
	$sql=$Db1->query("INSERT INTO ptsu_history SET username='$username'");
}
$preclicked=$Db1->fetch_array($sql);
if($preclicked[clicks] == "") {
	$preclicked[clicks]=":";
}

if(findclick($preclicked[clicks], $id) == 1) {
	$includes[content]= "
	Thank you for completing this offer!<br /><br />
	
	<a href=\"index.php?view=account&ac=ptsu&".$url_variables."\">Go Back To Paid To Signup Area</a>
	
	";
}

else if($ad[credits] > 0) {
	
	if($action == "verify") {
		$sql=$Db1->query("SELECT * FROM ptsu_log WHERE username='$username' and ptsu_id='$id'");
		if($Db1->num_rows() > 0) {
			$msg="You have already submitted a completion verification for this offer!";
			$Db1->query("UPDATE ptsu_history SET clicks='".$preclicked[clicks].$id.":' WHERE username='$username'");
		} else {
			if(($verify_userid != "") && ($verify_email != "")) {
				$verify_userid=addslashes(stripslashes($verify_userid));
				$verify_email=addslashes(stripslashes($verify_email));
				$Db1->query("INSERT INTO ptsu_log SET
					username='$username',
					ptsu_id='$ad[id]',
					status='".$settings["ptsu_mode"]."',
					dsub='".time()."',
					pamount='$ad[pamount]',
					class='$ad[class]',
					welcome_email='$verify_email',
					userid='$verify_userid'
				");
				$Db1->query("UPDATE ptsuads SET credits=credits-1, pending=pending+1 WHERE id='$id'");
				
				$Db1->query("UPDATE ptsu_history SET clicks='".$preclicked[clicks].$id.":' WHERE username='$username'");
				$Db1->sql_close();
				header("Location: index.php?view=account&ac=do_ptsu&id=$id&".$url_variables."");
				exit;
			}
			else {
				$msg="You must completely fill out the completion verification form!";
			}
		}
	}
	
	
	$includes[content]="
	<table width=\"100%\">
		<tr>
			<td>
				<b>Title: </b> ".ucwords(strtolower(stripslashes($ad[title])))."<br />
				<b>Incentive: </b> ".iif($ad['class']=="P","$ad[pamount] Points","$cursym ".number_format($ad[pamount],2))."<br />
			</td>
			<td align=\"center\">
				<a href=\"$ad[target]\" target=\"_blank\" style=\"font-size: 20px; border: 1px solid black; padding: 4 8 4 8px;\">Complete Offer</a>
			</td>
		</tr>
		<tr>
			<td colspan=2>
				$ad[ad]
			</td>
		</tr>
	</table>
	
	<hr>
	
	".iif($msg!="","<font color=\"red\">$msg</font>")."
 <h1><font color=\"red\">Description:</font><br><br>
    <hr>
    $ad[subtitle]
    <hr></h1><br><br>
	<form action=\"index.php?view=account&ac=do_ptsu&action=verify&id=$id&".$url_variables."\" method=\"post\">
	<b>Verify Completion Of Offer</b><br />
	Username or UserID used for signup: <input type=\"text\" name=\"verify_userid\"><br />
	Welcome or Signup Verification Email: <br />
	<textarea cols=40 rows=7 name=\"verify_email\"></textarea><br />
	<input type=\"submit\" value=\"Verify Completion\">
	</form>
	
	<hr>
	
	<br />
	<b>Rules</b><br />
	<li>You must activate your account when joining the program listed
	<li>You must copy and paste your welcome email in the form above
	<li>Please remove your password from the email pasted.
	<li>If you purposely enter false welcome emails, your account will be suspended.
	<li>If you do not enter a welcome email, your signup will be denied without question.
	<li>You cannot signup for multiple offers of the same program.


	<br /><br />
	<b>How To Complete An Offer</b><br />
	
	<li>Click on the \"complete offer\" button; you will be taken to the advertiser's website.<br />
	<li>Do necessary steps to join the website or program you are taken to.<br />
	<li>Fill out the form above by pasting your <i>Welcome Email</i>.<br />
	<li>Click the \"Verify Completion\" button to submit your signup details.<br />
	<li>Your signup will then be manually verified before you are credited.

	
	";
}
else {
	$includes[content]="This offer is no longer available! : $ad[credits]";
}
//**E**//
?>