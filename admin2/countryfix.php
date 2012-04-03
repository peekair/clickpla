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
$includes[title]="Country Fix Manager by MadeRite Scripts";




if($action == "fix_country") {
	for($y=0; $y<count($selected); $y++) {
		echo "<!-- Checking For Users -->\n";
		flush();
		$x=$selected[$y];
		$id=$selectedid[$x];
		$sql=$Db1->query("SELECT * FROM user WHERE userid='$id'");
		$temp=$Db1->fetch_array($sql);
		$sql=$Db1->query("SELECT * FROM user WHERE username='$temp[username]'");
		$user=$Db1->fetch_array($sql);
				
$vip=$temp['join_ip'];

	
$sql=  'SELECT 
	            c.country 
	        FROM 
	            ip2nationCountries c,
	            ip2nation i 
	        WHERE 
	            i.ip < INET_ATON("'.$vip.'") 
	            AND 
	            c.code = i.country 
	        ORDER BY 
	            i.ip DESC 
	        LIMIT 0,1';
		$temp1=mysql_query($sql);
		
		list($cadena) =mysql_fetch_row($temp1);
	// Output full country name
	

$pais="$cadena" ; 

		$Db1->query("UPDATE user SET country='".addslashes($pais)."'
		WHERE username='$temp[username]'");
	 	$msg.="Changing the country of User $temp[username]<br />";
	}
}

//**S**//
//SELECT DISTINCT country FROM user WHERE country!='' ORDER BY country"

if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=countryfix&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" user.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(userid) AS total FROM user WHERE country=''");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="user.userid";


if($orderby == "user.username") {$ordernum=1;}
if($orderby == "user.join_ip") {$ordernum=2;}
if($orderby == "user.name") {$ordernum=3;}
if($orderby == "user.email") {$ordernum=4;}



	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";
	
	

$sql=$Db1->query("SELECT * FROM user WHERE country = '' and ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 100");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_banner=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>	
				<td width=10>
			<input type=\"hidden\" name=\"selectedid[$x]\" value=\"".$this_banner['userid']."\">
			<input type=\"checkbox\" name=\"selected[]\" value=\"$x\" checked=\"checked\></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&id=".$this_banner[userid]."&s=$s&direct=members&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_banner[username] </a></td>
					<td>$this_banner[join_ip]</td>
					<td>$this_banner[name]</td>
					<td>$this_banner[email]</td>
					
				
					
	
					
						
					
				</tr>
";
	}
}
else {
	$userslisted="
			<tr>
				<td colspan=7 align=center class=\"tableHL2\">No Results!</td>
			</tr>
	";
}
	$includes[content].="
<div align=\"center\">


<form action=\"admin.php?view=admin&ac=countryfix&".$url_variables."\" method=\"post\" >

<table class=\"tableData\">
	<tr>
		<th>Check</th>
	  	<th><b><a href=\"admin.php?view=admin&ac=countryfix&orderby=user.username&type=$newtype".iif($search_var,"$search_var")."\">Username ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=countryfix&orderby=user.join_ip&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>IP</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=countryfix&orderby=user.name&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Name</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=countryfix&orderby=user.email&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>E-mail</b> ".$order[5]."</a></th>
	  
	</tr>
		$userslisted
</table>
<hr>
With selected: <select name=\"action\">
	<option value=\"fix_country\">Change The Country
</select>
<input type=\"submit\" value=\"Go\">
</form>
";

if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type users<br />";
	if($ttotal > 100) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-100;
		$bc.="<a href=\"admin.php?view=admin&ac=countryfix&start=$bstart&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Back</a>";
	}
	if(($start > 9) && ($start+100 < $ttotal)) {$bc.=" :: ";}
	if($start+100 < $ttotal) {
		$start=$start+100;
		$bc.=" <a href=\"admin.php?view=admin&ac=countryfix&start=$start&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Next</a> ";
	}
	if($ttotal > 100) {$bc.=" ]";}
}


$includes[content].=$bc."</div>";
//**E**//
?>
