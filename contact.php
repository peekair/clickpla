<?
$includes[title]="Contact Us";

if($_GET['action'] == "send") {
	
	$uName = $_POST['uName'];
	$uEmail = $_POST['uEmail'];
	$uSubject = $_POST['uSubject'];
	$uMsg = $_POST['uMsg'];
	
	if($uName == "") $error="Please enter your name";
	elseif($uEmail == "") $error="Please enter your email address";
	elseif($uSubject == "") $error="Please enter a message subject";
	elseif($uMsg == "") $error="Please enter a message";
	else {

		$body = "Username: {$username}\nIp Address: ".getenv("REMOTE_ADDR")."\nAgent: ".getenv("HTTP_USER_AGENT")."\n\n".stripslashes($_POST['uMsg'])."";
	    $suc = send_mail($settings[admin_email],$settings[admin_email],$_POST['uSubject'],$body,$_POST['uEmail'],$_POST['uName']);
	
	    if($suc == 0) $msg="There was an error sending your email!";
		else $msg="Your message has been sent!";
	}
}
elseif($LOGGED_IN == true) {
	$uName = $thismemberinfo['name'];
	$uEmail = $thismemberinfo['email'];
}


if($error) echo "<div class=\"error\">$error</div>";

if($msg) echo "<p>$msg</p>";
else {
?>

<form action="index.php?view=contact&action=send&amp;<?=$url_variables;?>" method="post" name="form">

<fieldset class="form contactForm">

	<h3>Personal Details</h3>
	<div><label for="uName">Your Name</label> <input type="text" name="uName" id="uName" value="<?=$uName;?>" /><br /><p>Please enter your full name.</p></div>
	<div><label for="uEmail">Your Email Address</label> <input type="text" name="uEmail" id="uEmail" value="<?=$uEmail;?>" /><br /><p>We will be replying to this email so be sure to enter a valid and current address.</p></div>

	<h3>Your Message</h3>
	<div><label for="uSubject">Subject</label> <input type="text" name="uSubject" id="uSubject" value="<?=$uSubject;?>" /><br /><p>Please enter a short subject about your enquiry.</p></div>
	<div><label for="uMsg">Your Message</label><br/><p>Please enter your message below with specific details of your enquiry.</p> <textarea name="uMsg" id="uMsg" cols="20" rows="10" /><?=$uMsg;?></textarea><br /></div>
	
	
	<div class="submit"><input type="submit" value="Contact Us" /></div>
	
</fieldset>
</form>

<? } ?>