<?
include("./includes/functions.php");
//**S**//
define('backupDBversion', '1.1.27a');

include("./config.php");
include("./includes/settings.php");


// If any MySQL table errors occur, a notice will be sent here
define('ADMIN_EMAIL', $settings['admin_email']);
if (!defined('ADMIN_EMAIL') || (ADMIN_EMAIL == '')) {
	die('Please define ADMIN_EMAIL in '.__FILE__.' on line '.(__LINE__ - 2));
}



/////////////////////////////////////////////////////////////////////
//   You SHOULD modify these values:                               //
/////////////////////////////////////////////////////////////////////

// If DB_HOST, DB_USER and/or DB_PASS are undefined or empty,
// you will be prompted to enter them each time the script runs
define('DB_HOST', (isset($_REQUEST['DB_HOST']) ? $_REQUEST['DB_HOST'] : $DBHost)); // usually 'localhost'
define('DB_USER', (isset($_REQUEST['DB_USER']) ? $_REQUEST['DB_USER'] : $DBUser));  // MySQL username
define('DB_PASS', (isset($_REQUEST['DB_PASS']) ? $_REQUEST['DB_PASS'] : $DBPassword));  // MySQL password

// Only define DB_NAME if you want to restrict to ONLY this
// database, otherwise all accessible databases will be backed up
//if (!empty($_REQUEST['onlyDB'])) {
//	define('DB_NAME', $_REQUEST['onlyDB']);
//} else {
	// uncomment this line if you want to define a single database to back up
	// note: this may be required for some servers, where the user cannot list available databases

	define('DB_NAME', $DBDatabase);
//}



/////////////////////////////////////////////////////////////////////
//   You MAY modify these values (defaults should be fine too):    //
/////////////////////////////////////////////////////////////////////

define('BACKTICKCHAR',    '`');
define('QUOTECHAR',       '\'');
define('LINE_TERMINATOR', "\n");  // \n = UNIX; \r\n = Windows; \r = Mac
define('BUFFER_SIZE',     32768); // in bytes
define('TABLES_PER_COL',  30);    //
define('STATS_INTERVAL',  500);   // number of records processed between each DHTML stats refresh

$GZ_enabled         = (bool) function_exists('gzopen');

$DHTMLenabled       = true;  // set $DHTMLenabled = FALSE to prevent JavaScript errors in incompatible browsers
                             // set $DHTMLenabled = TRUE to get the nice DHTML display in IE 4.0+

$SuppressHTMLoutput = (@$_REQUEST['nohtml'] ? true : false); // disable all output for running as a cron job

$backuptimestamp    = '.'.date('Y-m-d'); // timestamp
if (!empty($_REQUEST['onlyDB'])) {
	$backuptimestamp = '.'.$_REQUEST['onlyDB'].$backuptimestamp;
}
//$backuptimestamp    = ''; // no timestamp
$backupabsolutepath = $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']).'/backups/'; // make sure to include trailing slash

//$backupabsolutepath="/usr/local/www/vhosts/banner-ranch-ptc.com/htdocs/backups/";

$fullbackupfilename = 'db_backup'.$backuptimestamp.'.sql'.($GZ_enabled ? '.gz' : '');
$partbackupfilename = 'db_backup_partial'.$backuptimestamp.'.sql'.($GZ_enabled ? '.gz' : '');
$strubackupfilename = 'db_backup_structure'.$backuptimestamp.'.sql'.($GZ_enabled ? '.gz' : '');
$tempbackupfilename = 'db_backup.temp.sql'.($GZ_enabled ? '.gz' : '');

$NeverBackupDBtypes = array('HEAP');

// Auto close the browser after the script finishes.
// This will allow task scheduler in Windows to work properly,
// else the task will be considered running until the browser is closed
$CloseWindowOnFinish = false;

/////////////////////////////////////////////////////////////////////
///////////////////       END CONFIGURATION       ///////////////////
/////////////////////////////////////////////////////////////////////









/////////////////////////////////////////////////////////////////////
///////////////////       SUPPORT FUNCTIONS       ///////////////////
/////////////////////////////////////////////////////////////////////

if (!function_exists('getmicrotime')) {
	function getmicrotime() {
		list($usec, $sec) = explode(' ', microtime());
		return ((float) $usec + (float) $sec);
	}
}

function FormattedTimeRemaining($seconds, $precision=1) {
	global $pwd;
	if ($seconds > 86400) {
		return number_format($seconds / 86400, $precision).' days';
	} elseif ($seconds > 3600) {
		return number_format($seconds / 3600, $precision).' hours';
	} elseif ($seconds > 60) {
		return number_format($seconds / 60, $precision).' minutes';
	}
	return number_format($seconds, $precision).' seconds';
}

function FileSizeNiceDisplay($filesize, $precision=2) {
	global $pwd;
	if ($filesize < 1000) {
		$sizeunit  = 'bytes';
		$precision = 0;
	} else {
		$filesize /= 1024;
		$sizeunit = 'kB';
	}
	if ($filesize >= 1000) {
		$filesize /= 1024;
		$sizeunit = 'MB';
	}
	if ($filesize >= 1000) {
		$filesize /= 1024;
		$sizeunit = 'GB';
	}
	return number_format($filesize, $precision).' '.$sizeunit;
}

function OutputInformation($id, $dhtml, $text='') {
	global $DHTMLenabled, $pwd;
	if ($DHTMLenabled) {
		if (!is_null($dhtml)) {
			if ($id) {
				echo '<script>if (document.getElementById("'.$id.'")) document.getElementById("'.$id.'").innerHTML="'.$dhtml.'"</script>';
			} else {
				echo $dhtml;
			}
			flush();
		}
	} else {
		if ($text) {
			echo $text;
			flush();
		}
	}
	return true;
}

function EmailAttachment($from, $to, $subject, $textbody, &$attachmentdata, $attachmentfilename) {
	global $pwd;
	$boundary = '_NextPart_'.time().'_'.md5($attachmentdata).'_';

	$textheaders  = '--'.$boundary."\n";
	$textheaders .= 'Content-Type: text/plain; format=flowed; charset="iso-8859-1"'."\n";
	$textheaders .= 'Content-Transfer-Encoding: 7bit'."\n\n";

	$attachmentheaders  = '--'.$boundary."\n";
	$attachmentheaders .= 'Content-Type: application/octet-stream; name="'.$attachmentfilename.'"'."\n";
	$attachmentheaders .= 'Content-Transfer-Encoding: base64'."\n";
	$attachmentheaders .= 'Content-Disposition: attachment; filename="'.$attachmentfilename.'"'."\n\n";

	$headers[] = 'From: '.$from;
	$headers[] = 'Content-Type: multipart/mixed; boundary="'.$boundary.'"';

	return mail($to, $subject, $textheaders.ereg_replace("[\x80-\xFF]", '?', $textbody)."\n\n".$attachmentheaders.wordwrap(base64_encode($attachmentdata), 76, "\n", true)."\n\n".'--'.$boundary."--\n\n", implode("\r\n", $headers));
}

/////////////////////////////////////////////////////////////////////
///////////////////     END SUPPORT FUNCTIONS     ///////////////////
/////////////////////////////////////////////////////////////////////




if ((!defined('DB_HOST') || (DB_HOST == '')) || (!defined('DB_USER') || (DB_USER == '')) || (!defined('DB_PASS') || (DB_PASS == ''))) {
	echo '<html><head><body><form action="'.$_SERVER['PHP_SELF'].'" method="post"><input type="hidden" name="pwd" value="'.$pwd.'">';
	echo 'database hostname: <input type="text" name="DB_HOST" value="'.(defined('DB_HOST') ? DB_HOST : 'localhost').'"><br />';
	echo 'database username: <input type="text" name="DB_USER" value="'.(defined('DB_USER') ? DB_USER : '').'"><br />';
	echo 'database password: <input type="text" name="DB_PASS" value="'.(defined('DB_PASS') ? DB_PASS : '').'"><br />';
	echo '<input type="submit" value="submit">';
	echo '</form></body></html>';
	exit;
}



if (!@mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
	mail(ADMIN_EMAIL, 'backupDB: FAILURE! Failed to connect to MySQL database', 'Failed to connect to SQL database in file '.@$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."\n".mysql_error());
	die('There was a problem connecting to the database:<br />'."\n".mysql_error());
}

if ($SuppressHTMLoutput) {
	ob_start();
}
//echo '<h4>MySQL database backup</h4>';
if (isset($StartBackup)) {
	OutputInformation('', '<span id="cancellink"><a href="'.$_SERVER['PHP_SELF'].'?pwd='.$pwd.'">Cancel</a><br /><br /></span>', '<a href="'.$_SERVER['PHP_SELF'].'?pwd='.$pwd.'">Cancel</a><br /><br />');
}
OutputInformation('', '<span id="statusinfo"></span>', 'DHTML display is disabled - you won\'t see anything until the backup is complete.');
flush();


$ListOfDatabasesToMaybeBackUp = array();
if (defined('DB_NAME')) {
	$ListOfDatabasesToMaybeBackUp[] = DB_NAME;
} else {
	$db_name_list = mysql_list_dbs();
	while (list($dbname) = mysql_fetch_array($db_name_list)) {
		$ListOfDatabasesToMaybeBackUp[] = $dbname;
	}
}



if ($StartBackup == 'partial') {
//if (isset($StartBackup) && ($StartBackup == 'partial')) {

	echo '<script language="JavaScript">'.LINE_TERMINATOR.'<!--'.LINE_TERMINATOR.'function CheckAll(checkornot) {'.LINE_TERMINATOR;
	echo 'for (var i = 0; i < document.SelectedTablesForm.elements.length; i++) {'.LINE_TERMINATOR;
	echo '  document.SelectedTablesForm.elements[i].checked = checkornot;'.LINE_TERMINATOR;
	echo '}'.LINE_TERMINATOR.'}'.LINE_TERMINATOR.'-->'.LINE_TERMINATOR.'</script>';

	echo '<form name="SelectedTablesForm" action="'.$_SERVER['PHP_SELF'].'" method="post"><input type="hidden" name="pwd" value="'.$pwd.'">';
	foreach ($ListOfDatabasesToMaybeBackUp as $dbname) {
		$tables = mysql_list_tables($dbname);
		if (is_resource($tables)) {
			echo '<table border="1"><tr><td colspan="'.ceil(mysql_num_rows($tables) / TABLES_PER_COL).'"><b>'.$dbname.'</b></td></tr><tr><td nowrap valign="top">';
			$tablecounter = 0;
			while (list($tablename) = mysql_fetch_array($tables)) {
				$TableStatusResult = mysql_query('SHOW TABLE STATUS LIKE "'.mysql_escape_string($tablename).'"');
				if ($TableStatusRow = mysql_fetch_array($TableStatusResult)) {
					if (in_array($TableStatusRow['Type'], $NeverBackupDBtypes)) {

						// no need to back up HEAP tables, and will generate errors if you try to optimize/repair

					} else {

						if ($tablecounter++ >= TABLES_PER_COL) {
							echo '</td><td nowrap valign="top">';
							$tablecounter = 0;
						}
						$SQLquery = 'SELECT COUNT(*) AS num FROM '.$tablename;
						mysql_select_db($dbname);
						$result = mysql_query($SQLquery);
						$row = @mysql_fetch_array($result);
						if (mysql_error()) {
							mail(ADMIN_EMAIL, 'backupDB: MySQL Error Report', mysql_error());
						}
						echo '<input type="checkbox" name="SelectedTables['.htmlentities($dbname, ENT_QUOTES).'][]" value="'.$tablename.'" checked>'.$tablename.' ('.$row['num'].')<br />';

					}
				}
			}
			echo '</td></tr></table><br />';
		}
	}
	if (isset($_POST['DB_HOST'])) {
		echo '<input type="hidden" name="DB_HOST" value="'.htmlspecialchars(@$_POST['DB_HOST'], ENT_QUOTES).'">';
		echo '<input type="hidden" name="DB_USER" value="'.htmlspecialchars(@$_POST['DB_USER'], ENT_QUOTES).'">';
		echo '<input type="hidden" name="DB_PASS" value="'.htmlspecialchars(@$_POST['DB_PASS'], ENT_QUOTES).'">';
	}
	echo '<input type="button" onClick="CheckAll(true)" value="Select All"> ';
	echo '<input type="button" onClick="CheckAll(false)" value="Deselect All"> ';
	echo '<input type="hidden" name="StartBackup" value="complete">';
	echo '<input type="submit" name="SelectedTablesOnly" value="Create Backup"></form>';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?pwd='.$pwd.'">Back to menu</a>';

} elseif (isset($StartBackup)) {

	if (($GZ_enabled && ($zp = @gzopen($backupabsolutepath.$tempbackupfilename, 'wb'))) ||
		(!$GZ_enabled && ($fp = @fopen($backupabsolutepath.$tempbackupfilename, 'wb')))) {

		$fileheaderline  = '# AuroraGPT Database Backup'.LINE_TERMINATOR;
		$fileheaderline .= '# mySQL backup ('.date('F j, Y g:i a').')   Type = ';
		if ($GZ_enabled) {
			gzwrite($zp, $fileheaderline, strlen($fileheaderline));
		} else {
			fwrite($fp, $fileheaderline, strlen($fileheaderline));
		}

		if ($StartBackup == 'structure') {

			if ($GZ_enabled) {
				gzwrite($zp, 'Structure Only'.LINE_TERMINATOR.LINE_TERMINATOR, strlen('Structure Only'.LINE_TERMINATOR.LINE_TERMINATOR));
			} else {
				fwrite($fp, 'Structure Only'.LINE_TERMINATOR.LINE_TERMINATOR, strlen('Structure Only'.LINE_TERMINATOR.LINE_TERMINATOR));
			}
			$backuptype = 'full';
			unset($SelectedTables);

			foreach ($ListOfDatabasesToMaybeBackUp as $dbname) {
				set_time_limit(60);
				$tables = mysql_list_tables($dbname);
				if (is_resource($tables)) {
					$tablecounter = 0;
					while (list($tablename) = mysql_fetch_array($tables)) {
						$TableStatusResult = mysql_query('SHOW TABLE STATUS LIKE "'.mysql_escape_string($tablename).'"');
						if ($TableStatusRow = mysql_fetch_array($TableStatusResult)) {
							if (in_array($TableStatusRow['Type'], $NeverBackupDBtypes)) {

								// no need to back up HEAP tables, and will generate errors if you try to optimize/repair

							} else {

								$SelectedTables[$dbname][] = $tablename;

							}
						}
					}
				}
			}

		} elseif (isset($SelectedTables) && is_array($SelectedTables)) {

			if ($GZ_enabled) {
				gzwrite($zp, 'Selected Tables Only'.LINE_TERMINATOR.LINE_TERMINATOR, strlen('Selected Tables Only'.LINE_TERMINATOR.LINE_TERMINATOR));
			} else {
				fwrite($fp, 'Selected Tables Only'.LINE_TERMINATOR.LINE_TERMINATOR, strlen('Selected Tables Only'.LINE_TERMINATOR.LINE_TERMINATOR));
			}
			$backuptype = 'partial';
			$SelectedTables = $SelectedTables;

		} else {

			if ($GZ_enabled) {
				gzwrite($zp, 'Complete'.LINE_TERMINATOR.LINE_TERMINATOR, strlen('Complete'.LINE_TERMINATOR.LINE_TERMINATOR));
			} else {
				fwrite($fp, 'Complete'.LINE_TERMINATOR.LINE_TERMINATOR, strlen('Complete'.LINE_TERMINATOR.LINE_TERMINATOR));
			}
			$backuptype = 'full';
			unset($SelectedTables);

			foreach ($ListOfDatabasesToMaybeBackUp as $dbname) {
				set_time_limit(60);
				$tables = mysql_list_tables($dbname);
				if (is_resource($tables)) {
					$tablecounter = 0;
					while (list($tablename) = mysql_fetch_array($tables)) {
						$TableStatusResult = mysql_query('SHOW TABLE STATUS LIKE "'.mysql_escape_string($tablename).'"');
						if ($TableStatusRow = mysql_fetch_array($TableStatusResult)) {
							if (in_array($TableStatusRow['Type'], $NeverBackupDBtypes)) {

								// no need to back up HEAP tables, and will generate errors if you try to optimize/repair

							} else {

								$SelectedTables[$dbname][] = $tablename;

							}
						}
					}
				}
			}

		}

		$starttime = getmicrotime();
		OutputInformation('', null, 'Checking tables...<br /><br />');
		$TableErrors = array();
		foreach ($SelectedTables as $dbname => $selectedtablesarray) {
			mysql_select_db($dbname);
			$repairresult = '';
			$CanContinue = true;
			foreach ($selectedtablesarray as $selectedtablename) {
				OutputInformation('statusinfo', 'Checking table <b>'.$dbname.'.'.$selectedtablename.'</b>');
				$result = mysql_query('CHECK TABLE '.$selectedtablename);
				while ($row = mysql_fetch_array($result)) {
					set_time_limit(60);
					if ($row['Msg_text'] == 'OK') {

						mysql_query('OPTIMIZE TABLE '.$selectedtablename);

					} else {

						OutputInformation('statusinfo', 'Repairing table <b>'.$selectedtablename.'</b>');
						$repairresult .= 'REPAIR TABLE '.$selectedtablename.' EXTENDED'."\n\n";
						$fixresult = mysql_query('REPAIR TABLE '.$selectedtablename.' EXTENDED');
						$ThisCanContinue = false;
						while ($fixrow = mysql_fetch_array($fixresult)) {
							$repairresult .= $fixrow['Msg_type'].': '.$fixrow['Msg_text']."\n";
							if (($fixrow['Msg_type'] == 'status') && ($fixrow['Msg_text'] == 'OK')) {
								$ThisCanContinue = true;
							}
						}
						if (!$ThisCanContinue) {
							$CanContinue = false;
						}

						$repairresult .= "\n\n".str_repeat('-', 60)."\n\n";

					}
				}
			}

			if (!empty($repairresult)) {
				mail(ADMIN_EMAIL, 'backupDB: MySQL Table Error Report', $repairresult);
				echo '<pre>'.$repairresult.'</pre>';
				if (!$CanContinue) {
					if ($SuppressHTMLoutput) {
						ob_end_clean();
						echo 'errors';
					}
					exit;
				}
			}
		}
		OutputInformation('statusinfo', '');

		OutputInformation('', '<br /><b><span id="topprogress">Overall Progress:</span></b><br />');
		$overallrows = 0;
		foreach ($SelectedTables as $dbname => $value) {
			mysql_select_db($dbname);
			echo '<table border="1"><tr><td colspan="'.ceil(count($SelectedTables[$dbname]) / TABLES_PER_COL).'"><b>'.$dbname.'</b></td></tr><tr><td nowrap valign="top">';
			$tablecounter = 0;
			for ($t = 0; $t < count($SelectedTables[$dbname]); $t++) {
				if ($tablecounter++ >= TABLES_PER_COL) {
					echo '</td><td nowrap valign="top">';
					$tablecounter = 1;
				}
				$SQLquery = 'SELECT COUNT(*) AS num FROM '.$SelectedTables[$dbname][$t];
				$result = mysql_query($SQLquery);
				$row = mysql_fetch_array($result);
				$rows[$t] = $row['num'];
				$overallrows += $rows[$t];
				echo '<span id="rows_'.$dbname.'_'.$SelectedTables[$dbname][$t].'">'.$SelectedTables[$dbname][$t].' ('.number_format($rows[$t]).' records)</span><br />';
			}
			echo '</td></tr></table><br />';
		}

		$alltablesstructure = '';
		foreach ($SelectedTables as $dbname => $value) {
			mysql_select_db($dbname);
			for ($t = 0; $t < count($SelectedTables[$dbname]); $t++) {
				set_time_limit(60);
				OutputInformation('statusinfo', 'Creating structure for <b>'.$dbname.'.'.$SelectedTables[$dbname][$t].'</b>');

				$fieldnames     = array();
				$structurelines = array();
				$result = mysql_query('SHOW FIELDS FROM '.BACKTICKCHAR.$SelectedTables[$dbname][$t].BACKTICKCHAR);
				while ($row = mysql_fetch_array($result)) {
					$structureline  = BACKTICKCHAR.$row['Field'].BACKTICKCHAR;
					$structureline .= ' '.$row['Type'];
					$structureline .= ' '.($row['Null'] ? '' : 'NOT ').'NULL';
					if (isset($row['Default'])) {
						switch ($row['Type']) {
							case 'tinytext':
							case 'tinyblob':
							case 'text':
							case 'blob':
							case 'mediumtext':
							case 'mediumblob':
							case 'longtext':
							case 'longblob':
								// no default values
								break;
							default:
								$structureline .= ' default \''.$row['Default'].'\'';
								break;
						}
					}
					$structureline .= ($row['Extra'] ? ' '.$row['Extra'] : '');
					$structurelines[] = $structureline;

					$fieldnames[] = $row['Field'];
				}
				mysql_free_result($result);

				$tablekeys    = array();
				$uniquekeys   = array();
				$fulltextkeys = array();
				$result = mysql_query('SHOW KEYS FROM '.BACKTICKCHAR.$SelectedTables[$dbname][$t].BACKTICKCHAR);
				while ($row = mysql_fetch_array($result)) {
					$uniquekeys[$row['Key_name']]   = (bool) ($row['Non_unique'] == 0);
					if (isset($row['Index_type'])) {
						$fulltextkeys[$row['Key_name']] = (bool) ($row['Index_type'] == 'FULLTEXT');
					} elseif (@$row['Comment'] == 'FULLTEXT') {
						$fulltextkeys[$row['Key_name']] = true;
					} else {
						$fulltextkeys[$row['Key_name']] = false;
					}
					$tablekeys[$row['Key_name']][$row['Seq_in_index']] = $row['Column_name'];
					ksort($tablekeys[$row['Key_name']]);
				}
				mysql_free_result($result);
				foreach ($tablekeys as $keyname => $keyfieldnames) {
					$structureline  = '';
					if ($keyname == 'PRIMARY') {
						$structureline .= 'PRIMARY KEY';
					} else {
						if ($fulltextkeys[$keyname]) {
							$structureline .= 'FULLTEXT ';
						} elseif ($uniquekeys[$keyname]) {
							$structureline .= 'UNIQUE ';
						}
						$structureline .= 'KEY '.BACKTICKCHAR.$keyname.BACKTICKCHAR;
					}
					$structureline .= ' ('.BACKTICKCHAR.implode(BACKTICKCHAR.','.BACKTICKCHAR, $keyfieldnames).BACKTICKCHAR.')';
					$structurelines[] = $structureline;
				}


				$TableStatusResult = mysql_query('SHOW TABLE STATUS LIKE "'.mysql_escape_string($SelectedTables[$dbname][$t]).'"');
				if (!($TableStatusRow = mysql_fetch_array($TableStatusResult))) {
					die('failed to execute "SHOW TABLE STATUS" on '.$dbname.'.'.$tablename);
				}

				$tablestructure  = 'CREATE TABLE '.BACKTICKCHAR.$dbname.BACKTICKCHAR.'.'.BACKTICKCHAR.$SelectedTables[$dbname][$t].BACKTICKCHAR.' ('.LINE_TERMINATOR;
				$tablestructure .= '  '.implode(','.LINE_TERMINATOR.'  ', $structurelines).LINE_TERMINATOR;
				$tablestructure .= ') TYPE='.$TableStatusRow['Type'];
				if ($TableStatusRow['Auto_increment'] !== null) {
					$tablestructure .= ' AUTO_INCREMENT='.$TableStatusRow['Auto_increment'];
				}
				$tablestructure .= ';'.LINE_TERMINATOR.LINE_TERMINATOR;

				$alltablesstructure .= str_replace(' ,', ',', $tablestructure);

			} // end table structure backup
		}
		if ($GZ_enabled) {
			gzwrite($zp, $alltablesstructure.LINE_TERMINATOR, strlen($alltablesstructure) + strlen(LINE_TERMINATOR));
		} else {
			fwrite($fp, $alltablesstructure.LINE_TERMINATOR, strlen($alltablesstructure) + strlen(LINE_TERMINATOR));
		}

		OutputInformation('statusinfo', '');
		if ($StartBackup != 'structure') {
			$processedrows    = 0;
			foreach ($SelectedTables as $dbname => $value) {
				set_time_limit(60);
				mysql_select_db($dbname);
				for ($t = 0; $t < count($SelectedTables[$dbname]); $t++) {
					$result = mysql_query('SELECT * FROM '.$SelectedTables[$dbname][$t]);
					$rows[$t] = mysql_num_rows($result);
					if ($rows[$t] > 0) {
						$tabledatadumpline = '# dumping data for '.$dbname.'.'.$SelectedTables[$dbname][$t].LINE_TERMINATOR;
						if ($GZ_enabled) {
							gzwrite($zp, $tabledatadumpline, strlen($tabledatadumpline));
						} else {
							fwrite($fp, $tabledatadumpline, strlen($tabledatadumpline));
						}
					}
					unset($fieldnames);
					for ($i = 0; $i < mysql_num_fields($result); $i++) {
						$fieldnames[] = mysql_field_name($result, $i);
					}
					if ($StartBackup == 'complete') {
						$insertstatement = 'INSERT INTO '.BACKTICKCHAR.$SelectedTables[$dbname][$t].BACKTICKCHAR.' ('.BACKTICKCHAR.implode(BACKTICKCHAR.', '.BACKTICKCHAR, $fieldnames).BACKTICKCHAR.') VALUES (';
					} else {
						$insertstatement = 'INSERT INTO '.BACKTICKCHAR.$SelectedTables[$dbname][$t].BACKTICKCHAR.' VALUES (';
					}
					$currentrow       = 0;
					$thistableinserts = '';
					while ($row = mysql_fetch_array($result)) {
						unset($valuevalues);
						foreach ($fieldnames as $key => $val) {
							if ($row[$key] === null) {
								$valuevalues[] = 'NULL';
							} else {
								$valuevalues[] = QUOTECHAR.mysql_escape_string($row[$key]).QUOTECHAR;
							}
						}
						$thistableinserts .= $insertstatement.implode(', ', $valuevalues).');'.LINE_TERMINATOR;

						if (strlen($thistableinserts) >= BUFFER_SIZE) {
							if ($GZ_enabled) {
								gzwrite($zp, $thistableinserts, strlen($thistableinserts));
							} else {
								fwrite($fp, $thistableinserts, strlen($thistableinserts));
							}
							$thistableinserts = '';
						}
						if ((++$currentrow % STATS_INTERVAL) == 0) {
							set_time_limit(60);
							if ($DHTMLenabled) {
								OutputInformation('rows_'.$dbname.'_'.$SelectedTables[$dbname][$t], '<b>'.$SelectedTables[$dbname][$t].' ('.number_format($rows[$t]).' records, ['.number_format(($currentrow / $rows[$t])*100).'%])</b>');
								$elapsedtime = getmicrotime() - $starttime;
								$percentprocessed = ($processedrows + $currentrow) / $overallrows;
								$overallprogress = 'Overall Progress: '.number_format($processedrows + $currentrow).' / '.number_format($overallrows).' ('.number_format($percentprocessed * 100, 1).'% done) ['.FormattedTimeRemaining($elapsedtime).' elapsed';
								if (($percentprocessed > 0) && ($percentprocessed < 1)) {
									$overallprogress .= ', '.FormattedTimeRemaining(abs($elapsedtime - ($elapsedtime / $percentprocessed))).' remaining';
								}
								$overallprogress .= ']';
								OutputInformation('topprogress', $overallprogress);
							}
						}
					}
					if ($DHTMLenabled) {
						OutputInformation('rows_'.$dbname.'_'.$SelectedTables[$dbname][$t], $SelectedTables[$dbname][$t].' ('.number_format($rows[$t]).' records, [100%])');
						$processedrows += $rows[$t];
					}
					if ($GZ_enabled) {
						gzwrite($zp, $thistableinserts.LINE_TERMINATOR.LINE_TERMINATOR, strlen($thistableinserts) + strlen(LINE_TERMINATOR) + strlen(LINE_TERMINATOR));
					} else {
						fwrite($fp, $thistableinserts.LINE_TERMINATOR.LINE_TERMINATOR, strlen($thistableinserts) + strlen(LINE_TERMINATOR) + strlen(LINE_TERMINATOR));
					}
				}
			}
		}
		if ($GZ_enabled) {
			gzclose($zp);
		} else {
			fclose($fp);
		}

		if ($StartBackup == 'structure') {
			$newfullfilename = $backupabsolutepath.$strubackupfilename;
		} elseif ($backuptype == 'full') {
			$newfullfilename = $backupabsolutepath.$fullbackupfilename;
		} else {
			$newfullfilename = $backupabsolutepath.$partbackupfilename;
		}

		if (file_exists($newfullfilename)) {
			unlink($newfullfilename); // Windows won't allow overwriting via rename
		}
		rename($backupabsolutepath.$tempbackupfilename, $newfullfilename);
		if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN') {
			touch($newfullfilename);
			if (!chmod($newfullfilename, 0777)) {
				mail(ADMIN_EMAIL, 'backupDB: Failed to chmod()', 'Failed to chmod('.$newfullfilename.', 0777)');
			}
		}

		if (@$_REQUEST['mailto']) {
			if (version_compare(phpversion(), '4.3.2', '>=') && !defined('memory_get_usage') && !@ini_get('memory_limit')) {
				// no actual memory limit
				$maxfilesize = 2147483647; // 2GB arbitary limit
			} else {
				// set maxfilesize to 40% of memory limit to allow for
				$maxfilesize = round(max(intval(ini_get('memory_limit')), intval(get_cfg_var('memory_limit'))) * 1048576 * 0.4);
			}
			if (filesize($newfullfilename) <= $maxfilesize) {
				if ($fp = @fopen($newfullfilename, 'rb')) {
					$emailattachmentfiledata = fread($fp, filesize($newfullfilename));
					fclose($fp);
					if (!EmailAttachment(ADMIN_EMAIL, ADMIN_EMAIL, 'backupDB: '.basename($newfullfilename), 'backupDB: '.basename($newfullfilename), $emailattachmentfiledata, basename($newfullfilename))) {
						mail(ADMIN_EMAIL, 'backupDB: Failed to email attachment ['.basename($newfullfilename).']', 'Failed to email attachment ['.basename($newfullfilename).']');
					}
					unset($emailattachmentfiledata);
				} else {
					mail(ADMIN_EMAIL, 'backupDB: FAILED: @fopen("'.$newfullfilename.'", "rb")', 'FAILED: @fopen("'.$newfullfilename.'", "rb")');
				}
			} else {
				mail(ADMIN_EMAIL, 'backupDB: Cannot email "'.$newfullfilename.'" (too large)', 'Cannot email "'.$newfullfilename.'" -- it is '.number_format(filesize($newfullfilename)).' bytes, which is more than the calculated maximum allowable size of '.number_format($maxfilesize).' bytes.');
			}
		}

		echo '<br />Backup complete in '.FormattedTimeRemaining(getmicrotime() - $starttime, 2).'.<br />';
		echo '<a href="'.str_replace($_SERVER['DOCUMENT_ROOT'].'//', '', $backupabsolutepath).basename($newfullfilename).'"><b>'.basename($newfullfilename).'</b> ('.FileSizeNiceDisplay(filesize($newfullfilename), 2);
		echo ')</a><br /><br /><a href="'.$_SERVER['PHP_SELF'].'?pwd='.$pwd.'">Back to main menu</a><br />';

		OutputInformation('cancellink', '');

	} else {

		echo '<b>Warning:</b> failed to open '.$backupabsolutepath.$tempbackupfilename.' for writing!<br /><br />';
		if (is_dir($backupabsolutepath)) {
			echo '<i>CHMOD 777</i> on the directory ('.htmlentities($backupabsolutepath).') should fix that.';
		} else {
			echo 'The specified directory does not exist: "'.htmlentities($backupabsolutepath).'"';
		}

	}

} else {  // !$StartBackup

	if (file_exists($backupabsolutepath.$fullbackupfilename)) {
//		echo 'It is now '.gmdate('F j, Y g:ia T', time() + date('Z')).'<br />';
		echo 'Last full backup of database:<br /><i> ';
		$lastbackuptime = filemtime($backupabsolutepath.$fullbackupfilename);
		echo gmdate('F j, Y g:ia T', $lastbackuptime + date('Z'));
		echo ' (<b>'.FormattedTimeRemaining(time() - $lastbackuptime).'</b> ago)</i><br />';
		if ((time() - $lastbackuptime) < 86400) {
			echo 'Backing up the database more than once per day is not usually needed.<br />';
		}
		echo '<br /><a href="'.str_replace(@$_SERVER['DOCUMENT_ROOT']."//", '', $backupabsolutepath).$fullbackupfilename.'">Download previous full backup ('.FileSizeNiceDisplay(filesize($backupabsolutepath.$fullbackupfilename), 2).')</a> (right-click, Save As...)<br /><br />';
	} else {
		echo 'Last backup of database: <i>unknown</i><br />';
	}

	$BackupTypesList = array(
		'complete'  => 'Full backup, complete inserts (recommended)',
		'standard'  => 'Full backup, standard inserts (smaller)',
		'partial'   => 'Selected tables only (with complete inserts)',
		'structure' => 'Table structures only'
	);
	echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post"><input type="hidden" name="pwd" value="'.$pwd.'">';
	if (isset($_POST['DB_HOST'])) {
		echo '<input type="hidden" name="DB_HOST" value="'.htmlspecialchars(@$_POST['DB_HOST'], ENT_QUOTES).'">';
		echo '<input type="hidden" name="DB_USER" value="'.htmlspecialchars(@$_POST['DB_USER'], ENT_QUOTES).'">';
		echo '<input type="hidden" name="DB_PASS" value="'.htmlspecialchars(@$_POST['DB_PASS'], ENT_QUOTES).'">';
	}
	echo '<select name="StartBackup">';
	foreach ($BackupTypesList as $key => $value) {
		echo '<option value="'.$key.'">'.htmlentities($value).'</option>';;
	}
	echo '</select><br />';
	echo '<input type="checkbox" name="mailto">Email backup file to admin email address ('.ADMIN_EMAIL.')<br />';
	echo '<input type="submit" value="Go">';
	echo '</form>';
}


if ($SuppressHTMLoutput) {
	ob_end_clean();
	echo 'done';
}


if ($CloseWindowOnFinish) {
	// Auto close the browser after the script finishes.
	// This will allow task scheduler in Windows to work properly,
	// else the task will be considered running until the browser is closed
	echo '<script language="javascript">'."\n";
	echo 'window.opener = top;'."\n";
	echo 'window.close();'."\n";
	echo '</script>';
}

//**E**//

?>
