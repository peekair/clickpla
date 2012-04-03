<?
if(!IN_CLICKING) exit;

$referringurl=parse_url($HTTP_REFERER);
$selfurl=parse_url($_SERVER['PHP_SELF']);
if (!($referringurl['path'] == $selfurl['path'] && $referringurl['host'] == $_SERVER['HTTP_HOST'])) error("There was an error validating your session");

function failed_cheat() {
	global $Db1, $username, $id, $url_variables, $type;
	$Db1->query("DELETE FROM cheat_session WHERE username='".$username."'");
	
	$sql=$Db1->query("SELECT * FROM cheat_failed WHERE username='$username'");
	if($Db1->num_rows() == 0) {
		$sql=$Db1->query("INSERT INTO cheat_failed SET username='$username', failed=1, last_failed='".time()."', failed_today=1");
	} else {
		$sql=$Db1->query("UPDATE cheat_failed SET failed=failed+1, last_failed='".time()."', failed_today=failed_today+1 WHERE username='$username'");
	}
	$Db1->sql_close();
	echo "<script>
	parent.location.href='gpt.php?v=entry&id={$id}&{$url_variables}';
	</script>";
	exit;
}


$sql=$Db1->query("SELECT * FROM cheat_session WHERE username='$username'");

if($Db1->num_rows() > 0) {
	$temp=$Db1->fetch_array($sql);
	$where="WHERE id='$temp[trivia]'";
	$Db1->query("UPDATE cheat_session SET loads=loads+1 WHERE username='$username'");
	
	if($temp[loads] >= $settings[cheat_loads]) {
		failed_cheat();
	}
}
else {
	$where="ORDER BY RAND() LIMIT 1";
	$new=1;
}

$sql=$Db1->query("SELECT * FROM cheat_questions $where");
$ques = $Db1->fetch_array($sql);




if(($action == "check")) {
//	echo "blah"; exit;
	if($new == 1) {
		$Db1->sql_close();
			echo "<script>
			parent.location.href='gpt.php?v=entry&id={$id}&{$url_variables}';
			</script>";
		exit;
	}
	if($ques[aid] != 0) {
		if(($new != 1) && ($ques[aid] == $q_answer)) {
			$sql=$Db1->query("DELETE FROM cheat_session WHERE username='".$username."'");
			$Db1->query("UPDATE user SET cheat_check=0, last_cheat='".time()."' WHERE username='$username'");
			$Db1->sql_close();
			echo "<script>
			parent.location.href='gpt.php?v=entry&id={$id}&{$url_variables}';
			</script>";
			exit;
		}
		else {
			failed_cheat();
		}
	}
	else {
		$Db1->sql_close();
			echo "<script>
			parent.location.href='gpt.php?v=entry&id={$id}&{$url_variables}';
			</script>";
		exit;
	}
}

if($new == 1) {
	$sql=$Db1->query("INSERT INTO cheat_session SET username='".$username."', trivia='$ques[id]'");
	$Db1->query("UPDATE user SET cheat_checks=cheat_checks+1 WHERE username='$username'");
}


$sql=$Db1->query("SELECT * FROM cheat_answers WHERE qid = '$ques[id]' ORDER BY RAND()");
while ($temp = $Db1->fetch_array($sql)) {
       $answers .= "<tt><input type=\"radio\" name=\"q_answer\" value='$temp[id]'> $temp[answer]<br />";
}

$display .= "
<html>
<head>
<title>Cheat Check</title>
</head>
<body>

<form method=\"POST\" action=\"gpt.php?v=cheat&id={$id}&pretime={$pretime}&action=check&qid={$ques[id]}&{$url_variables}\">

<div style=\"text-align: center; padding: 20 0 0 0px;\">
<div align=\"center\">
<table width=\"538\" height=\"322\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=538 height=131>
			<table cellpadding=0 cellspacing=0 width=538 height=131>
				<tr>
					<td rowspan=\"2\"><img src=\"images/cheat-check_01.gif\" width=\"132\" height=\"131\" alt=\"\"></td>
					<td width=\"406\" height=\"44\"></td>
				</tr>
				<tr>
					<td><img src=\"images/cheat-check_03.gif\" width=\"406\" height=\"87\" alt=\"\"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width=538 height=191>
			<table cellpadding=0 cellspacing=0 width=538 height=191>
				<tr>
					<td><img src=\"images/cheat-check_04.gif\" width=\"40\" height=\"191\" alt=\"\"></td>
					<td><img src=\"images/cheat-check_05.gif\" width=\"23\" height=\"191\" alt=\"\"></td>
					<td background=\"images/cheat-check_06.gif\" width=\"432\" height=\"191\" valign=\"top\">
					<tt>
This cheat check feature is to help keep our program at its highest quality for members! Please select the correct answer to the question below to continue!</tt>

<hr>



<table cellpadding=0 cellspacing=0 width=420>
	<tr>
		<td colspan=2><b style=\"color: darkred\">$ques[question]</b></td>
	</tr>
	<tr>
		<td valign=\"top\">$answers</td>
		<td align=right><input type=\"submit\" name=\"submit\" value=\"Answer\"></td>
	</tr>
</table>

					</td>
					<td><img src=\"images/cheat-check_07.gif\" width=\"43\" height=\"191\" alt=\"\"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
</div>
</form>

</html>


";





echo $display;


?>

