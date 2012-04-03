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
$includes[title]="Message Center";

$newmsgs=0;

$sql=$Db1->query("SELECT * FROM messages WHERE `from`='".$username."' ORDER BY dsub DESC");
$total = $Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	if($temp[read] == 0) $newmsgs++;

//				<td style=\"width: 10px;\"><input type=\"checkbox\" name=\"\" value=\"\"></td>

	$mailList.="
		<tr ".iif($temp[read] == 0,"style=\"background-color: lightyellow !important;\"").">
			<td><a href=\"index.php?view=account&ac=readMsg&id=".$temp[id]."&".$url_variables."\">".stripslashes($temp[title])."</a> ".iif($temp[read] == 0,"<img src=\"images/icons/star.gif\" align=\"absmiddle\">")." </td>
			<td>".stripslashes($temp[username])."</td>
			<td>".date('m/d/y', mktime(0,0,$temp[dsub],1,1,1970))."</td>
		</tr>
	";
}

//						<td style=\"width: 10px;\"></td>


$includes[content]="

<div style=\"text-align: right; padding: 3px;\"><img src=\"images/icons/preferences.gif\" align=\"absmiddle\"/> <a href=\"index.php?view=account&ac=composeMsg&".$url_variables."\">Compose New</a> | <a href=\"index.php?view=account&ac=sentmessages&".$url_variables."\">Sent Messages</a></div>

			<div class=\"accountRightCont\">
				<div style=\" padding: 5px;\" id=\"dropBoxContMain\">
				
				<table width=\"100%\" class=\"tableStyle2\">
					<tr class=\"tableHeader\">
						<td>Title</td>
						<td>To</td>
						<td>Date</td>
					</tr>
					<tr>
						$mailList
					</tr>
				</table>
				
				</div>
			</div>


";

?>