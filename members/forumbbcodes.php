<?

function replace($txt) {


$txt = str_replace(":o", "<img src=\"members/smiles/content.gif\">", $txt);
$txt = str_replace(":P", "<img src=\"members/smiles/clin-oeuil-langue.gif\">", $txt);
$txt = str_replace(":p", "<img src=\"members/smiles/clin-oeuil-langue.gif\">", $txt);
$txt = str_replace(":FU:", "<img src=\"members/smiles/FU.gif\">", $txt);
$txt = str_replace("[A]", "<img src=\"members/smiles/ange.gif\">", $txt);
$txt = str_replace(":)", "<img src=\"members/smiles/sourire.gif\">", $txt);
$txt = str_replace(":(", "<img src=\"members/smiles/pleure.gif\">", $txt);
$txt = str_replace(":8", "<img src=\"members/smiles/cool.gif\">", $txt);
$txt = str_replace(";)", "<img src=\"members/smiles/clin-oeuil.gif\">", $txt);
$txt = str_replace("[beer]", "<img src=\"members/smiles/biere.gif\">", $txt);
$txt = str_replace("[PC]", "<img src=\"members/smiles/ordi.gif\">", $txt);
$txt = str_replace("8-)", "<img src=\"members/smiles/rolleyes.gif\">", $txt);
$txt = str_replace("[lovestruck]", "<img src=\"members/smiles/lovestruck.gif\">", $txt);
$txt = str_replace("[evil]", "<img src=\"members/smiles/evil.gif\">", $txt);
$txt = str_replace("[gdn]", "<img src=\"members/smiles/goodnight.gif\">", $txt);
$txt = str_replace("[offtop]", "<img src=\"members/smiles/offtopic.gif\">", $txt);
$txt = str_replace("[stu]", "<img src=\"members/smiles/stu.gif\">", $txt);
$txt = str_replace("[nsh]", "<img src=\"members/smiles/nospamhere.gif\">", $txt);
$txt = str_replace("[newhere]", "<img src=\"members/smiles/newhere.gif\">", $txt);
$txt = str_replace("[we]", "<img src=\"members/smiles/spwhatever.gif\">", $txt);
$txt = str_replace(":s", "<img src=\"members/smiles/confused.gif\">", $txt);
$txt = str_replace(":S", "<img src=\"members/smiles/confused.gif\">", $txt);


		
		
// Declare the format for [quote] layout
$QuoteLayout = '<table width="80%" border="0" align="center" cellpadding="3" cellspacing="0" class"TextBox">
<tr><td class="TextBox"> Quote:</td></tr></table>';	
			
		


/////////BB Codes////////////
$txt = str_replace("[quote]", "$QuoteLayout", $txt);
$txt = str_replace("[/quote]", "</quote>", $txt);
$txt = str_replace("[center]", "<center>", $txt);
$txt = str_replace("[/center]", "</center>", $txt);
$txt = str_replace("[b]", "<b>", $txt);
$txt = str_replace("[/b]", "</b>", $txt);
$txt = str_replace("[u]", "<u>", $txt);
$txt = str_replace("[/u]", "</u>", $txt);
$txt = str_replace("[i]", "<i>", $txt);
$txt = str_replace("[/i]", "</i>", $txt);
$txt = str_replace("[move]", "<marquee>", $txt);
$txt = str_replace("[/move]", "</marquee>", $txt);
$txt = str_replace("[img]", "<img border=0 src=", $txt);
$txt = str_replace("[/img]", ">",  $txt);


$txt = str_replace(array("\r\n", "\n", "\r"), '<br>', $txt); 
$txt = str_replace("[b]", "<b>", $txt);
$txt = str_replace("[h1]", "<h1>", $txt);
$txt = str_replace("[h2]", "<h2>", $txt);
$txt = str_replace("[h3]", "<h3>", $txt);
$txt = str_replace("[h3]", "<h3>", $txt);
$txt = str_replace("[h4]", "<h4>", $txt);
$txt = str_replace("[h5]", "<h5>", $txt);



return $txt;
}

function rep2($txt) {
$txt = str_replace('&lt;','<',$txt);
$txt = str_replace('&gt;','>',$txt);
$txt = str_replace('&quot;','\"',$txt);
$txt = str_replace('&#039;',"'",$txt);
$txt = str_replace('&#amp;','&',$txt);
return $txt;
}
?>