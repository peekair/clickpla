<?
$includes[title]="Polls";

if($id != "") {
	$sql=$Db1->query("SELECT * FROM polls_polls WHERE id='$id'");
	$poll=$Db1->fetch_array($sql);
}

function hasVoted($id, $username) {
	global $Db1;
	$sql=$Db1->query("SELECT * FROM polls_history WHERE username='$username' and poll='$id'");
	if($Db1->num_rows() == 0) return false;
	else return true;
}

if($action == "vote") {
	if(($poll[status] == 1) && (hasVoted($id, $username) == false)) {
		
	
		$Db1->query("UPDATE polls_options SET votes=votes+1 WHERE id='".addslashes($myVote)."'");
		$Db1->query("INSERT INTO polls_history SET username='$username', poll='".addslashes($id)."'");
	}
	
	$Db1->sql_close();
	header("Location: index.php?view=polls&action=view&id=$id&".$url_variables."");
	exit;
}


/*
	0=hidden
	1=public - open
	2=public - closed
	3=hidden - closed 
*/

if($action == "view") {
	$totalVotes=0;
		
	if(($poll[status] == 1) && (hasVoted($id, $username) == false)) $isvote=true;
	
	$sql=$Db1->query("SELECT * FROM polls_options WHERE poll='$id'");
	for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
		$options[$x]=$temp;
		$totalVotes+=$temp[votes];
	}
	
	$width=200;
	
	for($x=0; $x<count($options); $x++) {
		$list.="
		<tr>
			<td>
				".iif($isvote==true,"<input type=\"radio\" name=\"myVote\" value=\"".$options[$x][id]."\">")."
				".$options[$x][title]."</td>
			<td style=\"width: 20px; text-align: center;\">".$options[$x][votes]."</td>
			<td style=\"width: 210px\"><div style=\"width: ".(round(@($options[$x][votes]/$totalVotes)*$width)+5)."px; height: 10px; background-color: blue;\"></div></td>
		</tr>
		";
	}
	
	$includes[content]="
	<form action=\"index.php?view=polls&action=vote&id=$id&".$url_variables."\" method=\"post\">
	<div style=\"float: right;\"><a href=\"index.php?view=polls&".$url_variables."\">Back To Polls</a></div>
	<h3>$poll[title]</h3>
	<table class=\"tableStyle3\">
		$list
	</table>
	
	".iif($isvote==true,"<input type=\"submit\" value=\"Submit Your Vote\">")."
	
	</form>
	
	";
	
}
else {
	$sql=$Db1->query("SELECT * FROM polls_polls WHERE status='1' or status='2' ORDER BY dsub, status");
	while($temp = $Db1->fetch_array($sql)) {
		$t="<li><a href=\"index.php?view=polls&action=view&id=".$temp[id]."&".$url_variables."\">".stripslashes($temp[title])."</a></li>";
		if($temp[status] == 1) $list.=$t;
		else $clist.=$t;
	}
	if($list == "") $list="<i>There are no open polls</i>";
	if($clist == "") $clist="<i>There are no closed polls</i>";
	$includes[content]="
	<strong>Current Public Polls</strong>
	<menu>
		$list
	</menu>
	<strong>Closed Polls</strong>
	<menu>
		$clist
	</menu>
	";
}

?>