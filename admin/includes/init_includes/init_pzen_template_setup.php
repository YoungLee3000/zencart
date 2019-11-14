<?php 
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
define('STRICT_ERROR_REPORTING', true);

global $messageStack;
$install_incomplete=false;
$no_template=false;

//chk is login, cur template**************************************************************************
// do not run installer on log in page
if($_SESSION['admin_id']==0)
{
	$install_incomplete=true;
}

// find current template
$sql = "SELECT template_dir FROM ".TABLE_TEMPLATE_SELECT." LIMIT 1";
$obj = $db->Execute($sql);
$current_template = $obj->fields['template_dir'];
if($current_template == '' )
{
	$install_incomplete = true;
	$no_template = true;
}
//EOF chk is login, cur template**************************************************************************

if(!$install_incomplete && !$no_template ){	
	global $db;
	$table_exits=pzen_checkdb_tables(PZEN_TEMPLATE_TABLES);
	//************************************* SQL FILE SETUP *******************************************/
	if(empty($table_exits) && (isset($_GET['pzen_install']) && $_GET['pzen_install']=1) ){
		pzen_execute_sql(PZEN_TEMPLATE_SQL,DB_DATABASE,DB_PREFIX);
	}
	if(empty($table_exits)){
		$messageStack->add(PZEN_INSTALLATION_MSG, 'success');
	}
	//************************************* EOF SQL FILE SETUP ***************************************/
}
if(isset($_GET['pzen_install_force']) && $_GET['pzen_install_force']==1 ){	
	global $db;
	//************************************* SQL FILE SETUP *******************************************/
		pzen_execute_sql_force(PZEN_TEMPLATE_SQL_FORCE,DB_DATABASE,DB_PREFIX);
	//************************************* EOF SQL FILE SETUP ***************************************/
}

