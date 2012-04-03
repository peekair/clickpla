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
$includes[title]="Read Message";

$sql=$Db1->query("SELECT * FROM messages WHERE username='$username' and id='$id'");
if($Db1->num_rows() > 0) {
	$temp = $Db1->fetch_array($sql);
	
	$Db1->query("UPDATE messages SET `read`='1' WHERE id='$id'");
	
	$includes[content]="
	
	<div style=\"float: right;\">
		<a href=\"index.php?view=account&ac=messages&".$url_variables."\">Inbox</a> | 
		<a href=\"index.php?view=account&ac=composeMsg&reply=$id&".$url_variables."\">Reply</a> | 
		<a href=\"index.php?view=account&ac=deleteMsg&id=$id&".$url_variables."\" onclick=\"return confirm('Are you sure?')\">Delete</a>
	</div>
	
	<strong>From: </strong> $temp[from]<br />
	<strong>Date: </strong> ".date('m/d/y', mktime(0,0,$temp[dsub],1,1,1970))."
	
	
	<table class=\"tableStyle3\">
		<tr>
			<td class=\"tableHead\"><img src=\"images/icons/mail.gif\">".stripslashes($temp[title])."</td>
		</tr>
		<tr>
			<td>".nl2br(stripslashes($temp[message]))."</td>
		</tr>
	</table>
	
	
	";
	
}
else {
	$includes[content]="
	<b>Error!</b><br />
	There was an error loading the requested message!
	";
}


?>