<?
include("ajax_php/memberManager/header.php");


if($user['last_click'] == "") $user['last_click']=0;
if($user['last_act'] == "") $user['last_act']=0;
if($user['joined'] == "") $user['joined']=0;

$sql=$Db1->query("SELECT * FROM member_groups ORDER BY title");
while(($temp=$Db1->fetch_array($sql))) {
	$grouplist.="<option value=\"$temp[id]\" ".iif($user[group] == $temp[id], "selected=\"selected\"").">$temp[title]";
}


?>

<div id="vm_edit_status"></div>

<form action="#" method="post" onsubmit="mm.edit_save(); return false;" id="vm_edit_form">

<fieldset class="form">

	<h3>Personal Information</h3>
	<div><label for="uUsername">Username</label> <input type="text" name="uUsername" id="uUsername" value="<?=$user['username'];?>" /></div>
	<div><label for="uName">Name</label> <input type="text" name="uName" id="uName" value="<?=$user['name'];?>" /></div>
	<div><label for="uEmail">Email Address</label> <input type="text" name="uEmail" id="uEmail" value="<?=$user['email'];?>" /></div>

	
	<h3>Account Settings</h3>
	<div><label for="uVerified">Email Verified</label>
		<select name="uVerified" id="uVerified">
			<option value="0" <? if($user['verified'] == 0) echo "selected=\"selected\""; ?>>No</option>
			<option value="1" <? if($user['verified'] == 1) echo "selected=\"selected\""; ?>>Yes</option>
		</select></div>
	
	<? if(SETTING_PTR == true) { ?>
		<div><label for="uOptin">Receive PTR Emails</label>
		<select name="uOptin" id="uOptin">
			<option value="0" <? if($user['optin'] == 0) echo "selected=\"selected\""; ?>>No</option>
			<option value="1" <? if($user['optin'] == 1) echo "selected=\"selected\""; ?>>Yes</option>
		</select></div>
	<? } ?>
		
	<div><label for="uSuspended">Suspended</label>
		<select name="uSuspended" id="uSuspended">
			<option value="0" <? if($user['suspended'] == 0) echo "selected=\"selected\""; ?>>No</option>
			<option value="1" <? if($user['suspended'] == 1) echo "selected=\"selected\""; ?>>Yes</option>
		</select></div>
		


	<div><label for="uSuspendTime">Suspend Time</label> <input type="text" name="uSuspendTime" id="uSuspendTime" value="<? if($user['suspendTime']==-1) echo "-1"; elseif($user['suspendTime']=="") echo (($user['suspendTime']-time())/60/60/24);?>" /><br/><p>How many days to suspend? (-1 forever)</p></div>
	<div><label for="uSuspendMsg">Suspend Reason</label> <input type="text" name="uSuspendMsg" id="uSuspendMsg" value="<?=$user['suspendMsg'];?>" /></div>

		
	<div><label for="uPermission">Permission Level</label>
		<select name="uPermission" id="uPermission">
			<option value="0" <? if($user['permission'] == 0) echo "selected=\"selected\""; ?>>Member</option>
			<option value="7" <? if($user['permission'] == 7) echo "selected=\"selected\""; ?>>Admin</option>
		</select></div>

	<div><label for="uGroup">Group</label>
		<select name="uGroup" id="uGroup">
			<option value=""></option>
			<?=$grouplist;?>
		</select></div>

	
	<h3>Account Balances</h3>
	<div><label for="uBalance">Balance</label> <input type="text" value="<?=$user['balance'];?>" name="uBalance" id="uBalance" /></div>
	<div><label for="uPoints">Points</label> <input type="text" value="<?=$user['points'];?>" name="uPoints" id="uPoints" /></div>

	<? if(SETTING_PTC==true) { ?>
		<div><label for="uLinkCredits">Link Credits:</label> <input type="text" value="<?=$user['link_credits'];?>" name="uLinkCredits" id="uLinkCredits" /></div>
	<? } ?>
	
	<? if(SETTING_PTSU==true) { ?>
		<div><label for="uPtsuCredits">PTSU Credits:</label> <input type="text" value="<?=$user['ptsu_credits'];?>" name="uPtsuCredits" id="uPtsuCredits" /></div>
	<? } ?>
	
	<? if(SETTING_PTR==true) { ?>
		<div><label for="uPtrCredits">Email Credits:</label> <input type="text" value="<?=$user['ptr_credits'];?>" name="uPtrCredits" id="uPtrCredits" /></div>
	<? } ?>
	
	<? if(SETTING_PTRA==true) { ?>
		<div><label for="uPtraCredits">PTR Credits:</label> <input type="text" value="<?=$user['ptra_credits'];?>" name="uPtraCredits" id="uPtraCredits" /></div>
	<? } ?>
	
	<? if(SETTING_PTP==true) { ?>
		<div><label for="uPopupCredits">Popup Credits:</label> <input type="text" value="<?=$user['popup_credits'];?>" name="uPopupCredits" id="uPopupCredits" /></div>
	<? } ?>
	
	<? if(SETTING_CE==true) { ?>
		<div><label for="uXCredits">X-Credits:</label> <input type="text" value="<?=$user['xcredits'];?>" name="uXCredits" id="uXCredits" /></div>
	<? } ?>
	<div><label for="uBannerCredits">Banner Credits:</label> <input type="text" value="<?=$user['banner_credits'];?>" name="uBannerCredits" id="uBannerCredits" /></div>
	<div><label for="uFbannerCredits">Featured Banner Credits:</label> <input type="text" value="<?=$user['fbanner_credits'];?>" name="uFbannerCredits" id="uFbannerCredits" /></div>
	<div><label for="uFadCredits">F.Ad Credits:</label> <input type="text" value="<?=$user['fad_credits'];?>" name="uFadCredits" id="uFadCredits" /></div>
	<div><label for="uTickets">Tickets:</label> <input type="text" value="<?=$user['tickets'];?>" name="uTickets" id="uTickets" /></div>

	<h3>Downline Information</h3>
	<div><label for="uRefered">Referrer:</label> <input type="text" value="<?=$user['refered'];?>" name="uRefered" id="uRefered" /></div>
	<div><label for="uReferralEarns">Ref Earns:</label> <input type="text" value="<?=$user['referral_earns'];?>" name="uReferralEarns" id="uReferralEarns" /></div>
	<div><label for="uReferrals1">Level 1 Referrals:</label> <input type="text" value="<?=$user['referrals1'];?>" name="uReferrals1" id="uReferrals1" /></div>
	<div><label for="uReferrals2">Level 2 Referrals:</label> <input type="text" value="<?=$user['referrals2'];?>" name="uReferrals2" id="uReferrals2" /></div>
	<div><label for="uReferrals3">Level 3 Referrals:</label> <input type="text" value="<?=$user['referrals3'];?>" name="uReferrals3" id="uReferrals3" /></div>
	<div><label for="uReferrals4">Level 4 Referrals:</label> <input type="text" value="<?=$user['referrals4'];?>" name="uReferrals4" id="uReferrals4" /></div>
	<div><label for="uReferrals5">Level 5 Referrals:</label> <input type="text" value="<?=$user['referrals5'];?>" name="uReferrals5" id="uReferrals5" /></div>

	<h3>Notes</h3>
	<textarea name="uNotes" rows=5 cols=37><?=$user['uNotes'];?></textarea>
			
	
	<div class="submit"><input type="submit" value="Save" /></div>
	
</fieldset>
</form>
				
				


