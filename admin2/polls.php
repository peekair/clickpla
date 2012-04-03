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
$includes[title]="Manage Polls";

/*
0=hidden
1=public - open
2=public - closed
3=hidden - closed 
*/

if($action == "newPoll") {
	$Db1->query("INSERT INTO polls_polls SET title='".addslashes($title)."', status='0', dsub='".time()."'");
	$Db1->sql_close();
	header("Location: admin.php?ac=polls&".$url_variables."");
	exit;
}

	$sql=$Db1->query("SELECT * FROM polls_polls ORDER BY dsub, status");
	while($temp = $Db1->fetch_array($sql)) {
		$list.="
			<tr>
				<td><a href=\"admin.php?ac=edit_poll&id=".$temp[id]."&".$url_variables."\">".stripslashes($temp[title])."</a></td>
				<td>
				".
				iif($temp[status] == 0,"Hidden").
				iif($temp[status] == 1,"Public (Open)").
				iif($temp[status] == 2,"Public (Closed)").
				"
				</td>
			</tr>";
	}
	$includes[content]="
<table class=\"tableStyle3\" style=\"width: 500px;\">
	<tr class=\"tableHead\">
		<td>Poll</td>
		<td style=\"width: 100px\">Status</td>
	</tr>
	$list
</table>

<hr>

<form action=\"admin.php?ac=polls&action=newPoll&".$url_variables."\" method=\"post\">
	<b>New Poll: </b> <input type=\"text\" name=\"title\" size=40>
	<input type=\"submit\" value=\"Create\">
</form>


	";



?>