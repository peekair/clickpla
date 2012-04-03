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
$includes['title']="Mass Mailer Log";

if($_GET['action'] == "cancel") {
	$Db1->query("UPDATE mailer_sessions SET status='2' WHERE id='{$_GET['id']}'");
	$Db1->query("DELETE FROM mailer_lists WHERE mail_id='{$_GET['id']}'");
	$Db1->sql_close();
	header("Location: admin.php?ac=mailer_manage&{$url_variables}");
	exit;
}

if($_GET['action'] == "clear") {
	$Db1->query("DELETE FROM mailer_sessions WHERE status!='0'");
	$Db1->sql_close();
	header("Location: admin.php?ac=mailer_manage&{$url_variables}");
	exit;
}
	
$sql = $Db1->query("SELECT * FROM mailer_sessions ORDER BY status, dsub DESC");
while(($row = $Db1->fetch_array($sql))) {
	$statuses=array("Sending","Complete","Cancelled");
	$list .="
	<tr>
		<td>{$row['subject']}</td>
		<td>".($statuses[$row['status']])."</td>
		<td>".date("M d, Y",mktime(0,0,$row['dsub'],1,1,1970))."</td>
		<td>{$row['total']}</td>
		<td>{$row['sent']}</td>
		<td>{$row['failed']}</td>
		<td>".($row['status']==0?"<a href=\"admin.php?ac=mailer_manage&action=cancel&id={$row['id']}&{$url_variables}\" onclick=\"return confirm('Are you sure?')\">Cancel</a>":"&nbsp;")."</td>
	</tr>
	";
}

$includes['content']="
<table class=\"tableData\">
	<tr>
		<th>Subject</th>
		<th>Status</th>
		<th>Created</th>
		<th>Total</th>
		<th>Sent</th>
		<th>Failed</th>
		<th>Cancel</th>
	</tr>
	{$list}
</table>

<p><a href=\"admin.php?ac=mailer_manage&action=clear&{$url_variables}\">Clear Logs</a></p>

";

?>