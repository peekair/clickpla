<?
requireAdmin();
global $url_variables;

$id = mysql_real_escape_string($_REQUEST['id']);
$p = $_REQUEST;
$error=false;

if($_REQUEST['save'] == 1) {
	if($p['uUsername'] == "") $error="Username cannot be blank!";
	if($p['uEmail'] == "") $error="Invalid email address!";
	
	if($error == false) {
		$sql=$Db1->query("UPDATE user SET
			username='{$p['uUsername']}',
			name='{$p['uName']}',
			refered='{$p['uRefered']}',
			referrals1='{$p['uReferrals1']}',
			referrals2='{$p['uReferrals2']}',
			referrals3='{$p['uReferrals3']}',
			referrals4='{$p['uReferrals4']}',
			referrals5='{$p['uReferrals5']}',
			permission='{$p['uPermission']}',
			popup_credits='{$p['uPopupCredits']}',
			suspended='{$p['uSuspended']}',
			balance='{$p['uBalance']}',
			ptsu_credits='{$p['uPtsuCredits']}',
			email='{$p['uEmail']}',
			tickets='{$p['uTickets']}',
			`group`='{$p['uGroup']}',
			referral_earns='{$p['uReferralEarns']}',
			points='{$p['uPoints']}',
			link_credits='{$p['uLinkCredits']}',
			fad_credits='{$p['uFadCredits']}',
			banner_credits='{$p['uBannerCredits']}',
			fbanner_credits='{$p['uFbannerCredits']}',
			ptr_credits='{$p['uPtrCredits']}',
			ptra_credits='{$p['uPtraCredits']}',
			optin='{$p['uOptin']}',
			suspendTime='".(($p['uSuspendTime']==-1)?"-1":( ($p['uSuspendTime']*24*60*60) +time()) )."',
			suspendMsg='".htmlentities($p['uSuspendMsg'])."',
			notes='{$p['uNotes']}',
			verified='{$p['uVerified']}',
			xcredits='{$p['uXCredits']}'
		
			WHERE userid='{$id}'
		");
		echo "<div class=\"success\">Your changes have been saved!</div>";
	}
	else {
		echo "<div class=\"error\"><strong>Error:</strong> {$error}</div>";
	}
}




?>