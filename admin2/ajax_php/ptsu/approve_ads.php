<?
requireAdmin();



$sql=$Db1->query("SELECT * FROM ptsuads WHERE active=0 ORDER BY credits DESC");
$total=$Db1->num_rows();
for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
	$list.="
		<div class=\"borderBox\" id=\"approve_ad_main".$temp[id]."\">
			<div style=\"float: right;\">
				<a href=\"#\" onclick=\"approve_ad($temp[id],1)\">Approve</a> &nbsp;&nbsp;&nbsp;
				<a href=\"#\" onclick=\"approve_ad($temp[id],0)\">Deny</a>
			</div>
			
			<span style=\"padding-right: 10px;\">$temp[credits]</span>
			<a href=\"#\" onclick=\"approve_ads_sm('approve_ad".$temp[id]."')\">$temp[title]</a>
			<div style=\"display: none;\" id=\"approve_ad".$temp[id]."\">
				Username: $temp[username]<br />
				Url: <a href=\"$temp[target]\" target=\"_blank\" onclick=\"document.getElementById('approve_ad_main".$temp[id]."').className='borderBoxSelected';\">$temp[target]</a>
			</div>
		</div>
	";
}


if ($total > 0) echo "$list";
else echo "<div align=\"center\" style=\"padding: 0 0 4 0px;\">There are no ads waiting approval.</div>";
?>



<script>
approve_load_done();
</script>