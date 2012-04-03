<?

$includes[content]="

<b>Membership Type</b>: ".iif($thismemberinfo[type]==1,$thetype,"Basic")."<br />
".iif($thismemberinfo[type]!=0,"Ends In  ".floor(($thismemberinfo[pend]-time())/24/60/60)." Days<br />")."
<b>Surf Credits</b>: $thismemberinfo[surf_credits]<br />
<b>Sites Surfed</b>: $thismemberinfo[surf_clicks]<br />
<b>Direct Referrals</b>: $thismemberinfo[referrals1]<br />
<br />

<a href=\"index.php?view=account&ac=downline&".$url_variables."\">Click here to view your downline stats</a><br />
<a href=\"index.php?view=account&ac=myads&adtype=surf_sites&".$url_variables."\">Click here to manage your website(s)</a>

";
?>