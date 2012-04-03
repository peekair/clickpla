<?
requireAdmin();

/*
0	waiting approval
1	approved by admin
2	waiting approval by advertiser
3	denied by admin
4	denied by advertiser
*/

$sql=$Db1->query("SELECT COUNT(id) as total FROM ptsu_log WHERE status='".iif($status==1,"0","2")."' ");
$temp=$Db1->fetch_array($sql);
$num=$temp[total];

$sql=$Db1->query("SELECT ptsu_log.*, ptsuads.title, ptsuads.target FROM ptsu_log, ptsuads WHERE ptsu_log.status='".iif($status==1,"0","2")."' and ptsuads.id=ptsu_log.ptsu_id ORDER BY ptsu_log.username, ptsuads.target LIMIT 50");
$total=$Db1->num_rows();
for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
	$list.="
		<div class=\"borderBox\" id=\"approve_signup_main".$temp[id]."\">
			<div style=\"float: right;\">$temp[username]</div>
			<a href=\"\" onclick=\"approve_signups_sm('approve_signup".$temp[id]."'); return false;\">$temp[title]</a>
			<div style=\"display: none;\" id=\"approve_signup".$temp[id]."\">
				<div style=\"float: right;\">
					<a href=\"\" onclick=\"approve_signup($temp[id],1); return false;\"><b>Approve</b></a> &nbsp;&nbsp;&nbsp;
					<a href=\"\" onclick=\"approve_signup($temp[id],3); return false;\"><b>Deny</b></a>
				</div>
				<div>
						<a href=\"$temp[target]\" target=\"_blank\">$temp[target]</a>
				</div>
				<div style=\"float: right;\">
					<a href=\"\" onclick=\"approve_signup($temp[id],2); return false;\">Require Advertiser Approval</a> 
				</div>
				<div style=\"clear: both; height: 150px; overflow: auto; border: 1px solid #c8c8c8; background-color: white; text-align: left; padding: 5 5 5 5px\">
					<b>Userid Used: </b> $temp[userid]<br />
					".nl2br($temp[welcome_email])."
				</div>
			</div>
		</div>
	";
}


if ($total > 0) echo "Total: $num<br /><br />$list";
else echo "<div align=\"center\" style=\"padding: 0 0 4 0px;\">There are no signups waiting approval.</div>";
?>



<script>
approve_load_done(<? echo $status; ?>);
</script>