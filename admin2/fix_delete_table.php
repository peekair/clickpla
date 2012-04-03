<?
/*
Delete User Error Fix!
----------------------
place this file in the admin2/ directory and then access it from admin

admin.php?view=admin&ac=fix_delete_table


*/


	function checkList($field, $user_deleted) {
		for($x=0; $x<count($user_deleted); $x++) {
			if($field == $user_deleted[$x]) return true;
		}
		return false;
	}

		$results .= "Checking deleted user table<br />";
		$Dfields=$Db1->get_fields("user_deleted");
		for($y=0; $y<count($Dfields); $y++) {
			$temp=explode("^", $Dfields[$y]);
			$DfieldNames[$y] = $temp[0];
		}

		$fields=$Db1->get_fields("user");
		$results .= "Comparing to user table<br />";
		for($y=0; $y<count($fields); $y++) {
			$fields[$y] = str_replace("default ''"," ",$fields[$y]);
			$temp=explode("^", $fields[$y]);
			$fieldNames[$y] = $temp[0];
//			echo $temp[0]." : ";
			if(checkList($temp[0], $DfieldNames) == false) {
				$temp[0]="`".$temp[0]."`";
				$fields[$y]=implode("^", $temp);
//				$temp[0]="`".$temp[0]."`";
				$results .= "Adding Field: ".$temp[0]."<br />";
				$Db1->query("ALTER TABLE `user_deleted` ADD ".str_replace("^"," ",$fields[$y]).";");
			}
//			echo "<br />";
//			echo $fields[$y]."<br /><br />";
		}
		$results .= "Done!<br />";


$includes[content]=$results;


?>
