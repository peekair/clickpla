<?
requireAdmin();

/*
0	waiting approval
1	approved by admin
2	waiting approval by advertiser
3	denied by admin
4	denied by advertiser
*/


function determineDomain($url) {
	$tmp = parse_url($url);
	$tmp2 = strtolower(str_replace("www.","",$tmp[host]));
	if($tmp2 == " http") {
		$url = trim($url);
		$tmp = parse_url($url);
		$tmp2 = str_replace("www.","",$tmp[host]);
	}
	return $tmp2;
}

$sql=$Db1->query("SELECT ptsu_log.id, ptsuads.target FROM ptsu_log, ptsuads WHERE ptsu_log.domain='' and ptsuads.id=ptsu_log.ptsu_id");
while($temp = $Db1->fetch_array($sql)) {
	$Db1->query("UPDATE ptsu_log SET domain='".determineDomain($temp[target])."' WHERE id='".$temp[id]."'");
}


if($status == 2) { include("pending_adv_signups.php"); }
else {

	$sql=$Db1->query("SELECT COUNT(id) as total FROM ptsu_log WHERE status='".iif($status==1,"0","2")."'");
	$temp=$Db1->fetch_array($sql);
	$num=$temp[total];

	$sql=$Db1->query("SELECT username FROM ptsu_log WHERE status='0' LIMIT 1");
	$temp=$Db1->fetch_array($sql);
	$firstUser=$temp[username];

	$sql=$Db1->query("SELECT domain FROM ptsu_log WHERE status!='0' and username='$firstUser'");
	while($temp = $Db1->fetch_array($sql)) {
		$doneSignups[$temp[domain]]=true;
	}
	
	$sql=$Db1->query("SELECT * FROM ptsu_log WHERE status='0' and username='$firstUser' ORDER BY domain");
	$total=$Db1->num_rows();
	for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
	
		$sql2=$Db1->query("SELECT title, target FROM ptsuads WHERE id='".$temp[ptsu_id]."'");
		$temp2=$Db1->fetch_array($sql2);
		
		if($temp2[target] == "") {
			$temp2[target] = "(offer deleted)";
		}
		
		
		$temp[target] = $temp2[target];
		
		$tmp2=determineDomain($temp2[target]);

		$list.="

			<div class=\"borderBox\" id=\"approve_signup_main".$temp[id]."\">
				<div style=\"float: right;\">
						<a href=\"\" onclick=\"approve_signup($temp[id],1); return false;\"><b>Approve</b></a> &nbsp;&nbsp;&nbsp;
						<a href=\"\" onclick=\"approve_signup($temp[id],3); return false;\"><b>Deny</b></a> &nbsp;&nbsp;&nbsp;
						<input type=\"checkbox\" value=\"1\" id=\"checkBox".$x."\" rel=\"".$temp[id]."\">
						
					</div>
				<a href=\"\" onclick=\"approve_signups_sm('approve_signup".$temp[id]."'); return false;\">
					".iif($tmp2=="","+$temp2[target]",ucwords($tmp2))."
					".iif($doneSignups[$temp[domain]]==true && $temp[domain]!=""," - <b style=\"color: red\">Multiple Domain Signup Detected!</b>")."
				</a>
				<div style=\"display: none;\" id=\"approve_signup".$temp[id]."\">
	
					<div>
							".iif($temp[target]!="","<a href=\"$temp[target]\" target=\"_blank\">$temp[target]</a>")."
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
	
	
	if ($total > 0) 
	echo "
		<div class=\"floatLeft\">Total Signups: $num</div>
		<div class=\"floatLeft\">Current User: <a href=\"index.php?view=admin&ac=edit_user&uname=$firstUser&".$url_variables."\">$firstUser</a></div>
		<div class=\"floatLeft\">User Signups: $total</div>
		<div style=\"float: right; padding: 0 7 0 0px;\"><input type=\"checkbox\" value=\"1\" onclick=\"toggleBoxes(this, $total)\"></div>
		
		<div style=\"clear: both; padding-top: 5px;\">$list</div>
		
		
		<div style=\"text-align: right; padding: 5px;\">
			<input type=\"button\" id=\"doButton1\" value=\"Approve Selected\" onclick=\"mass_approve_signup(1)\" style=\"color: green; font-weight: bold;\"><br /><br />
			<input type=\"button\" id=\"doButton2\" value=\"Require Advertiser Approval\" onclick=\"mass_approve_signup(2)\"><br />
			<input type=\"button\" id=\"doButton3\" value=\"Deny Selected\" onclick=\"if(confirm('Are you sure - DENY Selected?')) mass_approve_signup(3)\" style=\"color: red; font-weight: bold;\">
		</div>
		
		
		";
	else echo "<div align=\"center\" style=\"padding: 0 0 4 0px;\">There are no signups waiting approval.</div>";
}

?>

<style>
.floatLeft {
	float: left;
	padding: 2 10px;
}
</style>


<script>
signupsLeft=<?=$total; ?>;
approve_load_done(<? echo $status; ?>);
</script>