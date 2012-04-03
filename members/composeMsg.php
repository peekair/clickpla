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
$includes[title]="Compose Message";

if($action == "send") {
	$sql=$Db1->query("SELECT * FROM user WHERE username='".addslashes($to)."'");
	if($Db1->num_rows() > 0 && $to != "") {
		if($message == "") $error="<h3>Please Enter A Message!</h3>";
		else if($subject == "") $error="<h3>Please Enter A Subject!</h3>";
		else {
			$theUser = $Db1->fetch_array($sql);
			$Db1->query("INSERT INTO messages SET
				username='".addslashes($to)."',
				`from`='".$username."',
				dsub='".time()."',
				title='".addslashes($subject)."',
				message='".addslashes($message)."'
			");
			if($settings["imMailAlert"] == 1 && $theUser['suspended'] == 0) {
				send_mail($theUser['email'], $theUser['name'], "New private message at ".$settings['site_title'],

					"You have received a new private message from ".$username." at ".$settings['site_title']."\n\n".
						$settings[base_url]."/index.php?view=account&ac=messages"

				);

			}
			$Db1->sql_close();
			header("Location: index.php?view=account&ac=messages&".$url_variables."");
			exit;
		}
	}
	else {
		$error="<h3>The username you entered could not be found!</h3>";
	}
}

if($reply != "") {
	$sql=$Db1->query("SELECT * FROM messages WHERE username='$username' and id='$reply'");
	$temp = $Db1->fetch_array($sql);
	$to=$temp[from];
	$subject="Re: ".stripslashes(htmlentities($temp[title]));
	$message="\n\n\n--------- Original Message ----------\n".stripslashes($temp[message]);
}


	$includes[content]="

	<div style=\"text-align: right;\">
		<a href=\"index.php?view=account&ac=messages&".$url_variables."\">Return To Inbox</a>
	</div>

$error

<form action=\"index.php?view=account&ac=composeMsg&action=send&".$url_variables."\" method=\"post\">
	<table class=\"tableStyle composeMsg\">
		<tr>
			<th class=\"main\" colspan=2>Compose New Message</th>
		</tr>
		<tr>
			<th>Recipient: </th>
			<td><input type=\"text\" name=\"to\" value=\"$to\" style=\"width: 100%;\"></td>
		</tr>
		<tr>
			<th class=\"rowHead\">Subject</th>
			<td><input type=\"text\" name=\"subject\" value=\"$subject\" style=\"width: 100%;\"></td>
		</tr>
		<tr>
			<td colspan=2><textarea name=\"message\" style=\"width: 100%; height: 200px\">$message</textarea></td>
		</tr>
		<tr>
			<td colspan=2 class=\"submit\"><input type=\"submit\" value=\"Send Message\"></td>
		</tr>
	</table>
</form>

	";




?>