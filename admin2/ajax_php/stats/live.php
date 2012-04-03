<?
$sql=$Db1->query("SELECT COUNT(user.userid) AS total FROM user");
$temp=$Db1->fetch_array($sql);
$totalMembers= $temp[total];

$sql=$Db1->query("SELECT SUM(stats.hits) AS hits FROM stats");
$total_stats=$Db1->fetch_array($sql);

?>

Site Hits: <span style="color: #b10505;"><? echo number_format($total_stats[hits]); ?></span><br />
Members: <span style="color: #b10505;"><? echo number_format($totalMembers); ?></span>




<script>
	setLoader('liveStatsLoading', 0);
	setTimeout("updateStats()",2500);
</script>