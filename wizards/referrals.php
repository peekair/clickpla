<?

$sql=$Db1->query("SELECT userid FROM user WHERE refered='' and username!='$username'");
$totalrefsavailable=$Db1->num_rows();

if($totalrefsavailable >= $amount) {
	$Db1->sql_close();
	header("Location: index.php?view=account&ac=buywizard&step=3".iif($samount, "&samount=$samount")."&pid=$order[order_id]&".$url_variables."");
}
else {
	$includes[title]="Purchase Referrals Error";
	$includes[content]="<div class=\"error\">There are not <b>$amount<b> referrals available to purchase right now.</div>";
}

?>