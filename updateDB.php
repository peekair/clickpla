<?

if(md5($pwd) != "4ec53a694c7530ffe86c2983a57f17ad") {
//	exit;
}

include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
include("includes/globals.php");

if($st == 1) {
	$sql=$Db1->query("SELECT * FROM settings");
	while($temp=$Db1->fetch_array($sql)) {
		$code .= "\"".addslashes($temp[title])."\" => \"".addslashes($temp[setting])."\",\n";
//		$settings['$temp[title]']=$temp[setting];
	}
}


function parse_code($code) {
	$code=stripslashes($code);
	$return = array();
	$tables=explode("#",$code);
	for($x=0; $x<count($tables); $x++) {
		$temp=explode(":",$tables[$x]);
		$return[$temp[0]]=array();
		$fields=explode("@",$temp[1]);
		for($y=0; $y<count($fields); $y++) {
			$temp2=explode("^", $fields[$y]);
			$return[$temp[0]][$y][0]=$temp2[0];
			$temp3=explode("*",$temp2[1]);
			$return[$temp[0]][$y][1]=$temp3[0];
			$return[$temp[0]][$y][2]=$temp3[1];
		}
	}
	return $return;
}


function findfield($field, $ftable, $tablearray) {
	$return = 0;
	foreach ($tablearray as $table => $fields){
		if($table == $ftable) {
			for($x=0; $x<count($fields); $x++){
				if($fields[$x][0] == $field) {
					$return = 1;
				}
			}
		}
	}
	return $return;
}

function findtable($look, $tablearray) {
	$return = 0;
	foreach ($tablearray as $table => $fields){
		if($table == $look) {
			$return = 1;
		}
	}
	return $return;
}


function update($code) {
	global $Db1;
	$new=parse_code($code);
	$old=parse_code(getcode());
	
//	echo print_r($new);
	echo "Updating...<br />";
	flush();
	foreach ($new as $table => $fields){
		if($table != "") {
			$return .= "Starting Table `$table`\n";
			echo "<!-- Starting Table `$table` ->";
			flush();
	//		echo "<br /><br /><b>$table</b>: ".findtable($table, $old);
			if(findtable($table, $old) == 0) {
				$return .= "`$table` Not Found!\n";
				$query ="CREATE TABLE `$table` (";
				$keys="";
				for($x=0; $x<count($fields); $x++){
					$keys.=iif($fields[$x][2]!="",",".$fields[$x][2]);
					$query .= iif($x!=0,",")."`".$fields[$x][0]."` ".$fields[$x][1]."";
				}
				$query .= "".$keys."";
				$query .= ");";
	//			echo $query;
				$Db1->query($query);
				$return .= " `$table` Was Created!\n";
			}
			else {
				$query="";
				$keys="";
				$missing=0;
				for($x=0; $x<count($fields); $x++){
					if(findfield($fields[$x][0], $table, $old) == 0) {
						$return .= " The Field `".$fields[$x][0]."` Was Not Found!\n";
						$query.= iif($missing!=0,", ")."ADD `".$fields[$x][0]."` ".$fields[$x][1]."";
						if($fields[$x][2]!="") {
							$fields[$x][2]=str_replace("KEY (`","",$fields[$x][2]);
							$fields[$x][2]=str_replace("PRIMARY","",$fields[$x][2]);
							$fields[$x][2]=str_replace("`)","",$fields[$x][2]);
							$keys.=iif($keys!="",", ")."`".$fields[$x][2]."`";
						}
	//					echo "<br /><li>".$fields[$x][0]." Not Found In Table $table!";
						$missing++;	
					}
		//			echo "<br />".$fields[$x][0].": ".findfield($fields[$x][0], $table, $old);
				}
				if($query != "") {
					$Db1->query("ALTER TABLE `$table` ".$query."");
					if($keys != "") {
						$Db1->query("ALTER TABLE `$table` ADD INDEX (".$keys.")");
					}
					$return .= " Updated Table Successfully!\n";
				}
		//		echo "".$keys."<br />";
			}
			$return .= "Finished Table `$table`\n\n";
		}
		else {
			$return .= "Error! Database Variable Is Empty!\n";
		}
	}
	return $return;
}

function getcode() {
	global $Db1;
	$tables = $Db1->get_tables();
	for($x=0; $x<count($tables); $x++) {
		$code.="".$tables[$x].":";
		$fields=$Db1->get_fields($tables[$x]);
		for($y=0; $y<count($fields); $y++) {
			$fields[$y] = str_replace("default ''"," ",$fields[$y]);
			$temp=explode("^", $fields[$y]);
			if($y < (count($fields)-1)) {
				$xtra="@";
			}
			else {
				$xtra="";
			}
			$code.="".$temp[0]."^".$temp[1].$xtra;
		}
		if($x < (count($tables)-1)) {
			$code.="#";
		}
	}
	return $code;
}


if($action == "getcode") {
	$code=getcode();
}




function getcode2() {
	global $Db1;
	$tables = $Db1->get_tables();
	$code.="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	$code.="<structure>\n";
	$unid=0;
	for($x=0; $x<count($tables); $x++) {
//		$code.="".$tables[$x].":";
		
		$fields=$Db1->get_fields($tables[$x]);
		$code.="\t<".$tables[$x].">\n";
		
		for($y=0; $y<count($fields); $y++) {
			$unid++;
			$fields[$y] = str_replace("default ''"," ",$fields[$y]);
			$temp=explode("^", $fields[$y]);
//			$code.="".$temp[0]."^".$temp[1].$xtra;
			$code.="\t\t<field".$y." name=\"".$temp[0]."\" pref=\"".trim($temp[1])."\" />\n";

		}
		$code.="\t</".$tables[$x].">\n\n";
		
		if($x < (count($tables)-1)) {
		//	$code.="#";
		}
	}
	$code.="</structure>";
	return $code;
}


if($action == "getcode2") {
	$code=getcode2();
}


$prefillTables = array(
	"admin_menu"=>"1",
	"admin_modules"=>"1",
	"user"=>"0",
	"withdraw_options"=>"0"
);
/*
admin_menu 1
admin_modules 1
user	0
withdraw_options	0

force=""
*/

function getcode3() {
	global $Db1, $prefillTables;
	$tables = $Db1->get_tables();
	$code.="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	$code.="<structure>\n";
	$unid=0;
	$unid2=0;
	for($x=0; $x<count($tables); $x++) {
//		$code.="".$tables[$x].":";
		
		$fields=$Db1->get_fields($tables[$x]);
		
		
		
		if(isset($prefillTables[$tables[$x]])) {
			$sql=$Db1->query("SELECT * FROM `".$tables[$x]."`");
			if($Db1->num_rows() > 0) {
				$code.="\t<".$tables[$x]." force=\"".$prefillTables[$tables[$x]]."\">\n";
				while($tmp = $Db1->fetch_array($sql)) {
					$unid2++;
					$code.="\t\t<row$unid2>\n";
					foreach($tmp as $k => $v) {
						if(!is_int($k)) {
							$unid++;
							$code.="\t\t\t<field".$unid." name=\"".$k."\" value=\"".trim(htmlentities(htmlspecialchars(stripslashes($v))))."\" />\n";
						}
					}
					$code.="\t\t</row$unid2>\n";
				}
				$code.="\t</".$tables[$x].">\n\n";
			}
		}
	}
	$code.="</structure>";
	return $code;
}


if($action == "getcode3") {
	$code=getcode3();
}


if($action == "update") {
	$code=update($code);
}

?>

<html>
<head>
	<title>Database Updater</title>
</head>
<body>


<div align="center">
<form action="updateDB.php?pwd=<? echo $pwd; ?>&action=update" method="post">
<textarea cols=90 rows=25 name="code"><? echo $code; ?></textarea><br />

<input type="button" value="Get Structure" onclick="location.href='updateDB.php?pwd=<? echo $pwd; ?>&action=getcode'">
<input type="submit" value="Update Database"<? if($action == "update") {echo "disabled=\"disabled\"";} ?>>
</form>
</div>
</body>
</html>
