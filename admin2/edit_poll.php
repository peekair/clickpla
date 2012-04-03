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
$includes[title]="Edit Poll";

	$sql=$Db1->query("SELECT * FROM polls_polls WHERE id='$id'");
	$poll=$Db1->fetch_array($sql);


if($action == "deleteOption") {
	$Db1->query("DELETE FROM polls_options WHERE id='$oid'");
}

if($action == "newOption") {
	$Db1->query("INSERT INTO polls_options SET title='".addslashes($title)."', poll='".$id."'");
	$Db1->sql_close();
	header("Location: admin.php?ac=edit_poll&id=$id&".$url_variables."");
	exit;
}

if($action == "reset") {
	$Db1->query("UPDATE polls_options SET votes='0'");
	$Db1->query("DELETE FROM polls_history WHERE poll='$id'");
	$Db1->sql_close();
	header("Location: admin.php?ac=edit_poll&id=$id&".$url_variables."");
	exit;
}


if($action == "editTitle") {
	$Db1->query("UPDATE polls_polls SET title='".addslashes($title)."' WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?ac=edit_poll&id=$id&".$url_variables."");
	exit;
}

if($action == "saveStatus") {
	$Db1->query("UPDATE polls_polls SET status='$status' WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?ac=edit_poll&id=$id&".$url_variables."");
	exit;
}


	$totalVotes=0;
	
	$sql=$Db1->query("SELECT * FROM polls_options WHERE poll='$id'");
	for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
		$options[$x]=$temp;
		$totalVotes+=$temp[votes];
	}
	
	$width=200;
	
	for($x=0; $x<count($options); $x++) {
		$list.="
		<tr>
			<td style=\"width: 50px;\"><a href=\"admin.php?ac=edit_poll&action=deleteOption&id=$id&oid=".$options[$x][id]."&".$url_variables."\" onclick=\"return confirm('Are you sure?')\">Delete</a></td>
			<td>
				".$options[$x][title]."</td>
			<td style=\"width: 20px; text-align: center;\">".$options[$x][votes]."</td>
			<td style=\"width: 210px\"><div style=\"width: ".(round(@($options[$x][votes]/$totalVotes)*$width)+5)."px; height: 10px; background-color: blue;\"></div></td>
		</tr>
		";
	}
	
	$includes[content]="
	<hr>
	
	<div style=\"float: right;\"><a href=\"admin.php?ac=polls&".$url_variables."\">Back To Polls</a></div>

	<form action=\"admin.php?ac=edit_poll&id=$id&action=editTitle&".$url_variables."\" method=\"post\">
	<b>Poll Title: </b> <input type=\"text\" name=\"title\" size=40 value=\"".htmlentities(stripslashes($poll[title]))."\">
	<input type=\"submit\" value=\"Save\">
	</form>
	
	<hr>
	<form action=\"index.php?view=polls&action=vote&id=$id&".$url_variables."\" method=\"post\">
	<table class=\"tableStyle3\">
		$list
	</table>
	</form>
	
	<hr>
	
	<form action=\"admin.php?ac=edit_poll&id=$id&action=newOption&".$url_variables."\" method=\"post\">
	<b>New Option: </b> <input type=\"text\" name=\"title\" size=40>
	<input type=\"submit\" value=\"Add\">
	</form>
	
	<hr>
	
	<form action=\"admin.php?ac=edit_poll&id=$id&action=saveStatus&".$url_variables."\" method=\"post\">
	<b>Poll Status: </b> 
	<select name=\"status\">
		<option value=\"0\" ".iif($poll[status] == 0,"selected=\"selected\"").">Hidden</option>
		<option value=\"1\" ".iif($poll[status] == 1,"selected=\"selected\"").">Public (Open)</option>
		<option value=\"2\" ".iif($poll[status] == 2,"selected=\"selected\"").">Public (Closed)</option>
	</select>
	<input type=\"submit\" value=\"Save\">
	</form>
	
	<hr>
	
	<a href=\"admin.php?ac=edit_poll&id=$id&action=reset&".$url_variables."\"  onclick=\"return confirm('Are you sure?')\">Reset Votes</a>
	
	<hr>
	
	";


?>