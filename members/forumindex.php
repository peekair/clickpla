<?


$includes[title]="Forum Index";
if($settings["forum_on"] == 1){


/******************************************************************************\
 * Copyright (C) 2010 Developz                                          *
 *                                                                            *
 * This addon was made by Developz.   *
 *                                                                            *
 *                                  flashurcash.org *
\******************************************************************************/

function replace($txt) {
$txt = str_replace(array("\r\n", "\n", "\r"), '<br>', $txt); 
return $txt;
}


if (($_POST['insert']) && strip_tags($_POST['name']) && strip_tags($_POST['descip'])){
	

$name=mysql_real_escape_string(strip_tags($_POST['name']));
$descip=mysql_real_escape_string(strip_tags($_POST['descip']));

$today = gmdate('Y-m-d h:i:s');
mysql_query("INSERT INTO `forum_forums` (`id`, `name`, `descip`, `lastpost`) 
VALUES ('', '$name', '$descip', '$today');") or die (
mysql_error());
echo "Forum Successfully Created!";		
}




	$tbl_name="";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/

	$query = "SELECT COUNT(*) as num FROM forum_forums";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "index.php?view=account&ac=forumindex&".$url_variables.""; 	//your file name  (the name of this file)
	$limit = 10; 								//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
          $sql=$Db1->query("SELECT * FROM forum_forums ORDER BY id ASC LIMIT $start, $limit");
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
$totalposts= mysql_num_rows(mysql_query("SELECT id FROM forum_topics WHERE forum='$he[name]'"));	
$linkads.="



<tr>
<td><img src=\"members/images/forumfol.png\"><b><a href=\"index.php?view=account&ac=viewforum&viewforum=$he[name]&".$url_variables."\">$he[name]</a></b><br>".replace($he[descip])."</td>
<td>$totalposts</td>
</tr>
      

";
}}
$includes[content]="
	  <table width=\"100%\" class=\"tableData\">
	    <tr>
	      <th width=\"85%\">Forum</th>
	      <th width=\"15%\">Topics</th>
       </tr>
$linkads
</table>

$pagination

	 ".iif($permission==7,"
	
<br>
  <form id=\"form1\" method=\"post\" action=\"\"><br><br>

	    <div align=\"center\">
	      <table width=\"515\" border=\"0\" cellpadding=\"7\" cellspacing=\"0\" class=\"tableData\">
	        <tr>
	          <th>Create A New Forum</th>
            </tr>
	        <tr>
	          <td>Forum Name
              <br /><input name=\"name\" type=\"text\" id=\"name\" value=\"\"  maxlength=\"45\" style=\"width:100%;\"/></td>
            </tr>
	        <tr>
	          <td><p>Description
	            <textarea name=\"descip\" id=\"descip\" rows=\"5\" style=\"width:100%;\"></textarea>
	            </p>
	            <p align=\"center\">
	              <input type=\"submit\" name=\"insert\" id=\"insert\" value=\"Create Forum\" style=\"width:100%;\"/>
              </p></td>
            </tr>
          </table>
        </div>
</form>
")."
<br>
";
}
else {
echo "Forum is not enabled in this site";
}
?>