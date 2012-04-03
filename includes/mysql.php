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
class DB_Sql {
	var $Host     = ""; // Hostname of our MySQL server.
	var $Database = ""; // Logical database name on that server.
	var $User     = ""; // User und Password for login.
	var $Password = "";

	var $Link_ID  = 0;  // Result of mysql_connect().
	var $Query_ID = 0;  // Result of most recent mysql_query().
	var $Record   = array();  // current mysql_fetch_array()-result.
	var $Row;           // current row number.

	var $Errno    = 0;  // error state of query...
	var $Error    = "";
	var $num_queries = 0;


	function halt($msg) {
		printf("</td></tr></table><b>Database error:</b> %s<br />\n", $msg);
		printf("<b>MySQL Error</b>: %s (%s)<br />\n",
		$this->Errno,
		$this->Error);
		die("Session halted.");
	}

	function connect($thehost, $thedb, $theuser, $thepwd) {
		$this->Host=$thehost;
		$this->Database=$thedb;
		$this->User=$theuser;
		$this->Password=$thepwd;

		if ( 0 == $this->Link_ID ) {
			$this->Link_ID=mysql_connect($this->Host, $this->User, $this->Password);
			if (!$this->Link_ID) {
				$this->halt("Link-ID == false, connect failed");
				return false;
			}
			if (!mysql_query(sprintf("use %s",$this->Database),$this->Link_ID)) {
				$this->halt("cannot use database ".$this->Database);
				return false;
			}
			return true;
		}
		return false;
	}

	function free_result($query_id=-1) {
		if ($query_id!=-1) {
			$this->query_id=$query_id;
		}
	}


	function fetch_array($query_id=-1,$query_string="") {
		if ($query_id!=-1) {
			$this->query_id=$query_id;
		}
		if ( isset($this->query_id) ) {
			$this->record = mysql_fetch_array($this->query_id);
		} else {
			if ( !empty($query_string) ) {
				$this->halt("Invalid query id (".$this->query_id.") on this query: $query_string");
			} else {
				$this->halt("Invalid query id ".$this->query_id." specified");
			}
		}
		return $this->record;
	}


	function query($Query_String) {
		//  $this->connect();
		$this->num_queries++;
		#printf("<br /><font color=red><b>Debug: query = %s</b></font><br />", $Query_String); // Use for debugging
		$this->Query_ID = mysql_query($Query_String,$this->Link_ID);
		$this->Row   = 0;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
		if (!$this->Query_ID) {
			$this->halt("Invalid SQL: ".$Query_String);
		}
		return $this->Query_ID;
	}


	function next_record() {
		$this->Record = mysql_fetch_array($this->Query_ID);
		$this->Row   += 1;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
		$stat = is_array($this->Record);
		if (!$stat) {
			mysql_free_result($this->Query_ID);
			$this->Query_ID = 0;
		}
		return $stat;
	}


	function seek($pos) {
		$status = mysql_data_seek($this->Query_ID, $pos);
		if ($status)
		$this->Row = $pos;
		return;
	}


	function num_rows() {
		return mysql_num_rows($this->Query_ID);
	}

	function num_fields() {
		return mysql_num_fields($this->Query_ID);
	}


	function f($Name) {
		return $this->Record[$Name];
	}

	function p($Name) {
		print $this->Record[$Name];
	}

	function affected_rows() {
		return @mysql_affected_rows($this->Link_ID);
	}



	function get_temps() {
		while ($row = mysql_fetch_array($this->Query_ID)) {
			$templ[$row["id"]] = $row['con'];
		}
		echo "$templ[1]<br />$templ[2]";
	}

	function get_temp() {
		return mysql_fetch_array($this->Query_ID);
	}

	function query_first($query_string) {
		// does a query and returns first row
		$query_id = $this->query($query_string);
		$returnarray=$this->fetch_array($query_id, $query_string);
		$this->free_result($query_id);
		return $returnarray;
	}


	function get_tables() {
		$tables = mysql_list_tables($this->Database);

		while ($row = mysql_fetch_row($tables)) {
			$return[] = "$row[0]";
		}
		return $return;
	}

	function querySingle($query, $value) {
		return arrayValue($this->fetch_array($this->query($query)),$value);
	}


	function get_fields($table) {
		$result = mysql_query("SHOW COLUMNS FROM $table");
		if (!$result) {
			$this->halt("Invalid SQL: Could not run query: " . mysql_error());
		}
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_assoc($result)) {
				$return[] = $row['Field']."^".
				iif($row['Type'],$row['Type']." ")." ".
				iif($row['Null']==0,"NOT NULL ","NULL ")." ".
				//					iif($row['Key'],$row['Key']." ")." ".
				"default '".$row['Default']."' ".
				iif($row['Extra'],$row['Extra']." ")."".

				iif(($row['Key'] == "PRI"), "*PRIMARY KEY (`".$row['Field']."`)").
				iif(($row['Key'] == "MUL"), "*KEY (`".$row['Field']."`)")
				;
			}
		}
		return $return;
	}


	function sql_close()
	{
		if($this->db_connect_id)
		{
			if($this->query_result)
			{
				@mysql_free_result($this->query_result);
			}
			$result = @mysql_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}



}






?>
