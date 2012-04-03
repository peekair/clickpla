<?
function stringsplit($the_string, $the_number)
{
   $startoff_nr = 0;
   $the_output_array = array();
   for($z = 1; $z < ceil(strlen($the_string)/$the_number)+1 ; $z++)
   {   
       $startoff_nr = ($the_number*$z)-$the_number;
       $the_output_array[] = substr($the_string, $startoff_nr, $the_number);
   }
   return($the_output_array);
}



$includes[title]="Ad Reports";
if($_GET['action']=="save"){
$includes[content].="<font color=\"red\">Your changes have been saved</font><br \>";
}//end action==save
$includes[content].="Here you can check reports that users have submitted regarding ads on this site.<br />
";


$reports=$Db1->query("SELECT * FROM reports ORDER BY reports DESC");
if($Db1->num_rows()!=0){


$includes[content].="
<table class=\"tableData\">
  <tr>
    <th width=\"41%\">Ad Title </th>
    <th width=\"41%\">Ad URL </th>
    <th width=\"18%\">Reports Made </th>
  </tr>
";

while($info=$Db1->fetch_array($reports)){
$title=stringsplit($info['title'], 30);
$title=$title[0]."...";
$target=stringsplit($info['target'], 30);
$target=$target[0]."...";
$includes[content].="
  <tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
    <td><a href=\"admin.php?view=admin&ac=view_report&adid={$info['adid']}&{$url_variables}\">{$title}</a></td>
    <td>{$target}</td>
    <td>{$info['reports']}</td>
  </tr>";

}//end while
$includes[content].="</table>";
}else{//end num_rows()
$includes[content].="<b>No reports have been made.</b>";
}//end else






?>




