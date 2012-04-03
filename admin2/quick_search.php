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
$includes[title]="Quick Search";

$includes[content]="


<div align=\"center\">
<table cellpadding=0 cellspacing=0>



<form action=\"admin.php?view=admin&ac=members&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Members: </td>
		<td align=\"center\" width=250>
		<input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"userid\" ".iif($search_by == "userid", "SELECTED").">Id
			<option value=\"name\" ".iif($search_by == "name", "SELECTED").">Name
			<option value=\"email\" ".iif($search_by == "email", "SELECTED").">Email
			<option value=\"refered\" ".iif($search_by == "refered", "SELECTED").">Referrer
			<option value=\"last_ip\" ".iif($search_by == "last_ip", "SELECTED").">Ip Address
			<option value=\"password\" ".iif($search_by == "password", "SELECTED").">Password
			<option value=\"country\" ".iif($search_by == "country", "SELECTED").">Country
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>




<form action=\"admin.php?view=admin&ac=deleted_members&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Deleted Members: </td>
		<td align=\"center\">
		<input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"userid\" ".iif($search_by == "userid", "SELECTED").">Id
			<option value=\"name\" ".iif($search_by == "name", "SELECTED").">Name
			<option value=\"email\" ".iif($search_by == "email", "SELECTED").">Email
			<option value=\"refered\" ".iif($search_by == "refered", "SELECTED").">Referrer
			<option value=\"last_ip\" ".iif($search_by == "last_ip", "SELECTED").">Ip Address
			<option value=\"password\" ".iif($search_by == "password", "SELECTED").">Password
			<option value=\"country\" ".iif($search_by == "country", "SELECTED").">Country
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>



<form action=\"admin.php?view=admin&ac=banners&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Banners: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Target Url
			<option value=\"banner\" ".iif($search_by == "banner", "SELECTED").">Banner Url
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>



<form action=\"admin.php?view=admin&ac=fbanners&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Featured Banners: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Target Url
			<option value=\"banner\" ".iif($search_by == "banner", "SELECTED").">Banner Url
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>




<form action=\"admin.php?view=admin&ac=fads&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Featured Ads: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"description\" ".iif($search_by == "description", "SELECTED").">Ad
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>




".iif(SETTING_PTC == true,"
<form action=\"admin.php?view=admin&ac=links&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Paid Links: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Url
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>
")."




".iif(SETTING_PTP == true,"
<form action=\"admin.php?view=admin&ac=popups&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Popups: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Url
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>
")."




".iif(SETTING_PTR == true,"
<form action=\"admin.php?view=admin&ac=emails&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Paid Emails: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>
")."


".iif(SETTING_PTRA == true,"
<form action=\"admin.php?view=admin&ac=ptrads&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>PTR Ads: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"ad\" ".iif($search_by == "ad", "SELECTED").">Ad
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Url
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>
")."


".iif(SETTING_CE == true,"
<form action=\"admin.php?view=admin&ac=xsites&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Exchange Sites: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Url
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>
")."



".iif(SETTING_GAMES == true,"
<form action=\"admin.php?view=admin&ac=game_sites&search=1&".$url_variables."\" method=\"post\">
	<tr>
		<td>Game Sites: </td>
		<td align=\"center\"><input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Url
		</select>
		</td>
		<td><input type=\"submit\" value=\"Search\"></td>
	</tr>
</form>
")."



</table>
</div>


";

?>
