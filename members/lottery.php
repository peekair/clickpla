<style type="text/css">
input.lottobutton
{
   background-image: url('/images/lotblue.png');
   border: none;
    font: 100% Verdana, Arial, Helvetica, sans-serif;
   margin: 1px 1px 1px 1px;
   width: 36px;
   height: 36px;
   font-weight: bold;
}
input.lottobutton2
{
   background-image: url('/images/lottono.png');
   border: none;
    font: 100% Verdana, Arial, Helvetica, sans-serif;
   margin: 1px 1px 1px 1px;
   width: 36px;
   height: 36px;
}
input.lottobutton3
{
   background-color: #FFFF00;
   border: none;
    font: 100% Verdana, Arial, Helvetica, sans-serif;
   font-weight: bold;
   margin: 1px 1px 1px 1px;
   width: 36px;
   height: 36px;
}
</style>
<?php

$includes[title]="Lottery";
 if($settings["lottery_enabled"] == 1){
 
if($_POST) 
{
	if($newbalance<=-0.00001)
	{
		$money = $thismemberinfo['balance'];
	} 
	else 
	{
		$money = $newbalance;
	}
	if($money>$settings["lottery_ticketprice"])
	{
		$ticketprice=$settings["lottery_ticketprice"];
		
		$username=$thismemberinfo['username'];
		$number=$_POST['nr'];
		$ticketquery = "INSERT INTO jackpot (username,ticket_num) VALUES('$username','$number')";
		$Db1->query($ticketquery);
	
	    $ticketprice=$settings["lottery_ticketprice"];
	    $newbalance=$thismemberinfo[balance]-$ticketprice;
	    $Db1->query("UPDATE user SET balance='$newbalance' WHERE username='$username'");
	    $money=$newbalance;
	
	    $nrticketquery = $Db1->query("SELECT COUNT(*) AS tot FROM jackpot");
	    $rows=$Db1->num_rows($nrticketquery);
	    $i=0;
	    
	    if($rows > $i)
	    {
		    while($x = $Db1->fetch_array($nrticketquery))
		    {
			    $ticketsbought = $x['tot'];
		    }
	    }
	    else
	    {
		    $ticketsbought=0;
	    }
		$error_msg="You have just purchased a ticket ... Good luck !!!";
    }
	//--------------------------------- IF ALL TICKETS ARE BOUGHT ---------------------------------------
	if($ticketsbought>=100)
	{
		//These variables are the real amount of money the user will recieve. You can change them if you want.
	    $prize1=$settings["lottery_price1st"];
	    $prize2=$settings["lottery_price2nd"];
	    $prize3=$settings["lottery_price3"];
	    $prize4=$settings["lottery_price4"];
	
	    $queryinsertnr = "INSERT INTO jackpot (username,ticket_num) VALUES('$username','$numberofticket')";
	    $Db1->query($queryinsertnr);
	
	    $winningnr1 = mt_rand(1,100);
		
	    $selectw1 = $Db1->query("SELECT * FROM jackpot WHERE ticket_num='$winningnr1'");
	    $username1 = $Db1->fetch_array($selectw1);
		
	    $winner1 = $username1['username'];
		
	    $luckynr1 = $username1['ticket_num'];
		
	    $userwinner1 = $Db1->query("SELECT * FROM user WHERE username='$winner1'");
	    $userwin1 = $Db1->fetch_array($userwinner1);
	    $newbalance1 = $userwin1['balance']+$prize1;

	    $Db1->query("UPDATE user SET balance='$newbalance1' WHERE username='$winner1'");
		
		$winningnr2 = mt_rand(1,100);
		if($winningnr2=$winningnr1)
		{
			$winningnr2 = mt_rand(1,100);
		}
		
		$selectw2 = $Db1->query("SELECT * FROM jackpot WHERE ticket_num='$winningnr2'");
		$username2 = $Db1->fetch_array($selectw2);
		
		$winner2 = $username2['username'];
		
		$luckynr2 = $username2['ticket_num'];
		
		$userwinner2 = $Db1->query("SELECT * FROM user WHERE username='$winner2'");
		$userwin2 = $Db1->fetch_array($userwinner2);
		$newbalance2 = $userwin2['balance']+$prize2;

		$Db1->query("UPDATE user SET balance='$newbalance2' WHERE username='$winner2'");
		
		
		$winningnr3 = mt_rand(1,100);
		if($winningnr3=$winningnr1)
		{
			if($winningnr3=$winningnr2)
			{
				$winningnr3 = mt_rand(1,100);
			}
		}
		$selectw3 = $Db1->query("SELECT * FROM jackpot WHERE ticket_num='$winningnr3'");
		$username3 = $Db1->fetch_array($selectw3);
		
		$winner3 = $username3['username'];
		
		$luckynr3 = $username3['ticket_num'];
		
		$userwinner3 = $Db1->query("SELECT * FROM user WHERE username='$winner3'");
		$userwin3 = $Db1->fetch_array($userwinner3);
		$newbalance3 = $userwin3['balance']+$prize3;

		$Db1->query("UPDATE user SET balance='$newbalance3' WHERE username='$winner3'");
		
		$winningnr4 = mt_rand(1,100);
		if($winningnr4=$winningnr1)
		{
			if($winningnr4=$winningnr2)
			{
				if($winningnr4=$winningnr3)
				{
					$winningnr4 = mt_rand(1,100);
			    }
		    }
		}
		$selectw4 = $Db1->query("SELECT * FROM jackpot WHERE ticket_num='$winningnr4'");
		$username4 = $Db1->fetch_array($selectw4);
		
		$winner4 = $username4['username'];		
		$luckynr4 = $username4['ticket_num'];
		
		$userwinner4 = $Db1->query("SELECT * FROM user WHERE username='$winner4'");
		$userwin4 = $Db1->fetch_array($userwinner4);
		$newbalance4 = $userwin4['balance']+$prize4;

		$Db1->query("UPDATE user SET balance='$newbalance4' WHERE username='$winner4'");
		
		$Db1->query("INSERT INTO lottowinners (username1,ticket_num1,username2,ticket_num2,username3,ticket_num3,username4,ticket_num4) VALUES('$winner1','$winningnr1','$winner2','$winningnr2','$winner3','$winningnr3','$winner4','$winningnr4')");
	
		//As all tickets were bought, balance was given and data inserted into the new database, we can now remove all data from the ticket info, so that we can start the lottery again.
	    $Db1->query("TRUNCATE TABLE jackpot");
	}
}
$includes[content]="<div style='margin:0 auto; width: 380px'>
<form method='post' action='index.php?view=account&ac=lottery&{$url_variables}'>";

//This will check the user's balance
if($newbalance<=-0.00001)
{
	$money = $thismemberinfo['balance'];
} 
else 
{
	$money = $newbalance;
}

if($money<=$settings["lottery_ticketprice"])
{
	$ticketnumcheck = 1;
	while($ticketnumcheck<=100)
	{
		$result = $Db1->query("SELECT * FROM jackpot WHERE ticket_num='{$ticketnumcheck}'");
		if($Db1->num_rows($result) == 0)
		{ 
			$includes[content].="<input type='button' class='lottobutton' value='{$ticketnumcheck}'>";
		}
		else
		{
		    $ticketname=$result['username'];
		    $sqlquerycheck = "SELECT * FROM jackpot WHERE ticket_num='{$ticketnumcheck}'";
		    $resultquerycheck = $Db1->query($sqlquerycheck);        
		    $checker = $Db1->fetch_array($resultquerycheck);
		
		    if($thismemberinfo[username]!=$checker['username'])
		    {
		        $includes[content].="<input type='button' class='lottobutton2' value='{$ticketnumcheck}'>";
		    }
		    else
		    {
			    $includes[content].="<input type='button' class='lottobutton3' value='{$ticketnumcheck}'>";
		    }
	    }
	  //Adding the ticket number to check . If it's still less than 100 it'll do this again. Otherwise it'll show the message next
		++$ticketnumcheck;
	  }
	  
	  $includes[content].="</form><div><br>If you want to purchase a ticket, you will need $".$settings["lottery_ticketprice"]." in your balance. 
	  <br> You currently have \${$money} in your balance. </div></div>";
	  
  //If the user has enough money...
}
else
{
	$ticketnumcheck = 1;
	while($ticketnumcheck<=100)
	{
		$result = $Db1->query("SELECT * FROM jackpot WHERE ticket_num='{$ticketnumcheck}'");
	    //If there is no value there
	    if($Db1->num_rows($result) == 0)
	    {
		    $includes[content].="<input type='submit' name='nr' class='lottobutton' value='{$ticketnumcheck}' onMouseOver='goLite(this.form.name,this.name)' onMouseOut='goDim(this.form.name,this.name)'>"; 
	    }
	    else
	    { 
		    //Checking everything (This is the same as before)
	  	    $name=$result['username'];
		    $sqlquerycheck = "SELECT * FROM jackpot WHERE ticket_num='{$ticketnumcheck}'";
		    $resultquerycheck = $Db1->query($sqlquerycheck);        
		    $checker = $Db1->fetch_array($resultquerycheck);
		
		    if($thismemberinfo[username]!=$checker['username'])
		    {
		        $includes[content].="<input type='button' class='lottobutton2' value='{$ticketnumcheck}'>";
		    }
		    else
		    {
		        $includes[content].="<input type='button' class='lottobutton3' value='{$ticketnumcheck}'>";
	        }
        }
		++$ticketnumcheck;
	}
	$money=abs($money);
	$includes[content].="</div><center><b>You currently have \${$money} in your balance.</b></center></form><br><br>";
}

$includes[content].="<div class='lottery-rates'>
<table style='margin: 0 auto;' width='320px;' border='0'>
  <tr>
    <td style='margin: 2px 2px 2px 2px;'width='50%'>
	<b>First prize:</b> $ $settings[lottery_price1st]<br>
	<b>Second prize:</b> $ $settings[lottery_price2nd]<br>
	<b>Third prize:</b> $ $settings[lottery_price3]<br>
	<b>Fourth prize:</b> $ $settings[lottery_price4]<br>
	</td>

    <td width='50%'><strong>Ticket Price:</strong><br> $ $settings[lottery_ticketprice]</td>
    
  </tr>
</table>
<p align='center'>Instructions:<br>

- A Gray box means the ticket is unavailable.<br>
- A Yellow box means you bought that ticket.</p>
";

$includes[content].="Last drawings winners: 
<table>
<tr>
<th><center>Round</center></th>
<th><center>1st #</center></th>
<th><center>2nd #</center></th>
<th><center>3rd #</center></th>
<th><center>4th #</center></th>
</tr>";
$result = $Db1->query("SELECT * FROM lottowinners ORDER BY id DESC limit 5");
while($checker = $Db1->fetch_array($result))
{
	$includes[content].="<tr>
	<td><center>{$checker['id']}</center></td>
	<td><center>{$checker[ticket_num1]}</center></td>
	<td><center>{$checker[ticket_num2]}</center></td>
	<td><center>{$checker[ticket_num3]}</center></td>
	<td><center>{$checker[ticket_num4]}</center></td>
	</tr>";
}
$includes[content].="</table></div>";
}
else {
echo "Lottery is not enabled in this site";
}
?>