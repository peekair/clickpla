<?
if(!IN_CLICKING) exit;

$clickHistory = loadClickHistory($username, "game");

/*$sql=$Db1->query("SELECT * FROM ".$adTables[$type]." WHERE id='{$id}'");
$ad=$Db1->fetch_array($sql);*/

/* error getting triggered after being redirected from the cheat check
if($type == "ptra") {
	$ct = $Db1->querySingle("SELECT dsub FROM click_sessions WHERE username='$username' and type='ptra'","dsub")+9;
	if($ct > time() || $Db1->num_rows()==0) error("You didn't wait long enough!");
}
*/


$time=time();
mt_srand((double)microtime()*1000000);
$num = mt_rand(0,3);

$Db1->query("DELETE FROM click_sessions WHERE username='$username' and type='game'");
$sql=$Db1->query("INSERT INTO click_sessions SET
	dsub='{$time}',
	username='{$username}',
	val='{$num}',
	type='game'
");


if(cheat_check("click", $id) == true) {
	$ad[target]="gpt.php?v=cheat&id={$id}&return=click&".$url_variables;
	$id=-1;
	
} else {


}

$sql=$Db1->query("SELECT dsub FROM browsevalgame WHERE username='$thismemberinfo[username]'");
if($Db1->num_rows() != 0){
	




$gana=rand(1, 9);



if($gana  == 1) { 
$id=1;
$money='0.0001';
$links='0';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='30';
$xcredits='0';
} 
if($gana  == 2) { 
$id=2;
$money='0.0002';
$links='2';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='25';
$xcredits='0';
} 
if($gana  == 3) { 
$id=3;
$money='0.0003';
$links='7';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='45';
$xcredits='0';
} 
if($gana  == 4) { 
$id=4;
$money='0.0002';
$links='4';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='35';
$xcredits='0';
} 
if($gana  == 5) { 
$id=5;
$money='0.0002';
$links='5';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='25';
$xcredits='0';
} 
if($gana  == 6) { 
$id=6;
$money='0.0003';
$links='3';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='50';
$xcredits='0';
} 
if($gana  == 7) { 
$id=7;
$money='0.0003';
$links='2';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='15';
$xcredits='0';
} 
if($gana  == 8) { 
$id=8;
$money='0.0001';
$links='3';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='50';
$xcredits='0';
} 
if($gana  == 9) {

$id=9;
$money='0.0005';
$links='5';
$ptr='0';
$pmails='0';
$ptpcredits='5';
$fads='0';
$fbanners='0';
$banners='25';
$xcredits='0';
}

if(findclick($clickHistory, $id) == 1) {
	

$premio='You have already win this price....skiping(Optional)';
//	header("Location: gpt.php?v=entry&type=ce&s=1&{$url_variables}");
	}


else {

$sql=$Db1->query("Select * from user where username='$thismemberinfo[username]'");

if($id==1){
$premio='Congratulations!  You won $0.0001, 30 banners, 5 PTP credits ';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits='xcredits+$xcredits'
	WHERE username='$thismemberinfo[username]'
	");
}
if($id==2) {
$premio='Congratulations!  You won $0.0002, 25 banners, 2 link credits ';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
}
if($id==3) {
$premio='Congratulations!  You won $0.0003, 45 banners, 7 link credits ';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
}
if($id==4) {
$premio='Congratulations!  You won $0.0002, 35 banners, 4 link credits ';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
}
if($id==5) {
$premio='Congratulations!  You won $0.0002, 25 banners, 5 link credits ';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
 }
if($id==6){
 $premio='Congratulations!  You won $0.0003, 50 banners, 3 link credits';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
 }
 if($id==7){
$premio='Congratulations!  You won $0.0003, 15 banners, 2 link credits ';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
}
if($id==8) {
$premio='Congratulations!  You won $0.0001, 50 banners, 3 link credits ';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
 }
if($id==9)
{
$premio='Congratulations!  You won $0.0005, 25 banners, 5 link credits';
$sql=$Db1->query("UPDATE user SET
	popup_credits=popup_credits+$ptpcredits,
	balance=balance+$money,
	link_credits=link_credits+$links,
	fad_credits=fad_credits+$fads,
	banner_credits=banner_credits+$banners,
	fbanner_credits=fbanner_credits+$fbanners,
	ptr_credits=ptr_credits+$ptr,
	ptra_credits=ptra_credits+$pmails,
	xcredits=xcredits+$xcredits
	WHERE username='$thismemberinfo[username]'
	");
}


}
 
$Db1->query("UPDATE click_history SET clicks='".$clickHistory.$id.":' WHERE username='$username' and type='game'");
$clickVerified == true;

}
else{
$premio='Ilegal access or Error Loading game';

}
$sql=$Db1->query("delete FROM browsevalgame WHERE username='$thismemberinfo[username]'");
 ?>
<script>          
	 	function goAway(){  
		
alert('<? echo $premio?>');   parent.location.href='gpt.php?v=entry&type=ce&s=1&<? $url_variables ?>'; 




}  
</script>          
	 		 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	<title>Cool Game  @ <?=$settings['site_title'];?></title>
</head>
	
	 		<body bgcolor="#333333">		  
	 		<table id="Table_01" width="100%" border="0" cellpadding="0" cellspacing="0" align="center">	
	 		<tr>		
	 			
	 		</tr>	
	 		<tr>		
	 		<td bgcolor="#FFFFFF" align="center" valign="top">
	 		header  goes here    
	 		<br>          
	 		<table align="center" width="50%">            
	 		<tr>              
	 		<td style="font-weight:bold">              
	 		<u>Instructions</u>: <ul>    <li>Click one of the money graphics (see below 1,2,3,4)   
	 		<li>Prizes are automatically added to your account    
	 		</ul>              
	 		</td>           
	 		</tr>          
	 		</table>      
	 		<table align="center">       
	 		 	<tr>          
<td>
<center><b><font color="red">Door #1</font></b></center>            <img src="images/1.gif" width="85" onclick="goAway()" style="cursor:pointer" value="number One" />          
</td>          
<td>
<center><b><font color="red">Door #2</font></b></center>            <img src="images/2.gif" width="85" onclick="goAway()" style="cursor:pointer" value="number two"/>          
</td>          
<td>
<center><b><font color="red">Door #3</font></b></center>            <img src="images/3.gif" width="85" onclick="goAway()" style="cursor:pointer" value="number three"/>          
</td>          
<td>
<center><b><font color="red">Door #4</font></b></center>            <img src="images/4.gif" width="85" onclick="goAway()" style="cursor:pointer" value="number four"/>          
</td>        
</tr>
</table>
<table align="center">  
<tr>
Script by <a href="http://www.latinclicks.info" target="_blank">LatinClicks</a>
</tr>	
</table>	 
</td>		
</tr>	
<tr>	
</tr>    
</table>        
</body>      
</html>
