<?

$includes[title] = "Admin Message Center";

if ($action == "send") {
     if ($who == all) {

        $sql = $Db1->query("SELECT username FROM user");

        while ($temp = $Db1->fetch_array($sql)) {
              
            $to = $temp[username];
           
     //     if ($Db1->num_rows() > 0 && $to != "") {
                if ($message == "")
                    $error = "<h3>Please Enter A Message!</h3>";
                else
                    if ($subject == "")
                        $error = "<h3>Please Enter A Subject!</h3>";
                    else {


                 
	
                        echo ". ";
                        flush();
                        $Db1->query("INSERT INTO messages SET
				username='$to',
				`from`='Admin',
				dsub='" . time() . "',
				title='" . addslashes($subject) . "',
				message='" . addslashes($message) . "'
			");
           
                        if ($settings["imMailAlert"] == 1 && $theUser['suspended'] == 0) {
                            send_mail($temp['email'], $temp['name'], "New private message at " . $settings['site_title'],
                                "You have received a new private message from " . $username . " at " . $settings['site_title'] .
                                "\n\n" . $settings[base_url] . "/index.php?view=account&ac=messages");

                        }
                        $Db1->sql_close();
                    } 
        }
    }


    if ($who == premium) {

        $sql = $Db1->query("SELECT username FROM user WHERE type = '1'");

        while ($temp = $Db1->fetch_array($sql)) {
              
            $to = $temp[username];
           
     //     if ($Db1->num_rows() > 0 && $to != "") {
                if ($message == "")
                    $error = "<h3>Please Enter A Message!</h3>";
                else
                    if ($subject == "")
                        $error = "<h3>Please Enter A Subject!</h3>";
                    else {


                 
	
                        echo ". ";
                        flush();
                        $Db1->query("INSERT INTO messages SET
				username='$to',
				`from`='Admin',
				dsub='" . time() . "',
				title='" . addslashes($subject) . "',
				message='" . addslashes($message) . "'
			");
           
                        if ($settings["imMailAlert"] == 1 && $theUser['suspended'] == 0) {
                            send_mail($temp['email'], $temp['name'], "New private message at " . $settings['site_title'],
                                "You have received a new private message from " . $username . " at " . $settings['site_title'] .
                                "\n\n" . $settings[base_url] . "/index.php?view=account&ac=messages");

                        }
                        $Db1->sql_close();
                    } 
        }
    }
      if ($who == free) {

        $sql = $Db1->query("SELECT username FROM user WHERE type = '0'");

        while ($temp = $Db1->fetch_array($sql)) {
              
            $to = $temp[username];
           
     //     if ($Db1->num_rows() > 0 && $to != "") {
                if ($message == "")
                    $error = "<h3>Please Enter A Message!</h3>";
                else
                    if ($subject == "")
                        $error = "<h3>Please Enter A Subject!</h3>";
                    else {


                 
	
                        echo ". ";
                        flush();
                        $Db1->query("INSERT INTO messages SET
				username='$to',
				`from`='Admin',
				dsub='" . time() . "',
				title='" . addslashes($subject) . "',
				message='" . addslashes($message) . "'
			");
           
                        if ($settings["imMailAlert"] == 1 && $theUser['suspended'] == 0) {
                            send_mail($temp['email'], $temp['name'], "New private message at " . $settings['site_title'],
                                "You have received a new private message from " . $username . " at " . $settings['site_title'] .
                                "\n\n" . $settings[base_url] . "/index.php?view=account&ac=messages");

                        }
                        $Db1->sql_close();
                    } 
        }
    }
    print("All Done");
}
$includes[content] = "

	

$error

<form action=\"admin.php?view=admin&ac=adminmsg&action=send&" . $url_variables .
    "\" method=\"post\">
	<table class=\"tableStyle composeMsg\">
		<tr>
			<th class=\"main\" colspan=2>Compose New Message</th>
		</tr>
		<tr>
			<th>Send To: </th>
			<td><select name=\"who\"><option value=\"all\">All</option><option value=\"free\">Free Users</option><option value=\"premium\">Upgraded Users </option></select> 
</td>
		</tr>
		<tr>
			<th class=\"rowHead\">Subject</th>
			<td><input type=\"text\" name=\"subject\" value=\"$subject\" style=\"width: 200%;\"></td>
		</tr>
		<tr>
			<td colspan=2><textarea name=\"message\" style=\"width: 200%; height: 200px\">$message</textarea></td>
		</tr>
		<tr>
			<td colspan=2 class=\"submit\"><input type=\"submit\" value=\"Send Message\"></td>
		</tr>
	</table>
</form>


	";




?>