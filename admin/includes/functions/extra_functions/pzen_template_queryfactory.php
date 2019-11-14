<?php
/**PZENTEMPLATE_BRAND**/

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
function pzen_exe_datafile(){
$current_page = basename($PHP_SELF);
if($current_page!='sqlpatch.php'){
  define('HEADING_TITLE','SQL Query Executor');
  define('HEADING_WARNING','BE SURE TO DO A FULL DATABASE BACKUP BEFORE RUNNING SCRIPTS HERE');
  define('HEADING_WARNING2','If you are installing 3rd-party contributions, note that you do so at your own risk.<br />Zen Cart&reg; makes no warranty as to the safety of scripts supplied by 3rd-party contributors. Test before using on your live database!');
  define('HEADING_WARNING_INSTALLSCRIPTS', 'NOTE: Zen Cart database-upgrade scripts should NOT be run from this page.<br />Please upload the new <strong>zc_install</strong> folder and run the upgrade from there instead for better reliability.');
  define('TEXT_QUERY_RESULTS','Query Results:');
  define('TEXT_ENTER_QUERY_STRING','Enter the query <br />to be executed:&nbsp;&nbsp;<br /><br />Be sure to<br />end with ;');
  define('TEXT_QUERY_FILENAME','Upload file:');
  define('ERROR_NOTHING_TO_DO','Error: Nothing to do - no query or query-file specified.');
  define('TEXT_CLOSE_WINDOW', '[ close window ]');
  define('SQLPATCH_HELP_TEXT','The SQLPATCH tool lets you install system patches by pasting SQL code directly into the textarea '.
                              'field here, or by uploading a supplied script (.SQL) file.<br />' .
                              'When preparing scripts to be used by this tool, DO NOT include a table prefix, as this tool will ' .
                              'automatically insert the required prefix for the active database, based on settings in the store\'s ' .
                              'admin/includes/configure.php file (DB_PREFIX definition).<br /><br />' .
                              'The commands entered or uploaded may only begin with the following statements, and MUST be in UPPERCASE:'.
                              '<br /><ul><li>DROP TABLE IF EXISTS</li><li>CREATE TABLE</li><li>INSERT INTO</li><li>INSERT IGNORE INTO</li><li>ALTER TABLE</li>' .
                              '<li>UPDATE (just a single table)</li><li>UPDATE IGNORE (just a single table)</li><li>DELETE FROM</li><li>DROP INDEX</li><li>CREATE INDEX</li>' .
                              '<br /><li>SELECT </li></ul>' .
'<h2>Advanced Methods</h2>The following methods can be used to issue more complex statements as necessary:<br />
To run some blocks of code together so that they are treated as one command by MySQL, you need the "<code>#NEXT_X_ROWS_AS_ONE_COMMAND:xxx</code>" value set.  The parser will then treat X number of commands as one.<br />
If you are running this file thru phpMyAdmin or equivalent, the "#NEXT..." comment is ignored, and the script will process fine.<br />
<br /><strong>NOTE: </strong>SELECT.... FROM... and LEFT JOIN statements need the "FROM" or "LEFT JOIN" to be on a line by itself in order for the parse script to add the table prefix.<br /><br />
<em><strong>Examples:</strong></em>
<ul><li><code>#NEXT_X_ROWS_AS_ONE_COMMAND:4<br />
SET @t1=0;<br />
SELECT (@t1:=configuration_value) as t1 <br />
FROM configuration <br />
WHERE configuration_key = \'KEY_NAME_HERE\';<br />
UPDATE product_type_layout SET configuration_value = @t1 WHERE configuration_key = \'KEY_NAME_TO_CHECK_HERE\';<br />
DELETE FROM configuration WHERE configuration_key = \'KEY_NAME_HERE\';<br />&nbsp;</li>

<li>#NEXT_X_ROWS_AS_ONE_COMMAND:1<br />
INSERT INTO tablename <br />
(col1, col2, col3, col4)<br />
SELECT col_a, col_b, col_3, col_4<br />
FROM table2;<br />&nbsp;</li>

<li>#NEXT_X_ROWS_AS_ONE_COMMAND:1<br />
INSERT INTO table1 <br />
(col1, col2, col3, col4 )<br />
SELECT p.othercol_a, p.othercol_b, po.othercol_c, pm.othercol_d<br />
FROM table2 p, table3 pm<br />
LEFT JOIN othercol_f po<br />
ON p.othercol_f = po.othercol_f<br />
WHERE p.othercol_f = pm.othercol_f;</li>
</ul></code>' );
  if (!defined('DB_PREFIX')) define('DB_PREFIX','');
  if (!defined('TABLE_UPGRADE_EXCEPTIONS')) define('TABLE_UPGRADE_EXCEPTIONS', DB_PREFIX . 'upgrade_exceptions');
  define('REASON_TABLE_ALREADY_EXISTS','Cannot create table %s because it already exists');
  define('REASON_TABLE_DOESNT_EXIST','Cannot drop table %s because it does not exist.');
  define('REASON_TABLE_NOT_FOUND','Cannot execute because table %s does not exist.');
  define('REASON_CONFIG_KEY_ALREADY_EXISTS','Cannot insert configuration_key "%s" because it already exists');
  define('REASON_COLUMN_ALREADY_EXISTS','Cannot ADD column %s because it already exists.');
  define('REASON_COLUMN_DOESNT_EXIST_TO_DROP','Cannot DROP column %s because it does not exist.');
  define('REASON_COLUMN_DOESNT_EXIST_TO_CHANGE','Cannot CHANGE column %s because it does not exist.');
  define('REASON_PRODUCT_TYPE_LAYOUT_KEY_ALREADY_EXISTS','Cannot insert prod-type-layout configuration_key "%s" because it already exists');
  define('REASON_INDEX_DOESNT_EXIST_TO_DROP','Cannot drop index %s on table %s because it does not exist.');
  define('REASON_PRIMARY_KEY_DOESNT_EXIST_TO_DROP','Cannot drop primary key on table %s because it does not exist.');
  define('REASON_INDEX_ALREADY_EXISTS','Cannot add index %s to table %s because it already exists.');
  define('REASON_PRIMARY_KEY_ALREADY_EXISTS','Cannot add primary key to table %s because a primary key already exists.');
  define('REASON_NO_PRIVILEGES','User '.DB_SERVER_USERNAME.'@'.DB_SERVER.' does not have %s privileges to database '.DB_DATABASE.'.');

  if (isset($_GET['debug']) && $_GET['debug']=='ON') $debug=true;
  if (!isset($_GET['debug'])  && !zen_not_null($_POST['debug']) && $debug!=true)  define('ZC_UPG_DEBUG',false);
  if (!isset($_GET['debug2']) && !zen_not_null($_POST['debug2']) && $debug!=true) define('ZC_UPG_DEBUG2',false);
  if (!isset($_GET['debug3']) && !zen_not_null($_POST['debug3']) && $debug!=true) define('ZC_UPG_DEBUG3',false);

  $keepslashes = (isset($_GET['keepslashes']) && ($_GET['keepslashes']=='1' || $_GET['keepslashes']=='true')) ? true : false;
}  
//NOTE: THIS IS INTENTIONALLY ON 2 LINES:
$linebreak = '
';
// NOTE: this line break is intentional!!!!
function pzen_executeSql($sql_file, $database, $table_prefix = '', $isupgrade=false) {
  $debug=false;
  if (!defined('DB_PREFIX')) define('DB_PREFIX', $table_prefix);
  global $db;

  $ignored_count=0;
  $ignore_line=false;
  $results=0;
  $string='';
  $result='';
  $collateSuffix = '';
  $errors=array();

  // prepare for upgrader processing
  if ($isupgrade) zen_create_upgrader_table(); // only creates table if doesn't already exist

  if (version_compare(PHP_VERSION, 5.4, '>=') || !get_cfg_var('safe_mode')) {
    @set_time_limit(1200);
  }

  $counter = 0;
  $lines = file($sql_file);
  $newline = '';
  $lines_to_keep_together_counter=0;
  
//  $saveline = '';
  foreach ($lines as $line) {
    $line = trim($line);
//    $line = $saveline . $line;
    $keep_together = 1; // count of number of lines to treat as a single command

     // split the line into words ... starts at $param[0] and so on.  Also remove the ';' from end of last param if exists
     $param=explode(" ",(substr($line,-1)==';') ? substr($line,0,strlen($line)-1) : $line);
     if (!isset($param[4])) $param[4] = '';
     if (!isset($param[5])) $param[5] = '';

      // The following command checks to see if we're asking for a block of commands to be run at once.
      // Syntax: #NEXT_X_ROWS_AS_ONE_COMMAND:6     for running the next 6 commands together (commands denoted by a ;)
      if (substr($line,0,28) == '#NEXT_X_ROWS_AS_ONE_COMMAND:') $keep_together = substr($line,28);
      if (substr($line,0,1) != '#' && substr($line,0,1) != '-' && $line != '') {
//        if ($table_prefix != -1) {
//echo '*}'.$line.'<br>';

          $line_upper=strtoupper($line);
          switch (true) {
          case (substr($line_upper, 0, 21) == 'DROP TABLE IF EXISTS '):
            $line = 'DROP TABLE IF EXISTS ' . $table_prefix . substr($line, 21);
            break;
          case (substr($line_upper, 0, 11) == 'DROP TABLE ' && $param[2] != 'IF'):
            if (!$checkprivs = pzen_check_database_privs('DROP')) $result=sprintf(REASON_NO_PRIVILEGES,'DROP');
            if (!pzen_table_exists($param[2]) || zen_not_null($result)) {
              pzen_write_to_upgrade_exceptions_table($line, (zen_not_null($result) ? $result : sprintf(REASON_TABLE_DOESNT_EXIST,$param[2])), $sql_file);
              $ignore_line=true;
              $result=(zen_not_null($result) ? $result : sprintf(REASON_TABLE_DOESNT_EXIST,$param[2])); //duplicated here for on-screen error-reporting
              break;
            } else {
              $line = 'DROP TABLE ' . $table_prefix . substr($line, 11);
            }
            break;
          case (substr($line_upper, 0, 13) == 'CREATE TABLE '):
            // check to see if table exists
            $table = (strtoupper($param[2].' '.$param[3].' '.$param[4]) == 'IF NOT EXISTS') ? $param[5] : $param[2];
            $result=pzen_table_exists($table);
            if ($result==true) {
              $ignore_line=true;
              if (strtoupper($param[2].' '.$param[3].' '.$param[4]) != 'IF NOT EXISTS') {
                pzen_write_to_upgrade_exceptions_table($line, sprintf(REASON_TABLE_ALREADY_EXISTS,$table), $sql_file);
                $result=sprintf(REASON_TABLE_ALREADY_EXISTS,$table); //duplicated here for on-screen error-reporting
              }
              break;
            } else {
              $line = (strtoupper($param[2].' '.$param[3].' '.$param[4]) == 'IF NOT EXISTS') ? 'CREATE TABLE IF NOT EXISTS ' . $table_prefix . substr($line, 27) : 'CREATE TABLE ' . $table_prefix . substr($line, 13);
              $collateSuffix = (strtoupper($param[3]) == 'AS' || (isset($param[6]) && strtoupper($param[6]) == 'AS')) ? '' : ' COLLATE ' . DB_CHARSET . '_general_ci';
            }
            break;
          case (substr($line_upper, 0, 13) == 'REPLACE INTO '):
            //check to see if table prefix is going to match
            if (!$tbl_exists = pzen_table_exists($param[2])) $result=sprintf(REASON_TABLE_NOT_FOUND,$param[2]).' CHECK PREFIXES!';
            // check to see if INSERT command may be safely executed for "configuration" or "product_type_layout" tables
            if (($param[2]=='configuration'       && ($result=pzen_check_config_key($line))) or
                ($param[2]=='product_type_layout' && ($result=pzen_check_product_type_layout_key($line))) or
                ($param[2]=='configuration_group' && ($result=pzen_check_cfggroup_key($line))) or
                (!$tbl_exists)    ) {
              pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'REPLACE INTO ' . $table_prefix . substr($line, 13);
            }
            break;
          case (substr($line_upper, 0, 12) == 'INSERT INTO '):
            //check to see if table prefix is going to match
            if (!$tbl_exists = pzen_table_exists($param[2])) $result=sprintf(REASON_TABLE_NOT_FOUND,$param[2]).' CHECK PREFIXES!';
            // check to see if INSERT command may be safely executed for "configuration" or "product_type_layout" tables
            if (($param[2]=='configuration'       && ($result=pzen_check_config_key($line))) or
                ($param[2]=='product_type_layout' && ($result=pzen_check_product_type_layout_key($line))) or
                ($param[2]=='configuration_group' && ($result=pzen_check_cfggroup_key($line))) or
                (!$tbl_exists)    ) {
              pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'INSERT INTO ' . $table_prefix . substr($line, 12);
            }
            break;
          case (substr($line_upper, 0, 19) == 'INSERT IGNORE INTO '):
            //check to see if table prefix is going to match
            if (!$tbl_exists = pzen_table_exists($param[3])) {
              $result=sprintf(REASON_TABLE_NOT_FOUND,$param[3]).' CHECK PREFIXES!';
              pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'INSERT IGNORE INTO ' . $table_prefix . substr($line, 19);
            }
            break;
            case (substr($line_upper, 0, 19) == 'ALTER IGNORE TABLE '):
            // check to see if ALTER IGNORE command may be safely executed
            if ($result=pzen_check_alter_command($param)) {
              pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'ALTER IGNORE TABLE ' . $table_prefix . substr($line, 19);
            }
            break;
            case (substr($line_upper, 0, 12) == 'ALTER TABLE '):
            //if (ZC_UPG_DEBUG3==true) echo 'ALTER -- Table check ('.$param[2].')' .'<br>';
            // check to see if ALTER command may be safely executed
            if ($result=pzen_check_alter_command($param)) {
              pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'ALTER TABLE ' . $table_prefix . substr($line, 12);
            }
            break;
          case (substr($line_upper, 0, 15) == 'TRUNCATE TABLE '):
            // check to see if TRUNCATE command may be safely executed
            if (!$tbl_exists = pzen_table_exists($param[2])) {
              $result=sprintf(REASON_TABLE_NOT_FOUND,$param[3]).' CHECK PREFIXES!';
              pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'TRUNCATE TABLE ' . $table_prefix . substr($line, 15);
            }
            break;
          case (substr($line_upper, 0, 13) == 'RENAME TABLE '):
            // RENAME TABLE command cannot be parsed unless it is split into two lines
            if (isset($param[3]) && $param[3] != '') {
              pzen_write_to_upgrade_exceptions_table($line, 'RENAME TABLE command must be split onto 2 rows for proper parsing.  Or use phpMyAdmin instead.', $sql_file);
              $result=sprintf('RENAME TABLE [%s] command must be split onto 2 rows for proper parsing.',$param[2]).' CHECK PREFIXES!';
              $ignore_line=true;
            }
            //check to see if table prefix is going to match
            if (!$tbl_exists = pzen_table_exists($param[2])) {
              pzen_write_to_upgrade_exceptions_table($line, sprintf(REASON_TABLE_NOT_FOUND,$param[2]).' CHECK PREFIXES!', $sql_file);
              $result=sprintf('RENAME TABLE problem: ' . REASON_TABLE_NOT_FOUND,$param[2]).' CHECK PREFIXES!';
              $ignore_line=true;
              break;
            } else {
              $line = 'RENAME TABLE ' . $table_prefix . substr($line, 13);
            }
            break;
          case (substr($line_upper, 0, 3) == 'TO '):
            if (!isset($param[1]) || $param[1] == '') {
              pzen_write_to_upgrade_exceptions_table($line, 'RENAME TABLE command must be split onto 2 rows (with TO clause on 2nd line) for proper parsing.  Or use phpMyAdmin instead.', $sql_file);
              $result=sprintf('RENAME TABLE problem: %s' ,$param[1]).' CHECK PREFIXES!';
              $ignore_line=true;
            } else {
              $line = 'TO ' . $table_prefix . substr($line, 3);
            }
            break;
          case (substr($line_upper, 0, 7) == 'UPDATE '):
            //check to see if table prefix is going to match
            if (!$tbl_exists = pzen_table_exists($param[1])) {
              pzen_write_to_upgrade_exceptions_table($line, sprintf(REASON_TABLE_NOT_FOUND,$param[1]).' CHECK PREFIXES!', $sql_file);
              $result=sprintf(REASON_TABLE_NOT_FOUND,$param[1]).' CHECK PREFIXES!';
              $ignore_line=true;
              break;
            } else {
              $line = 'UPDATE ' . $table_prefix . substr($line, 7);
            }
            break;
          case (substr($line_upper, 0, 14) == 'UPDATE IGNORE '):
            //check to see if table prefix is going to match
            if (!$tbl_exists = pzen_table_exists($param[2])) {
              pzen_write_to_upgrade_exceptions_table($line, sprintf(REASON_TABLE_NOT_FOUND,$param[2]).' CHECK PREFIXES!', $sql_file);
              $result=sprintf(REASON_TABLE_NOT_FOUND,$param[2]).' CHECK PREFIXES!';
              $ignore_line=true;
              break;
            } else {
              $line = 'UPDATE IGNORE ' . $table_prefix . substr($line, 14);
            }
            break;
          case (substr($line_upper, 0, 12) == 'DELETE FROM '):
            $line = 'DELETE FROM ' . $table_prefix . substr($line, 12);
            break;
          case (substr($line_upper, 0, 11) == 'DROP INDEX '):
            // check to see if DROP INDEX command may be safely executed
            if ($result=pzen_drop_index_command($param)) {
// ignore alerting about non-existing indexes to drop
//               pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              $line = 'DROP INDEX ' . $param[2] . ' ON ' . $table_prefix . $param[4];
            }
            break;
          case (substr($line_upper, 0, 13) == 'CREATE INDEX ' || (strtoupper($param[0])=='CREATE' && strtoupper($param[2])=='INDEX')):
            // check to see if CREATE INDEX command may be safely executed
            if ($result=pzen_create_index_command($param)) {
              pzen_write_to_upgrade_exceptions_table($line, $result, $sql_file);
              $ignore_line=true;
              break;
            } else {
              if (strtoupper($param[1])=='INDEX') {
                $line = trim('CREATE INDEX ' . $param[2] .' ON '. $table_prefix . implode(' ',array($param[4],$param[5],$param[6],$param[7],$param[8],$param[9],$param[10],$param[11],$param[12],$param[13])) ).';'; // add the ';' back since it was removed from $param at start
              } else {
                $line = trim('CREATE '. $param[1] .' INDEX ' .$param[3]. ' ON '. $table_prefix . implode(' ',array($param[5],$param[6],$param[7],$param[8],$param[9],$param[10],$param[11],$param[12],$param[13])) ); // add the ';' back since it was removed from $param at start
              }
            }
            break;
          case (substr($line_upper, 0, 7) == 'SELECT ' && substr_count($line,'FROM ')>0):
            $line = str_replace('FROM ','FROM '. $table_prefix, $line);
            break;
          case (substr($line_upper, 0, 10) == 'LEFT JOIN '):
            $line = 'LEFT JOIN ' . $table_prefix . substr($line, 10);
            break;
          case (substr($line_upper, 0, 5) == 'FROM '):
            if (substr_count($line,',')>0) { // contains FROM and a comma, thus must parse for multiple tablenames
              $tbl_list = explode(',',substr($line,5));
              $line = 'FROM ';
              foreach($tbl_list as $val) {
                $line .= $table_prefix . trim($val) . ','; // add prefix and comma
              } //end foreach
              if (substr($line,-1)==',') $line = substr($line,0,(strlen($line)-1)); // remove trailing ','
            } else { //didn't have a comma, but starts with "FROM ", so insert table prefix
              $line = str_replace('FROM ', 'FROM '.$table_prefix, $line);
            }//endif substr_count(,)
            break;
          default:
            break;
          } //end switch
//        } // endif $table_prefix
        $newline .= $line . ' ';

        if ( substr($line,-1) ==  ';') {
          //found a semicolon, so treat it as a full command, incrementing counter of rows to process at once
          if (substr($newline,-1)==' ') $newline = substr($newline,0,(strlen($newline)-1));
          $lines_to_keep_together_counter++;
          if ($lines_to_keep_together_counter == $keep_together) { // if all grouped rows have been loaded, go to execute.
            $complete_line = true;
            $lines_to_keep_together_counter=0;
            if ($collateSuffix != '' && @mysqli_get_server_info() >= '4.1' && (!defined('IGNORE_DB_CHARSET') || (defined('IGNORE_DB_CHARSET') && IGNORE_DB_CHARSET != FALSE))) {
              $newline = rtrim($newline, ';') . $collateSuffix . ';';
              $collateSuffix = '';
            }
          } else {
            $complete_line = false;
          }
        } //endif found ';'

        if ($complete_line) {
          if ($debug==true) echo ((!$ignore_line) ? '<br /><strong>About to execute.</strong>': '<strong>Ignoring statement. This command WILL NOT be executed.</strong>').'<br />Debug info:<br />$ line='.$line.'<br />$ complete_line='.$complete_line.'<br>$ keep_together='.$keep_together.'<br />SQL='.$newline.'<br /><br />';
          if (get_magic_quotes_runtime() > 0) $newline=stripslashes($newline);
          $output = (trim(str_replace(';','',$newline)) != '' && !$ignore_line) ? $db->Execute($newline) : '';
          $results++;
          $string .= $newline.'<br />';
          $return_output[]=$output;
          if (zen_not_null($result) && !pzen_check_exceptions($result, $line) ) $errors[]=$result;
          // reset var's
          $newline = '';
          $keep_together=1;
          $complete_line = false;
          if ($ignore_line && !pzen_check_exceptions($result, $line)) $ignored_count++;
          $ignore_line=false;

          // show progress bar
          global $zc_show_progress;
          if ($zc_show_progress=='yes') {
             $counter++;
             if (($counter/5) == (int)($counter/5)) echo '~ ';
             if ($counter>200) {
               echo '<br /><br />';
               $counter=0;
             }
             @flush();
          }

        } //endif $complete_line

      } //endif ! # or -
    } // end foreach $lines
  return array('queries'=> $results, 'string'=>$string, 'output'=>$return_output, 'ignored'=>($ignored_count), 'errors'=>$errors);
  } //end function
  
  function pzen_check_exceptions($result, $line) {
    // note: table-prefixes are ignored here, since they are not added if this is an exception
    //echo '<br /><strong>RESULT_CODE: </strong>' . $result . '<br /><strong>LINE:</strong>' . $line;
    if (strstr($result,'EZ-Pages Settings') && strstr(strtolower($line), 'insert into configuration_group')) return true;
    if (strstr($result,'DEFINE_SITE_MAP_STATUS') && strstr(strtolower($line), 'insert into configuration')) return true;
    //echo '<br /><strong>NO EXCEPTIONS </strong>TO IGNORE<br />';
  }
  function pzen_table_exists($tablename, $pre_install=false) {
    global $db;
    $tables = $db->Execute("SHOW TABLES like '" . DB_PREFIX . $tablename . "'");
    if (ZC_UPG_DEBUG3==true) echo 'Table check ('.$tablename.') = '. $tables->RecordCount() .'<br>';
    if ($tables->RecordCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  function pzen_check_database_privs($priv='',$table='',$show_privs=false) {
    // bypass until future version
    return true;
    // end bypass
    global $zdb_server, $zdb_user, $zdb_name;
    if (isset($_GET['nogrants'])) return true; // bypass if flag set
    if (isset($_POST['nogrants'])) return true; // bypass if flag set
    //Display permissions, or check for suitable permissions to carry out a particular task
      //possible outputs:
      //GRANT ALL PRIVILEGES ON *.* TO 'xyz'@'localhost' WITH GRANT OPTION
      //GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, FILE, INDEX, ALTER ON *.* TO 'xyz'@'localhost' IDENTIFIED BY PASSWORD '2344'
      //GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER ON `db1`.* TO 'xyz'@'localhost'
      //GRANT SELECT (id) ON db1.tablename TO 'xyz'@'localhost
    global $db;
    global $db_test;
    $granted_privs_list='';
    if (ZC_UPG_DEBUG3==true) echo '<br />Checking for priv: ['.(zen_not_null($priv) ? $priv : 'none specified').']<br />';
    if (!defined('DB_SERVER'))          define('DB_SERVER',$zdb_server);
    if (!defined('DB_SERVER_USERNAME')) define('DB_SERVER_USERNAME',$zdb_user);
    if (!defined('DB_DATABASE'))        define('DB_DATABASE',$zdb_name);
    $user = DB_SERVER_USERNAME."@".DB_SERVER;
    if ($user == 'DB_SERVER_USERNAME@DB_SERVER' || DB_DATABASE=='DB_DATABASE') return true; // bypass if constants not set properly
    $sql = "show grants for ".$user;
    if (ZC_UPG_DEBUG3==true) echo $sql.'<br />';
    $result = $db->Execute($sql);
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG3==true) echo $result->fields['Grants for '.$user].'<br />';
      $grant_syntax = $result->fields['Grants for '.$user] . ' ';
      $granted_privs = str_replace('GRANT ','',$grant_syntax); // remove "GRANT" keyword
      $granted_privs = substr($granted_privs,0,strpos($granted_privs,' TO ')); //remove anything after the "TO" keyword
      $granted_db = str_replace(array('`','\\'),'',substr($granted_privs,strpos($granted_privs,' ON ')+4) ); //remove backquote and find "ON" string
      if (ZC_UPG_DEBUG3==true) echo 'privs_list = '.$granted_privs.'<br />';
      if (ZC_UPG_DEBUG3==true) echo 'granted_db = '.$granted_db.'<br />';
      $db_priv_ok += ($granted_db == '*.*' || $granted_db==DB_DATABASE.'.*' || $granted_db==DB_DATABASE.'.'.$table) ? true : false;
      if (ZC_UPG_DEBUG3==true) echo 'db-priv-ok='.$db_priv_ok.'<br />';

      if ($db_priv_ok) {  // if the privs list pertains to the current database, or is *.*, carry on
        $granted_privs = substr($granted_privs,0,strpos($granted_privs,' ON ')); //remove anything after the "ON" keyword
        $granted_privs_list .= ($granted_privs_list=='') ? $granted_privs : ', '.$granted_privs;

        $specific_priv_found = (zen_not_null($priv) && substr_count($granted_privs,$priv)==1);
        if (ZC_UPG_DEBUG3==true) echo 'specific priv['.$priv.'] found ='.$specific_priv_found.'<br />';

        if (ZC_UPG_DEBUG3==true) echo 'spec+db='.($specific_priv_found && $db_priv_ok == true).' ||| ';
        if (ZC_UPG_DEBUG3==true) echo 'all+db='.($granted_privs == 'ALL PRIVILEGES' && $db_priv_ok==true).'<br /><br />';

        if (($specific_priv_found && $db_priv_ok == true) || ($granted_privs == 'ALL PRIVILEGES' && $db_priv_ok==true)) {
          return true; // privs found
        }
      } // endif $db_priv_ok
      $result->MoveNext();
    }
    if ($show_privs) {
      if (ZC_UPG_DEBUG3==true) echo 'LIST OF PRIVS='.$granted_privs_list.'<br />';
      return $db_priv_ok . '|||'. $granted_privs_list;
    } else {
    return false; // if not found, return false
    }
  }

  function pzen_drop_index_command($param) {
    if (!$checkprivs = pzen_check_database_privs('INDEX')) return sprintf(REASON_NO_PRIVILEGES,'INDEX');
    //this is only slightly different from the ALTER TABLE DROP INDEX command
    global $db;
    if (!zen_not_null($param)) return "Empty SQL Statement";
    $index = $param[2];
    $sql = "show index from " . DB_PREFIX . $param[4];
    $result = $db->Execute($sql);
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
      if  ($result->fields['Key_name'] == $index) {
//        if (!$checkprivs = pzen_check_database_privs('INDEX')) return sprintf(REASON_NO_PRIVILEGES,'INDEX');
        return; // if we get here, the index exists, and we have index privileges, so return with no error
      }
      $result->MoveNext();
    }
    // if we get here, then the index didn't exist
    return sprintf(REASON_INDEX_DOESNT_EXIST_TO_DROP,$index,$param[4]);
  }

  function pzen_create_index_command($param) {
    //this is only slightly different from the ALTER TABLE CREATE INDEX command
    if (!$checkprivs = pzen_check_database_privs('INDEX')) return sprintf(REASON_NO_PRIVILEGES,'INDEX');
    global $db;
    if (!zen_not_null($param)) return "Empty SQL Statement";
    $index = (strtoupper($param[1])=='INDEX') ? $param[2] : $param[3];
    if (in_array('USING',$param)) return 'USING parameter found. Cannot validate syntax. Please run manually in phpMyAdmin.';
    $table = (strtoupper($param[2])=='INDEX' && strtoupper($param[4])=='ON') ? $param[5] : $param[4];
    $sql = "show index from " . DB_PREFIX . $table;
    $result = $db->Execute($sql);
    while (!$result->EOF) {
      if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
      if (strtoupper($result->fields['Key_name']) == strtoupper($index)) {
        return sprintf(REASON_INDEX_ALREADY_EXISTS,$index,$table);
      }
      $result->MoveNext();
    }
/*
 * @TODO: verify that individual columns exist, by parsing the index_col_name parameters list
 *        Structure is (colname(len)),
 *                  or (colname),
 */
  }

  function pzen_check_alter_command($param) {
    global $db;
    if (!zen_not_null($param)) return "Empty SQL Statement";
    if (!$checkprivs = pzen_check_database_privs('ALTER')) return sprintf(REASON_NO_PRIVILEGES,'ALTER');
    switch (strtoupper($param[3])) {
      case ("ADD"):
        if (strtoupper($param[4]) == 'INDEX') {
          // check that the index to be added doesn't already exist
          $index = $param[5];
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo 'KEY: '.$result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == $index) {
              return sprintf(REASON_INDEX_ALREADY_EXISTS,$index,$param[2]);
            }
            $result->MoveNext();
          }
        } elseif (strtoupper($param[4])=='PRIMARY') {
          // check that the primary key to be added doesn't exist
          if ($param[5] != 'KEY') return;
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == 'PRIMARY') {
              return sprintf(REASON_PRIMARY_KEY_ALREADY_EXISTS,$param[2]);
            }
            $result->MoveNext();
          }

        } elseif (!in_array(strtoupper($param[4]),array('CONSTRAINT','UNIQUE','PRIMARY','FULLTEXT','FOREIGN','SPATIAL') ) ) {
        // check that the column to be added does not exist
          $colname = ($param[4]=='COLUMN') ? $param[5] : $param[4];
          $sql = "show fields from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
            if  ($result->fields['Field'] == $colname) {
              return sprintf(REASON_COLUMN_ALREADY_EXISTS,$colname);
            }
            $result->MoveNext();
          }

        } elseif (strtoupper($param[5])=='AFTER') {
          // check that the requested "after" field actually exists
          $colname = ($param[6]=='COLUMN') ? $param[7] : $param[6];
          $sql = "show fields from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
            if  ($result->fields['Field'] == $colname) {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }

        } elseif (strtoupper($param[6])=='AFTER') {
          // check that the requested "after" field actually exists
          $colname = ($param[7]=='COLUMN') ? $param[8] : $param[7];
          $sql = "show fields from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
            if  ($result->fields['Field'] == $colname) {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }
/*
 * @TODO -- add check for FIRST parameter, to check that the FIRST colname specified actually exists
 */
        }
        break;
      case ("DROP"):
        if (strtoupper($param[4]) == 'INDEX') {
          // check that the index to be dropped exists
          $index = $param[5];
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == $index) {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }
          // if we get here, then the index didn't exist
          return sprintf(REASON_INDEX_DOESNT_EXIST_TO_DROP,$index,$param[2]);

        } elseif (strtoupper($param[4])=='PRIMARY') {
          // check that the primary key to be dropped exists
          if ($param[5] != 'KEY') return;
          $sql = "show index from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Key_name'].'<br />';
            if  ($result->fields['Key_name'] == 'PRIMARY') {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }
          // if we get here, then the primary key didn't exist
          return sprintf(REASON_PRIMARY_KEY_DOESNT_EXIST_TO_DROP,$param[2]);

        } elseif (!in_array(strtoupper($param[4]),array('CONSTRAINT','UNIQUE','PRIMARY','FULLTEXT','FOREIGN','SPATIAL'))) {
          // check that the column to be dropped exists
          $colname = ($param[4]=='COLUMN') ? $param[5] : $param[4];
          $sql = "show fields from " . DB_PREFIX . $param[2];
          $result = $db->Execute($sql);
          while (!$result->EOF) {
            if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
            if  ($result->fields['Field'] == $colname) {
              return; // exists, so return with no error
            }
            $result->MoveNext();
          }
          // if we get here, then the column didn't exist
          return sprintf(REASON_COLUMN_DOESNT_EXIST_TO_DROP,$colname);
        }//endif 'DROP'
        break;
      case ("ALTER"):
      case ("MODIFY"):
      case ("CHANGE"):
        // just check that the column to be changed 'exists'
        $colname = ($param[4]=='COLUMN') ? $param[5] : $param[4];
        $sql = "show fields from " . DB_PREFIX . $param[2];
        $result = $db->Execute($sql);
        while (!$result->EOF) {
          if (ZC_UPG_DEBUG3==true) echo $result->fields['Field'].'<br />';
          if  ($result->fields['Field'] == $colname) {
            return; // exists, so return with no error
          }
          $result->MoveNext();
        }
        // if we get here, then the column didn't exist
        return sprintf(REASON_COLUMN_DOESNT_EXIST_TO_CHANGE,$colname);
        break;
      default:
        // if we get here, then we're processing an ALTER command other than what we're checking for, so let it be processed.
        return;
        break;
    } //end switch
  }

  function pzen_check_config_key($line) {
    global $db;
    $values=array();
    $values=explode("'",$line);
     //INSERT INTO configuration blah blah blah VALUES ('title','key', blah blah blah);
     //[0]=INSERT INTO.....
     //[1]=title
     //[2]=,
     //[3]=key
     //[4]=blah blah
    $title = $values[1];
    $key  =  $values[3];
    $sql = "select configuration_title from " . DB_PREFIX . "configuration where configuration_key='".zen_db_input($key)."'";
    $result = $db->Execute($sql);
    if ($result->RecordCount() >0 ) return sprintf(REASON_CONFIG_KEY_ALREADY_EXISTS,$key);
  }

  function pzen_check_product_type_layout_key($line) {
    global $db;
    $values=array();
    $values=explode("'",$line);
    $title = $values[1];
    $key  =  $values[3];
    $sql = "select configuration_title from " . DB_PREFIX . "product_type_layout where configuration_key='".zen_db_input($key)."'";
    $result = $db->Execute($sql);
    if ($result->RecordCount() >0 ) return sprintf(REASON_PRODUCT_TYPE_LAYOUT_KEY_ALREADY_EXISTS,$key);
  }
  
  function pzen_check_cfggroup_key($line) {
    global $db;
    $values=array();
    $values=explode("'",$line);
    $id = $values[1];
    $title  =  $values[3];
    $sql = "select configuration_group_title from " . DB_PREFIX . "configuration_group where configuration_group_title='".$title."'";
    $result = $db->Execute($sql);
    if ($result->RecordCount() >0 ) return sprintf(REASON_CONFIGURATION_GROUP_KEY_ALREADY_EXISTS,$title);
    $sql = "select configuration_group_title from " . DB_PREFIX . "configuration_group where configuration_group_id='".$id."'";
    $result = $db->Execute($sql);
    if ($result->RecordCount() >0 ) return sprintf(REASON_CONFIGURATION_GROUP_ID_ALREADY_EXISTS,$id);
  }

  function pzen_write_to_upgrade_exceptions_table($line, $reason, $sql_file) {
    global $db;
    pzen_create_exceptions_table();
    $sql="INSERT INTO " . DB_PREFIX . TABLE_UPGRADE_EXCEPTIONS . " VALUES (0,:file:, :reason:, now(), :line:)";
    $sql = $db->bindVars($sql, ':file:', $sql_file, 'string');
    $sql = $db->bindVars($sql, ':reason:', $reason, 'string');
    $sql = $db->bindVars($sql, ':line:', $line, 'string');
    if (ZC_UPG_DEBUG3==true) echo '<br />sql='.$sql.'<br />';
    $result = $db->Execute($sql);
    return $result;
  }

  function pzen_purge_exceptions_table() {
    global $db;
    pzen_create_exceptions_table();
    $result = $db->Execute("TRUNCATE TABLE " . DB_PREFIX . TABLE_UPGRADE_EXCEPTIONS );
    return $result;
  }

  function pzen_create_exceptions_table() {
    global $db;
    if (!pzen_table_exists(TABLE_UPGRADE_EXCEPTIONS)) {
      $result = $db->Execute("CREATE TABLE " . DB_PREFIX . TABLE_UPGRADE_EXCEPTIONS ." (
            upgrade_exception_id smallint(5) NOT NULL auto_increment,
            sql_file varchar(50) default NULL,
            reason varchar(200) default NULL,
            errordate datetime default '0001-01-01 00:00:00',
            sqlstatement text, PRIMARY KEY  (upgrade_exception_id)
          )");
    return $result;
    }
  }

//------------------------------------------------------
// END FUNCTIONS LIST
//------------------------------------------------------

  if (isset($_GET['debug']) && $_GET['debug']=='ON') $debug=true;
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (zen_not_null($action)) {
    switch ($action) {
      case 'execute':
       if (isset($_POST['query_string']) && $_POST['query_string'] !='' ) {
         $query_string = $_POST['query_string'];
         if (version_compare(PHP_VERSION, 5.4, '<') && @get_magic_quotes_gpc() > 0) $query_string = stripslashes($query_string);
         if ($debug==true) echo $query_string . '<br />';
         $query_string = explode($linebreak, ($query_string));
         $query_results = pzen_executeSql($query_string, DB_DATABASE, DB_PREFIX);
           if ($query_results['queries'] > 0 && $query_results['queries'] != $query_results['ignored']) {
             $messageStack->add($query_results['queries'].' statements processed.', 'success');
           } else {
             $messageStack->add('Failed: '.$query_results['queries'], 'error');
           }
           if (zen_not_null($query_results['errors'])) {
             foreach ($query_results['errors'] as $value) {
               $messageStack->add('ERROR: '.$value, 'error');
             }
           }
           if ($query_results['ignored'] != 0) {
             $messageStack->add('Note: '.$query_results['ignored'].' statements ignored. See "upgrade_exceptions" table for additional details.', 'caution');
           }
           if (zen_not_null($query_results['output'])) {
             foreach ($query_results['output'] as $value) {
               if (zen_not_null($value)) $messageStack->add('INFO: '.$value, 'caution');
             }
           }

       } else {
         $messageStack->add(ERROR_NOTHING_TO_DO, 'error');
       }
       break;
      case 'uploadquery':
            $query_string  = '';
            if (isset($_FILES['sql_file']) && isset($_FILES['sql_file']['tmp_name']) && $_FILES['sql_file']['tmp_name'] != '') {
              $upload_query = file($_FILES['sql_file']['tmp_name']);
              $query_string  = $upload_query;
            }
            if (version_compare(PHP_VERSION, 5.4, '<') && @get_magic_quotes_runtime() > 0) $query_string  = zen_db_prepare_input($upload_query);
            if ($query_string !='') {
              $query_results = pzen_executeSql($query_string, DB_DATABASE, DB_PREFIX);
              if ($query_results['queries'] > 0 && $query_results['queries'] != $query_results['ignored']) {
                $messageStack->add($query_results['queries']. ' statements processed.', 'success');
              } else {
                $messageStack->add('Failed: '.$query_results['queries'], 'error');
              }
             if (zen_not_null($query_results['errors'])) {
               foreach ($query_results['errors'] as $value) {
                 $messageStack->add('ERROR: '.$value, 'error');
               }
             }
             if ($query_results['ignored'] != 0) {
             $messageStack->add('Note: '.$query_results['ignored'].' statements ignored. See "upgrade_exceptions" table for additional details.', 'caution');
              }
              if (zen_not_null($query_results['output'])) {
                foreach ($query_results['output'] as $value) {
                  if (zen_not_null($value)) $messageStack->add('ERROR: '.$value, 'error');
                }
              }
            } else {
              $messageStack->add(ERROR_NOTHING_TO_DO, 'error');
            }
       break;
      case 'help':
       break;
      default:
       break;
    }
  }
}
function pzen_execute_sql($sql_file_path,$dbname,$dbprefix){
	global $messageStack,$db;
	pzen_exe_datafile();
	$query_results = pzen_executeSql($sql_file_path, $dbname, $dbprefix);
	if($query_results['queries'] > 0 && $query_results['queries'] != $query_results['ignored']){
		$messageStack->add($query_results['queries']. ' statements processed.', 'success');
		$messageStack->add_session(PZEN_TEMPLATE_DATA_INSTALLED, 'success');
		zen_redirect(zen_href_link(FILENAME_PZENTEMPLATE.".php", 'SSL'));
	}else {
		$messageStack->add('Failed: '.$query_results['queries'], 'error');
	}
	if(zen_not_null($query_results['errors'])) {
		foreach ($query_results['errors'] as $value) {
			$messageStack->add('ERROR: '.$value, 'error');
		}
	}
}
function pzen_execute_sql_force($sql_file_path,$dbname,$dbprefix){
	global $messageStack,$db;
	pzen_exe_datafile();
	$query_results = pzen_executeSql($sql_file_path, $dbname, $dbprefix);
	if($query_results['queries'] > 0 && $query_results['queries'] != $query_results['ignored']){
		$messageStack->add($query_results['queries']. ' statements processed.', 'success');
	}else {
		$messageStack->add('Failed: '.$query_results['queries'], 'error');
	}
	if(zen_not_null($query_results['errors'])) {
		foreach ($query_results['errors'] as $value) {
			$messageStack->add('ERROR: '.$value, 'error');
		}
	}
}
function pzen_checkdb_tables($template_tables){
	$template_tables=explode(",",$template_tables);
	$table_exits=array();
	foreach($template_tables as $k=>$v){
		if(checkdbtable($v)==1){
			$table_exits[]=$v;
		}
	}
	return $table_exits;
}

function checkdbtable($table){
	global $db;
	$rs=$db->Execute("SHOW TABLES LIKE '".$table."'");
	if($rs->RecordCount()){
		return true;
	}
	return false;
}