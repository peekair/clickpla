<?php 

$includes[title]="Scrambled Words Game";


if(!IN_CLICKING) exit;

$answer = $_POST["answer"];
$correct = $_POST["correct"];
if (empty($_POST["answer"]))  {

srand((float) microtime() * 10000000);
$input = array(
"dictionary",   // if you add words  be sure to use lowercase letters Add words like the following "newword",
"recognize",
"example",
"entertainment",
"experiment",
"appreciation",
"information",
"pronunciation",
"language",
"government",
"psychic",
"blueberry",
"selection",
"automatic",
"strawberry",
"bakery",
"shopping",
"eggplant",
"chicken",
"organic",
"angel",
"season",
"market",
"information",
"complete",
"sunset",
"unique",
"customer",
"aurora"    // last word leave off the comma (,)
);
$rand_keys = array_rand($input, 2);
$word = $input[$rand_keys[0]];
$Sword = str_shuffle($word);
echo "<div align=\"center\">
  <table border=\"0\" cellspacing=\"3\" width=\"592\" cellpadding=\"4\">
    <tr>
     <td class=\"scrama\">
      $Sword</td>
    </tr>
    <tr>
      <td class=\"scramb\" width=\"592\">
      In the text box below type the correct word that is scrambled above and win 5 banner credits.</td>
    </tr>
    <tr>
      <td width=\"582\">
      <form method=\"POST\" action=\"index.php?view=account&ac=scrambledwords&".$url_variables."\">
        <center><input type=\"text\" class=\"scramtext\" name=\"answer\" size=\"15\"><input type=\"hidden\" name=\"correct\" value=\"$word\"><br><br>
<input type=\"submit\" value=\"GO!\" name=\"B1\" style=\"font-size: 15pt; color: #FFFFFF; font-weight: bold; width: 35; height: 40; background-color: #cccccc\"></center>
      </form>
      </td>
    </tr>
  </table>
</div></body></html>";
}
else {

$answer = strtolower($answer);

if($answer == $correct){

$sql=$Db1->query("UPDATE user SET banner_credits=banner_credits+5, scramlmt=scramlmt+1, scram_last='$answer' WHERE username='$thismemberinfo[username]' ");

$result = "$answer";

echo "<div align=\"center\">
  <table border=\"0\" cellspacing=\"1\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"592\">
    <tr>
    <td width=\"592\" class=\"scramc\">You Guessed Correct! The Word Was:   $result </td><br>
   </tr>
<tr>
<td width=\"592\" class=\"scramb\">You Just Won 5 banner Credits</td>
    </tr>
    <tr>
      <td class=\"scrame\" width=\"582\">
      
      <a href=\"index.php?view=account&ac=scrambledwords&".$url_variables."\">Try Another Word?</a></td>
    </tr>
  </table>
</div>";



}

else { $result = "$correct";
echo "<div align=\"center\">
  <table border=\"0\" cellspacing=\"1\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"592\">
    <tr>
      <td class=\"scramc\" width=\"592\">
      OOOps Sorry the Correct answer was $result better luck next time!</td>
    </tr>
    <tr>
      <td class=\"scrame\" width=\"592\">
      
      <a href=\"index.php?view=account&ac=scrambledwords&".$url_variables."\">Try Another Word?</a></font></td>
    </tr>
  </table>
</div>";

}
}
?>