<?php 
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

global $messageStack;
$install_flag = false;
$config_title = 'Dynamic Filter';
$config_text = 'Dynamic Filter Settings';

$sql = "SELECT * FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title = '".$config_title."'";
$config_exe = $db->Execute($sql);

if(!$config_exe->EOF)
{
	//if exists update
	$sql = "UPDATE ".TABLE_CONFIGURATION_GROUP." SET configuration_group_description = '".$config_title."'	WHERE configuration_group_title = '".$config_text."'";
	$db->Execute($sql);
	$sort = $original_config->fields['sort_order'];
	
}else{
	/*find max id */
	$sort_query = "SELECT MAX(sort_order) as max_sort FROM `".TABLE_CONFIGURATION_GROUP."`";
	$max_sort = $db->Execute($sort_query);
	if(!$max_sort->EOF) {
		$max_sort = $max_sort->fields['max_sort'] + 1;

		/* insert Configuration */
		$sql = "INSERT INTO ".TABLE_CONFIGURATION_GROUP." (configuration_group_title, configuration_group_description, sort_order, visible) VALUES ( '".$config_title."', '".$config_text."', ".$max_sort.", '1')";
		$db->Execute($sql);
	}
	else {
		$messageStack->add('Database Error: Unable to access sort_order in table' . TABLE_CONFIGURATION_GROUP, 'error');
		$install_flag = true;
	}
}


/* Configuration Id */
$sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='".$config_title."' LIMIT 1";
$result = $db->Execute($sql);
if(!$result->EOF) {
	$dynamic_filter_configid = $result->fields['configuration_group_id'];

	/* Remove Config */
	$sql = "DELETE FROM ".DB_PREFIX."configuration WHERE configuration_group_id ='".$dynamic_filter_configid."'";
	$db->Execute($sql);

	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Enable on Category Pages', 'FILTER_CATEGORY', 'Yes', 'Enable the filter on category pages?', '".$dynamic_filter_configid."', 10, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Yes'', ''NO''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Enable on All Products Page', 'FILTER_ALL', 'Yes', 'Enable the filter on all products page?', '".$dynamic_filter_configid."', 20, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Yes'', ''NO''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Enable on New Products Page', 'FILTER_NEW', 'Yes', 'Enable the filter on new products page?', '".$dynamic_filter_configid."', 30, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Yes'', ''NO''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Enable on Featured Products Page', 'FILTER_FEATURED', 'Yes', 'Enable the filter on featured products page?', '".$dynamic_filter_configid."', 40, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Yes'', ''NO''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Enable on Specials Page', 'FILTER_SPECIALS', 'Yes', 'Enable the filter on specials page?', '".$dynamic_filter_configid."', 50, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Yes'', ''NO''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Enable on Search Page', 'FILTER_SEARCH', 'Yes', 'Enable the filter on advanced search page?', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Yes'', ''NO''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Filter Style', 'FILTER_STYLE', 'Checkbox - Multi', 'How are the filters to be applied?<br /><br /><strong>Link</strong> - Each option is a link; Only one filter can be applied at a time.<br /><strong>Dropdown (Single)</strong> - Each option is part of a drop down list; Only one filter can be applied at a time.<br /><strong>Dropdown (Multi)</strong> - Each option is part of a drop down list; Multiple filters can be applied at a time.<br /><strong>Checkbox (Single)</strong> - Each option is a checkbox; Only one filter can be applied at a time.<br /><strong>Checkbox (Multi)</strong> - Each option is a checkbox; Multiple filters can be applied at a time.', '".$dynamic_filter_configid."', 70, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Link'', ''Dropdown - Single'', ''Dropdown - Multi'', ''Checkbox - Single'', ''Checkbox - Multi''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Disabled Options Method', 'FILTER_METHOD', 'Greyed', 'How are the unavailable filter options to be disabled?<br /><br /><strong>Greyed</strong> - Grey out the unavailable options.<br /><strong>Hidden</strong> - Hide the unavailable options.', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Greyed'', ''Hidden''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Options Box Style', 'FILTER_OPTIONS_STYLE', 'Expand', 'Which style of box should be used when the maximum number of options has been reached?<br /><br /><strong>Scroll</strong> - Scroll box.<br /><strong>Expand</strong> - Expanding box with More/Less link.<br /><br /><strong>Note: This option is only applicatble with Link or Checkbox filter styles.</strong>', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Scroll'', ''Expand''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Maximum Number of Options', 'FILTER_MAX_OPTIONS', '9', 'What is the maximum number of options to be displayed before scroll bar/More link is visible?<br /><br /><strong>Note: This option is only applicatble with Link or Checkbox filter styles.</strong>', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, NULL)";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Enable Price filter', 'SHOW_FILTER_BY_PRICE', 'Yes', 'Enable the price filter?', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''Yes'', ''NO''),')";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Maximum Number of Price Ranges', 'FILTER_MAX_RANGES', '5', 'What is the maximum number of price range groups?<br /><br /><strong>Note: This can be overridden by the Maximum Price Range parameter</strong>', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, NULL)";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Minimum Price Range', 'FILTER_MIN_PRICE', '10', 'What is the minimum gap in the price ranges?<br />Set as zero to deactivate.', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, NULL)";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Maximum Price Range', 'FILTER_MAX_PRICE', '50', 'What is the minimum gap in the price ranges?<br />Set as zero to deactivate.', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, NULL)";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Include Options', 'FILTER_OPTIONS_INCLUDE', '',  'Enter the list of option IDs to be included in the filter, separated by commas (i.e. 1,2,3)<br />Only the option numbers listed here will appear in the filter.<br />Leave blank to deactivate.', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, NULL)";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Exclude Options', 'FILTER_OPTIONS_EXCLUDE', '',  'Enter the list of option IDs to be excluded from the filter, separated by commas (i.e. 1,2,3)<br />The option numbers listed here will <strong>not</strong> appear in the filter.<br />Leave blank to deactivate.', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, NULL)";
	$db->Execute($sql);
	$sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ( 'Google Event Tracking', 'FILTER_GOOGLE_TRACKING', 'No',  'Use Google Event Tracking?<br /><br /><strong>No</strong> - Do not use Google Event Tracking<br /><strong>ga.js</strong> - Use traditional ga.js Google Event Tracking method<br /><strong>Asynchronous</strong> - Use new asynchronous Google Event Tracking method<br /><br /><strong>Note: Requires Google Analytics Code</strong>', '".$dynamic_filter_configid."', 60, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''No'', ''ga.js'', ''Asynchronous''),')";
	$db->Execute($sql);
}
else {
	$messageStack->add('Database Error: Unable to access configuration_group_id in table' . TABLE_CONFIGURATION_GROUP, 'error');
	$install_flag = true;
}

if(function_exists('zen_register_admin_page')) {
	if(!zen_page_key_exists('configDynamicFilter')){
		$page_sort_query = "SELECT MAX(sort_order) as max_sort FROM `". TABLE_ADMIN_PAGES ."` WHERE menu_key='configuration'";
		$page_sort = $db->Execute($page_sort_query);
		$page_sort = $page_sort->fields['max_sort'] + 1;
		zen_register_admin_page('configDynamicFilter', 'BOX_CONFIGURATION_DYNAMIC_FILTER', 'FILENAME_CONFIGURATION', 'gID=' . $dynamic_filter_configid, 'configuration', 'Y', $page_sort);
	}
}

if(file_exists(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.dynamic_filter.php'))
{
	if(!unlink(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.dynamic_filter.php'))
	{
		$messageStack->add('The auto-loader file '.DIR_FS_ADMIN.'includes/auto_loaders/config.dynamic_filter.php has not been deleted. For this module to work you must delete the '.DIR_FS_ADMIN.'includes/auto_loaders/config.dynamic_filter.php file manually.  Before you post on the Zen Cart forum to ask, YES you are REALLY supposed to follow these instructions and delete the '.DIR_FS_ADMIN.'includes/auto_loaders/config.dynamic_filter.php file.','error');
		$install_flag = true;
	}
}

if(!$install_flag) $messageStack->add('Dynamic Filter install completed!','success');