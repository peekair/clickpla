<?php
$includes[title]="Trading Center - New";
$auct = mysql_query("SELECT * FROM `auctions`")or die(mysql_error());
while ($auc = mysql_fetch_array($auct)){
$ending = $auc['ending'];
$win = $auc['win'];

if ($ending <= time()){

$seller = $auc['seller'];
$bidder = $auc['bidder'];

$sq = mysql_query("SELECT * FROM `user` WHERE `username` = '{$seller}' LIMIT 1")or die(mysql_error());
$sa = mysql_fetch_array($sq);

$bq = mysql_query("SELECT * FROM `user` WHERE `username` = '{$bidder}' LIMIT 1")or die(mysql_error());
$ba = mysql_fetch_array($bq);

$scash = $sa['balance'] + $auc['win'];
$bcash = $ba['balance'] - $auc['win'];

if ($auc['win'] == 0){

$msg = ("");



if ($auc['db_table'] == "link_credits"){

$que19 = mysql_query("SELECT * FROM `user` WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
$arr19 = mysql_fetch_array($que19);

$link_credits = $sa['link_credits'] + $auc['link_credits'];
$linkcreds = $arr19['link_credits'] - $auc['link_credits'];

mysql_query("UPDATE `user` SET `link_credits` = '{$linkcreds}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());

mysql_query("UPDATE `user` SET `link_credits` = '{$link_credits}' WHERE `username` = '{$auc['seller']}' LIMIT 1")or die(mysql_error());
}elseif ($auc['db_table'] == "ptra_credits"){

$que19 = mysql_query("SELECT * FROM `user` WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
$arr19 = mysql_fetch_array($que19);

$ptra_credits = $sa['ptra_credits'] + $auc['ptra_credits'];
$ptracreds = $arr19['ptra_credits'] - $auc['ptra_credits'];

mysql_query("UPDATE `user` SET `ptra_credits` = '{$ptracreds}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());

mysql_query("UPDATE `user` SET `ptra_credits` = '{$ptra_credits}' WHERE `username` = '{$auc['seller']}' LIMIT 1")or die(mysql_error());
}

mysql_query("DELETE FROM `auctions` WHERE `id` = '{$auc['id']}' LIMIT 1")or die(mysql_error());

}elseif ($ba['balance'] < $auc['win']){

$msg = ("");



$msg2 = ("");


if ($auc['db_table'] == "link_credits"){

$que19 = mysql_query("SELECT * FROM `user` WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
$arr19 = mysql_fetch_array($que19);

$link_credits = $sa['link_credits'] + $auc['link_credits'];
$linkcreds = $arr19['link_credits'] - $auc['link_credits'];

mysql_query("UPDATE `user` SET `link_credits` = '{$linkcreds}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());

mysql_query("UPDATE `user` SET `link_credits` = '{$link_credits}' WHERE `username` = '{$auc['seller']}' LIMIT 1")or die(mysql_error());
}elseif ($auc['db_table'] == "ptra_credits"){

$que19 = mysql_query("SELECT * FROM `user` WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
$arr19 = mysql_fetch_array($que19);

$ptra_credits = $sa['ptra_credits'] + $auc['ptra_credits'];
$ptracreds = $arr19['ptra_credits'] - $auc['ptra_credits'];

mysql_query("UPDATE `user` SET `ptra_credits` = '{$ptracreds}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());

mysql_query("UPDATE `user` SET `ptra_credits` = '{$ptra_credits}' WHERE `id` = '{$auc['item_id']}' LIMIT 1")or die(mysql_error());
}

mysql_query("DELETE FROM `auctions` WHERE `id` = '{$auc['id']}' LIMIT 1")or die(mysql_error());

}else{

$msg = ("");


$msg2 = ("");


if ($auc['db_table'] == "link_credits"){

$que19 = mysql_query("SELECT * FROM `user` WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
$arr19 = mysql_fetch_array($que19);

$link_credits = $ba['link_credits'] + $auc['link_credits'];
$linkcreds = $arr19['link_credits'] - $auc['link_credits'];

mysql_query("UPDATE `user` SET `link_credits` = '{$linkcreds}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());

mysql_query("UPDATE `user` SET `link_credits` = '{$link_credits}' WHERE `username` = '{$bidder}' LIMIT 1")or die(mysql_error());

}elseif ($auc['db_table'] == "ptra_credits"){

$que19 = mysql_query("SELECT * FROM `user` WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
$arr19 = mysql_fetch_array($que19);

$ptra_credits = $ba['ptra_credits'] + $auc['ptra_credits'];
$ptracreds = $arr19['ptra_credits'] - $auc['ptra_credits'];

mysql_query("UPDATE `user` SET `ptra_credits` = '{$ptracreds}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());

mysql_query("UPDATE `user` SET `ptra_credits` = '{$ptra_credits}' WHERE `username` = '{$bidder}' LIMIT 1")or die(mysql_error());

}

mysql_query("UPDATE `user` SET `balance` = '{$scash}' WHERE `username` = '{$seller}' LIMIT 1")or die(mysql_error());
mysql_query("UPDATE `user` SET `balance` = '{$bcash}' WHERE `username` = '{$bidder}' LIMIT 1")or die(mysql_error());

mysql_query("DELETE FROM `auctions` WHERE `id` = '{$auc['id']}' LIMIT 1")or die(mysql_error());

}}}

$query = mysql_query("SELECT * FROM `user` WHERE `username` = '{$username}' LIMIT 1")or die(mysql_error());
$arr = mysql_fetch_array($query);

$qry = mysql_query("SELECT * FROM `user` WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
$ary = mysql_fetch_array($qry);

$filter = strip_tags($_POST['filter']);

if (!$filter){
$auct = mysql_query("SELECT * FROM `auctions` ORDER BY `ending` ASC")or die(mysql_error());
}elseif ($filter){
$auct = mysql_query("SELECT * FROM `auctions` WHERE `db_table` = '{$filter}'ORDER BY `ending` ASC")or die(mysql_error());
}

$anum = mysql_numrows($auct);

print ("

<form action='' method='post'>
");

$tradedd = $_GET['trade'];

if (!$tradedd){
echo ("");
}

if ($_GET['trade']){
$traded = $_GET['trade'];

$lol = mysql_query("SELECT * FROM `auctions` WHERE `id` = '{$traded}' LIMIT 1")or die(mysql_error());
$slag = mysql_fetch_array($lol);

print ("
<table align='center' width='30%' border='0' cellpadding='2' cellspacing='0'  >
<tr><td align='center' colspan='2'>
<input type='text' class='TextBox' name='trade' size='20'><br><br><input type='submit' name='submit' class='abutton' value='Place Offer'></td></tr>
</table><br>");
}
if ($_POST['sell']){
$sell = strip_tags($_POST['sell']);

$minimum = strip_tags($_POST['minimum']);

if (!$minimum && $minimum != "0"){
echo ("<center><h3>Please enter your desired minimum bid.</h3></center>");
}elseif ($minimum || $minimum == "0"){


if ($minimum > 1000000000){
echo ("<center><h3>Min trade can't be over $1,000,000,000.</h3></center>");
}elseif ($minimum <= 1000000000){

$end = strip_tags($_POST['end']);

if (!$end){
echo ("<center><h3>Please enter the time you wish the auction to last.</h3></center>");
}elseif ($end){

if ($end < 0.00 || $end > 100){
echo ("<center><h3>Auction time cannot be under 1 minute or over 100 hours.</h3></center>");
}elseif ($end >= 0.00 && $end <= 100){

$end = time() + ($end * 3600); 

if ($sell == "ptra_credits"){

$ptra_credits = strip_tags($_POST['ptra_credits']);

if (!$ptra_credits){
echo ("<center><h3>Please enter the amount of ptra_credits you wish to sell.</h3></center>");
}elseif ($ptra_credits){

if (ereg("[^[:digit:]]", $ptra_credits)){
echo ("<center><h3>Paid To Read Hits amount can only contain digits.</h3></center>");
}elseif (!ereg("[^[:digit:]]", $ptra_credits)){

if ($ptra_credits < 1){
echo ("<center><h3>Paid To Read Hits amount can only be 1 or more.</h3></center>");
}elseif ($ptra_credits >= 1){

if ($ptra_credits > $arr['ptra_credits']){
echo ("<center><h3>You don't have that many Paid To Read hits.</h3></center>");
}elseif ($ptra_credits <= $arr['ptra_credits']){

$newptra_credits = $arr['ptra_credits'] - $ptra_credits;
$auctptra_credits = $ary['ptra_credits'] + $ptra_credits;

mysql_query("INSERT INTO `auctions` ( `id` , `seller` , `item` , `item_id` , `min` , `win` , `bidder` , `ending` , `db_table` , `ptra_credits` )
VALUES
( '' , '{$username}' , '{$ptra_credits} Paid To Read Hits' , '{$arr['id']}' , '{$minimum}' , '0' , '' , '{$end}' , 'ptra_credits' , '{$ptra_credits}' )")or die(mysql_error());

mysql_query("UPDATE `user` SET `ptra_credits` = '{$newptra_credits}' WHERE `username` = '{$username}' LIMIT 1")or die(mysql_error());
mysql_query("UPDATE `user` SET `ptra_credits` = '{$auctptra_credits}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
echo ("<center><h3>You put your link credits / Paid To Read credits up for sale.</h3></center>");

}}}}
}elseif ($sell == "link_credits"){

$link_credits = strip_tags($_POST['link_credits']);

if (!$link_credits){
echo ("<center><h3>Please enter the amount of Link Ad Hits you wish to sell</h3></center>");
}elseif ($link_credits){

if (ereg("[^[:digit:]]", $link_credits)){
echo ("<center><h3>Link Ad Hits amount can only contain digits.</h3></center>");
}elseif (!ereg("[^[:digit:]]", $link_credits)){

if ($link_credits < 1){
echo ("<center><h3>Link Ad Hits amount can only be 1 or more.</h3></center>");
}elseif ($link_credits >= 1){

if ($link_credits > $arr['link_credits']){
echo ("<center><h3>You don't have that many Link Ad Hits.</h3></center>");
}elseif ($link_credits <= $arr['link_credits']){

$newlink_credits = $arr['link_credits'] - $link_credits;
$auctlink_credits = $ary['link_credits'] + $link_credits;

mysql_query("INSERT INTO `auctions` ( `id` , `seller` , `item` , `item_id` , `min` , `win` , `bidder` , `ending` , `db_table` , `ptra_credits` , `link_credits` )
VALUES
( '' , '{$username}' , '{$link_credits} Link Ad Hits' , '{$arr['id']}' , '{$minimum}' , '0' , '' , '{$end}' , 'link_credits' , '' , '{$link_credits}' )")or die(mysql_error());

mysql_query("UPDATE `user` SET `link_credits` = '{$newlink_credits}' WHERE `username` = '{$username}' LIMIT 1")or die(mysql_error());
mysql_query("UPDATE `user` SET `link_credits` = '{$auctlink_credits}' WHERE `username` = 'Auction bot' LIMIT 1")or die(mysql_error());
echo ("<center><h3>You put your Link Ad Hits / Paid To Read Hits up for sale.</h3></center>");

}}}}
}

}}}}}

$traded = $_GET['trade'];

$lol = mysql_query("SELECT * FROM `auctions` WHERE `id` = '{$traded}' LIMIT 1")or die(mysql_error());
$slag = mysql_fetch_array($lol);

if ($_POST['trade']){

$trade = strip_tags($_POST['trade']);



if ($trade < $slag['min']){
echo ("<center><h3>You cannot trade lower than the Minimum bid.</h3></center>");
}elseif ($trade >= $slag['min']){

if ($trade <= $slag['win']){
echo ("<center><h3>Your trade must be higher than the current trade.</h3></center>");
}elseif ($trade > $slag['win']){

if ($trade > $arr['balance']){
echo ("<center><h3>You don't have that much money.</h3></center>");
}elseif ($trade <= $arr['balance']){

if ($slag['ending'] < time()){
echo ("<center><h3>That auction has already ended.</h3></center>");
}elseif ($slag['ending'] >= time()){

if ($slag['seller'] == $username){
echo ("<center><h3>You cannot trade on your own item.</h3></center>");
}else{

mysql_query("UPDATE `auctions` SET `win` = '{$trade}' , `bidder` = '{$username}' WHERE `id` = '{$slag['id']}' LIMIT 1")or die(mysql_error());

echo ("<center><h3>You have placed a bid on that item.</h3></center>");
}}}}}}






print ("</form>
<a href=\"index.php?view=account&ac=shoppingcenter\"><img src=\"members/images/refresh_icon.jpg\" border=\"0\"></a> 
  <br><br>
    <div style=\"width: 100%;\" >

						<table class=\"tableData\">
    <!--DWLayoutTable-->
    </tr>
    <tr>
      <th width='95'>Seller</th>
      <th width='168'>Offering</th>
      <th width='70'>Min Bid</th>
	  <th width='90'>Current Bid</b></th>
      <th width='93'>Bid</th>
	  <th width='266'>Ends In</th>
    </tr>");

if ($anum == 0 && !$filter){
echo ("<tr><td  colspan='7'><h447>Nothing on trade at this momement.</h447></td></tr>");
}elseif ($anum == 0 && $filter){
echo ("<tr><td align='left' colspan='7'>Nothing on trade at this momement.</td></tr>");
}elseif ($anum > 0){



while ($auction = mysql_fetch_array($auct)){
echo ("<tr>
<td><h447>{$auction['seller']}</h447></td>
<td><h447>".($auction['item'])."</h447></td>
<td><h447>$".($auction['min'])."</h447></td>
<td><h447>$".($auction['win'])."</h447></td>
<td><a href='index.php?view=account&ac=shoppingcenter&trade={$auction['id']}'><b><h447>Place Bid</h447></b></a></td>
<td align='left'><h447>Soon</h447></td>
</tr>");
}}
print ("</table></div>");

print ("
<form action='' method='post'>
<br><br><br><table width='55%' align='center' border='0' cellpadding='2' cellspacing='0' class='ptcList'>
<tr><td colspan='2'><h3>
Post On Trade</h3>
</td></tr>");

print ("
  <tr>
    <td align='left'><input type='radio' name='sell' value='ptra_credits' id='7' />Paid To Read Hits:</td>
    <td align='left'><input name='ptra_credits' type='text' class='TextBox' maxlength='10' /></td>
  </tr>
  <tr>
<td align='left'><input type='radio' name='sell' value='link_credits' id='8'><label for='8'>Link Ad Hits:</label></td>
<td align='left'><input type='text' name='link_credits'  class='TextBox'   maxlength='10'></td>
</tr>
<tr>
<td align='left'>Minimum bid</td>
<td align='left'><input type='text' name='minimum' class='TextBox' maxlength='10' value='0'></td>
</tr>
<tr>
<td align='left'>Time to sell</td>
<td align='left'><select name='end'  class='TextBox' id='end'>
  <option value='0.02'>1 Minutes 11 Seconds</option>
  <option value='0.12'>7  Minutes 0 Seconds</option>
  <option value='0.25'>15 Minutes 0 Seconds</option>
  <option value='0.50'>30 Minutes 0 Seconds</option>
  <option value='1'>60 Minutes 0 Seconds</option>
  <option value='2'>120 Minutes 0 Seconds</option>
</select></td>
</tr>
<tr><td colspan='2' align='center'><input type='submit' class='abutton' name='submit' value='Post On Trade'></td></tr>
</table>
<br><br><h4></center>Trading Center F.A.Q</h4>
<ul>
<li><h447>If your item is not sold your item will be returned.</h447></li>
  <li><h447>There is absolutely no fees using the trading center.</h447></li>
  <li><h447>If you spam the trading center with offers your account will be banned.</h447></li>
   <li><h447>If you have any problems or bugs to report please use the contact page.</h447></li>
</ul>
</form>
<br><br>
");
?>