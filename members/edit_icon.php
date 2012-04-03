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
$types=array(
	"link"=>"ads",
	"ptsu"=>"ptsuads",
	"ptrad"=>"ptrads"
);




function check_ext($ext) {
	$valids = array("jpg","gif","jpeg","png");
	$return = 0;
	for($x=0; $x<count($valids); $x++) {
		if($valids[$x] == strtolower($ext)) {
			$return = 1;
		}
	}
	return $return;
}

function doUpload($uploaddir, $postArray) {
//	global $postArray;
	if($postArray['userfile']['tmp_name'] != "none") {
		$newfilename = time() ."^^^". $postArray['userfile']['name'];
		$uploadfile = $uploaddir . $newfilename;
		$filename=$postArray['userfile']['name'];
		$temp = explode(".",$filename);
		$ext = $temp[count($temp)-1];
		if(check_ext($ext)) {
			move_uploaded_file($postArray['userfile']['tmp_name'], $uploadfile);
			return $newfilename;
		}
	}
	return false;
}


if($settings['iconOn'] == 1) {
	$sql=$Db1->query("SELECT * FROM ".$types[$type]." WHERE id='".addslashes($id)."' and username='".$username."'");
	if($Db1->num_rows() > 0) {
		$ad=$Db1->fetch_array($sql);
		if($ad['icon_on'] == 1) {
			if($action == "upload") {
				$result = doUpload('adicons/', $HTTP_POST_FILES);
				if($result != false) {
					$imgSize = getimagesize("adicons/".$result);
					if($imgSize[0] <= $settings['iconPixels'] && $imgSize[1] <= $settings['iconPixels']) {
						$Db1->query("UPDATE ".$types[$type]." SET icon='".$result."' WHERE id='".addslashes($id)."' and username='".$username."'");
						$Db1->sql_close();
						header("Location: index.php?view=account&ac=view_".$type."&id=".$id."&".$url_variables."");
					} else {
						$includes[content]="Your icon is larger than 60x60!";
					}
				} else {
					$includes['content']="There was an error uploading your icon! Try checking your file extension type.";
				}
			}
			else {
				$includes[content]="
					".iif($ad['icon']!="","<strong>Current Icon:</strong><br /><img src=\"adicons/".$ad['icon']."\" /><hr />")."
					<strong>Upload New Icon</strong><br />
					<form enctype=\"multipart/form-data\" action=\"index.php?view=account&ac=edit_icon&action=upload&id=".$id."&type=".$type."&".$url_variables."\" method=\"post\">
						<input type=\"file\" name=\"userfile\"><br />
						<input type=\"submit\" value=\"Upload New Icon\"><br />
						Accepted File Formats: .jpg, .jpeg, .gif, .png<br />
						Your icon must be smaller than ".$settings['iconPixels']."x".$settings['iconPixels'].".
					</form>
					";
			}
		}
		else {
			$includes[content]="The icon addon was not purchased for this ad!";
		}
	}
	else {
		$includes[content]="The ad you are trying to edit cannot be found!";
	}
} else $includes[content]="Ad icons not enabled!";


?>