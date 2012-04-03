<head>
<script language="javascript" type="text/javascript">

function insertIM(id){
var obj = document.getElementById('descrip');if(typeof(document.selection)!='undefined') 

{

obj.focus();
var range = document.selection.createRange();

if(range.parentElement() != obj) {
return false;

}
var orig = obj.value.replace(/rn/g, "n");

range.text = id;
var actual = tmp = obj.value.replace(/rn/g, "n");

for(var diff = 0; diff < orig.length; diff++) {
if(orig.charAt(diff) != actual.charAt(diff)) break;

}
for(var index = 0, start = 0; (tmp = tmp.replace(id, "")) && (index <= diff); index = start + id.length) {

start = actual.indexOf(id, index);

}
} else {

var startPos = obj.selectionStart;
var endPos = obj.selectionEnd;

obj.value = obj.value.substr(0, startPos) + id + obj.value.substr(endPos, obj.value.length);


}
}
</script>
</head>
<? 
$includes[title]="View Forum";  

/******************************************************************************\
 * Copyright (C) 2010 Developz                                          *
 *                                                                            *
 * This addon was made by Developz.   *
 *                                                                            *
 *                                  flashurcash.org *
\******************************************************************************/

  include"forumbbcodes.php";

if($_GET['forum'] != "") $forum=$_GET['forum']; 
else if($_POST['forum'] != "") $forum=$_POST['forum'];    
$viewforum=$_GET['viewforum'];



if(strip_tags($_POST['insert']) && strip_tags($_POST['subject']) && strip_tags($_POST['descrip'])){
	
$subject=strip_tags($_POST['subject']);
$descrip=strip_tags($_POST['descrip']);

$today = gmdate('Y-m-d h:i:s');

mysql_query("INSERT INTO `forum_topics` (`id`, `username`, `subject`, `descrip`, `lastpost`, `forum`) 
VALUES ('', '$username', '$subject', '$descrip', '$today', '$viewforum');") or die (
mysql_error());
echo "Topic Successfully Created!";		
}

if($action == "delete") {
	$sql=$Db1->query("DELETE FROM forum_topics WHERE id='$id'");
		header("Location: index.php?view=account&ac=viewforum&viewforum=$viewforum&".$url_variables."");
	}


	$tbl_name="";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/

	$query = "SELECT COUNT(*) as num FROM forum_topics WHERE forum='$viewforum'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "index.php?view=account&ac=viewforum&viewforum=$viewforum&".$url_variables.""; 	//your file name  (the name of this file)
	$limit = 10; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
          $sql=$Db1->query("SELECT * FROM forum_topics WHERE forum='$viewforum' ORDER BY lastpost DESC LIMIT $start, $limit");
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage&page=$prev\"> &laquo; previous </a>";
		else
			$pagination.= "&laquo; previous";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "$counter";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "$counter";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "$counter";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "$counter";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&page=$next\">next &raquo;</a>";
		else
			$pagination.= " next &raquo; ";
		$pagination.= "\n";		
	}



if($Db1->num_rows() != 0) {
	while($he=$Db1->fetch_array($sql)) {
$totalpos= mysql_num_rows(mysql_query("SELECT id FROM forum_replys WHERE idto='$he[id]'"));	
	$linkads.="



 <tr>
<td>
<img src=\"members/images/topicico.gif\">
<b><a href=\"index.php?view=account&ac=viewtopic&viewtopicid=$he[id]&".$url_variables."\">$he[subject]</a></b></td>
<td>$totalpos</td>
<td>$he[lastpost] ".iif($permission==7," <a href=index.php?view=account&ac=viewforum&viewforum&action=delete&id=$he[id]> [X] </a>")."</td>
</tr>
      

";
}}
$includes[content]="
<a href=\"index.php?view=account&ac=forumindex&".$url_variables."\">Forum >>> </a>
<a href=\"index.php?view=account&ac=viewforum&viewforum=$viewforum&".$url_variables."\">$viewforum</a> 
	  <table width=\"100%\" class=\"tableData\">
	    <tr>
	      <th width=\"60%\">Topic</th>
	      <th width=\"10%\">Reply's</th>
	      <th width=\"30%\">Last Reply</th>
       </tr>
$linkads
</table>

$pagination

	  <form id=\"form1\" method=\"post\" action=\"\">
	    <div align=\"center\">
	      <table width=\"515\" border=\"0\" cellpadding=\"7\" cellspacing=\"0\" class=\"tableData\">
	        <tr>
	          <th>Create A New Topic</th>
            </tr>
	        <tr>
	          <td>Subject
              <br /><input name=\"subject\" type=\"text\" id=\"subject\" value=\"\"  maxlength=\"43\" style=\"width:100%;\"/></td>
            </tr>
	        <tr>
	          <td><p>Content
	            <textarea name=\"descrip\" id=\"descrip\" rows=\"5\" style=\"width:100%;\"></textarea>
	            </p>
	            <p align=\"center\">
	              <input type=\"submit\" name=\"insert\" id=\"insert\" value=\"Create Topic\" style=\"width:100%;\"/>
              </p></td>
            </tr>
<tr><td><div align=\"center\">
      <img src=members/smiles/picture.png  onClick=\"insertIM('[img] URL [/img]')\" />
      <img src=members/smiles/boldt.png onClick=\"insertIM('[b] Text [/b]')\" />
      <img src=members/smiles/ita.png  onClick=\"insertIM('[i] Text [/i]')\" /> 
      <img src=members/smiles/under.png  onClick=\"insertIM('[u] Text [/u]')\" />
      <img src=members/smiles/quote.gif  onClick=\"insertIM('[quote] Text [/quote]')\" />
      <img src=\"members/smiles/sourire.gif\" onClick=\"insertIM(':)')\" />
      <img src=\"members/smiles/pleure.gif\"  onClick=\"insertIM(':(')\" /> 
      <img src=\"members/smiles/clin-oeuil-langue.gif\"  onClick=\"insertIM(':p')\" /> 
      <img src=\"members/smiles/cool.gif\"  onClick=\"insertIM(':8')\" /> 
      <img src=\"members/smiles/content.gif\"  onClick=\"insertIM(':o')\" /> 
      <img src=\"members/smiles/evil.gif\"  onClick=\"insertIM('[evil]')\" /> 
      <img src=\"members/smiles/confused.gif\"  onClick=\"insertIM(':s')\" /> 
      <img src=\"members/smiles/FU.gif\"  onClick=\"insertIM(':FU:')\" /> 
      <img src=\"members/smiles/biere.gif\"  onClick=\"insertIM('[beer]')\" /> 
      <img src=\"members/smiles/clin-oeuil.gif\"  onClick=\"insertIM(';)')\" /> 
      <img src=\"members/smiles/rolleyes.gif\"  onClick=\"insertIM('8-)')\" />
</div></td></tr>
          </table>
        </div>
</form>
";
?>