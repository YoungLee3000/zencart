<?php
/**
 * Testimonial Manager
 *
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_tm_config.php 2.3.3b 7/12/2014 mc12345678 $
 */

//$messageStack->add('Testimonials Manager v1.5.4 install started','success');

$sql = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."testimonials_manager (
  testimonials_id int(11) NOT NULL auto_increment,
  language_id int(11) NOT NULL default '1',
  testimonials_title varchar(64) NOT NULL default '',
  testimonials_url  VARCHAR( 255 ) NULL DEFAULT NULL,
  testimonials_name text NOT NULL,
  testimonials_image varchar(254) NOT NULL default '',
  testimonials_html_text text,
  testimonials_mail text NOT NULL,
  testimonials_company VARCHAR( 255 ) NULL DEFAULT NULL,
  testimonials_city VARCHAR( 255 ) NULL DEFAULT NULL,
  testimonials_country VARCHAR( 255 ) NULL DEFAULT NULL,
  testimonials_show_email char(1) default '0',
  status int(1) NOT NULL default '0',
  date_added datetime NOT NULL default '0001-01-01 00:00:00',
  last_update datetime NULL default NULL,
  PRIMARY KEY  (testimonials_id)
)";
    $db->Execute($sql);

//check if sample testimonial exists and if it does not exist, then add it
    $tm_sample_name = 'Clyde Designs';
    $sql ="SELECT * FROM ".DB_PREFIX."testimonials_manager WHERE testimonials_name = '".$tm_sample_name."'";
    $result = $db->Execute($sql);
    if(!$result->RecordCount())
    {
    $sql = "INSERT INTO ".DB_PREFIX."testimonials_manager (language_id, testimonials_title, testimonials_url, testimonials_name, testimonials_image, testimonials_html_text, testimonials_mail, testimonials_company, testimonials_city, testimonials_country, testimonials_show_email, status, date_added, last_update) VALUES (1, 'Great', '', 'Clyde Designs', '', 'This is just a test submission to show you how it looks, great, eh?', 'clyde@mysticmountainnaturals.com', NULL, NULL, NULL, 0, 1, now(), NULL)";
    $db->Execute($sql);
    }

    $tm_menu_title = 'Testimonials Manager';
    $tm_menu_text = 'Testimonials Manager Display Settings';

    /* find if Testimonial Manager Configuration Group Exists */
    $sql = "SELECT * FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title = '".$tm_menu_title."'";
    $original_config = $db->Execute($sql);

    if($original_config->RecordCount())
    {
        // if exists updating the existing Testimonial Manager configuration group entry
        $sql = "UPDATE ".TABLE_CONFIGURATION_GROUP." SET 
                configuration_group_description = '".$tm_menu_text."' 
                WHERE configuration_group_title = '".tm_menu_title."'";
        $db->Execute($sql);
        $sort = $original_config->fields['sort_order'];

    }else{
        /* Find max sort order in the configuation group table -- add 2 to this value to create the Testimonial Manager configuration group ID */
        $sql = "SELECT (MAX(sort_order)+2) as sort FROM ".TABLE_CONFIGURATION_GROUP;
        $result = $db->Execute($sql);
        $sort = $result->fields['sort'];

        /* Create Testimonial Manager configuration group */
        $sql = "INSERT INTO ".TABLE_CONFIGURATION_GROUP." (configuration_group_title, configuration_group_description, sort_order, visible) VALUES ('".$tm_menu_title."', '".$tm_menu_text."', ".$sort.", '1')";
        $db->Execute($sql);
   }

    /* Find configuation group ID of Testimonial Manager */
    $sql = "SELECT configuration_group_id FROM ".TABLE_CONFIGURATION_GROUP." WHERE configuration_group_title='".$tm_menu_title."' LIMIT 1";
    $result = $db->Execute($sql);
        $tm_configuration_id = $result->fields['configuration_group_id'];

    /* Remove Testimonial Manager items from the configuration table */
    $sql = "DELETE FROM ".DB_PREFIX."configuration WHERE configuration_group_id ='".$tm_configuration_id."'";
        $db->Execute($sql);

//-- ADD VALUES TO TESTIMONIAL MANAGER CONFIGURATION GROUP (Admin > Configuration > Testimonial Manager) --
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Number Of Testimonials to display in Testimonials Sidebox', 'MAX_DISPLAY_TESTIMONIALS_MANAGER_TITLES', '5', 'Set the number of testimonials to display in the Latest Testimonials box.', '".$tm_configuration_id."', 1, NULL, now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Title Minimum Length', 'ENTRY_TESTIMONIALS_TITLE_MIN_LENGTH', '2', 'Minimum length of link title.', '".$tm_configuration_id."', 2, NULL, now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Text Minimum Length', 'ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH', '10', 'Minimum length of Testimonial description.', '".$tm_configuration_id."', 3, NULL, now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Text Maximum Length', 'ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH', '1000', 'Maximum length of Testimonial description.', '".$tm_configuration_id."', 3, NULL, now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Contact Name Minimum Length', 'ENTRY_TESTIMONIALS_CONTACT_NAME_MIN_LENGTH', '2', 'Minimum length of link contact name.', '".$tm_configuration_id."', 4, NULL, now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display Truncated Testimonials in Sidebox', 'DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT', 'true', 'Display truncated text in sidebox', '".$tm_configuration_id."', 5, NULL, now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Length of truncated testimonials to display', 'TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH', '150', 'If Display Truncated Testimonials in Sidebox is true - set the amount of characters to display from the Testimonials in the Testimonials Manager sidebox.', '".$tm_configuration_id."', 6, NULL, now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Number Of Testimonials to display on all testimonials page', 'MAX_DISPLAY_TESTIMONIALS_MANAGER_ALL_TESTIMONIALS', '5', 'Set the number of testimonials to display on the all testimonials page.', '".$tm_configuration_id."', 7, NULL, now(), NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display Date Published on Testimonials page', 'DISPLAY_TESTIMONIALS_DATE_PUBLISHED', 'true', 'Display date published on testimonials page', '".$tm_configuration_id."', 8, NULL, now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display View All Testimonials Link In Sidebox', 'DISPLAY_ALL_TESTIMONIALS_TESTIMONIALS_MANAGER_LINK', 'true', 'Display View All Testimonials Link In Sidebox', '".$tm_configuration_id."', 9, NULL, now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display Add New Testimonial Link In Sidebox', 'DISPLAY_ADD_TESTIMONIAL_LINK', 'true', 'Display Add New Testimonial Link In Sidebox', '".$tm_configuration_id."', 10, NULL, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Image Width', 'TESTIMONIAL_IMAGE_WIDTH', '80', 'Set the Width of the Testimonial Image', '".$tm_configuration_id."', 11, NULL, '2007-08-21 12:04:10', NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Image Height', 'TESTIMONIAL_IMAGE_HEIGHT', '80', 'Set the Height of the Testimonial Image', '".$tm_configuration_id."', 12, NULL, '2007-08-21 12:04:10', NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Image Directory', 'TESTIMONIAL_IMAGE_DIRECTORY', 'testimonials/', 'Set the Directory for the Testimonial Image', '".$tm_configuration_id."', 13, NULL, '2007-08-21 12:04:10', NULL, NULL)";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display Company Name field', 'TESTIMONIALS_COMPANY', 'true', 'Display Company Name field', '".$tm_configuration_id."', 14, NULL, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display City field', 'TESTIMONIALS_CITY', 'true', 'Display City field', '".$tm_configuration_id."', 15, NULL, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display Country field', 'TESTIMONIALS_COUNTRY', 'true', 'Display Country field', '".$tm_configuration_id."', 16, NULL, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Only registered customers may submit a testimonial', 'REGISTERED_TESTIMONIAL', 'true', 'Only registered customers may submit a testimonial', '".$tm_configuration_id."', 17, NULL, now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Display All Languages', 'TESTIMONIALS_DISPLAY_ALL_LANGUAGES', 'true', 'Display All Languages', '".$tm_configuration_id."', 18, NULL, NOW(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial - Show Store Name and Address', 'TESTIMONIAL_STORE_NAME_ADDRESS', 'true', 'Include Store Name and Address', '".$tm_configuration_id."', 19, NULL, now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Define Testimonial Status', 'DEFINE_TESTIMONIAL_STATUS', '1', 'Enable the Defined Testimonial Link/Text?<br />0= Link ON, Define Text OFF<br />1= Link ON, Define Text ON<br />2= Link OFF, Define Text ON<br />3= Link OFF, Define Text OFF', '".$tm_configuration_id."', 20, NULL, now(), NULL, 'zen_cfg_select_option(array(''0'', ''1'', ''2'', ''3''),')";
    $db->Execute($sql);
    $sql = "INSERT INTO ".DB_PREFIX."configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Testimonial Manager Version', 'TM_VERSION', '1.5.4', 'Testimonial Manager version', '".$tm_configuration_id."', 21, NULL, now(), NULL, NULL)";
    $db->Execute($sql);

   if(file_exists(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.tm.php'))
    {
        if(!unlink(DIR_FS_ADMIN . DIR_WS_INCLUDES . 'auto_loaders/config.tm.php'))
	{
		$messageStack->add('The auto-loader file '.DIR_FS_ADMIN.'includes/auto_loaders/config.tm.php has not been deleted. For this module to work you must delete the '.DIR_FS_ADMIN.'includes/auto_loaders/config.tm.php file manually.  Before you post on the Zen Cart forum to ask, YES you are REALLY supposed to follow these instructions and delete the '.DIR_FS_ADMIN.'includes/auto_loaders/config.tm.php file.','error');
	};
    }

       $messageStack->add('Testimonials Manager v1.5.4 install completed!','success');

    // find next sort order in admin_pages table
    $sql = "SELECT (MAX(sort_order)+2) as sort FROM ".TABLE_ADMIN_PAGES;
    $result = $db->Execute($sql);
    $admin_page_sort = $result->fields['sort'];

    // now register the admin pages
    // Admin Menu for Testimonial Manager Configuration Menu
    zen_deregister_admin_pages('configTestimonialsManager');
    zen_register_admin_page('configTestimonialsManager',
        'BOX_CONFIGURATION_TESTIMONIALS_MANAGER', 'FILENAME_CONFIGURATION',
        'gID=' . $tm_configuration_id, 'configuration', 'Y',
        $admin_page_sort);

	//-- Admin Menu for Testimonial Manager Tools Menu
    zen_deregister_admin_pages('TestimonialsManager');
    zen_deregister_admin_pages('toolsTestimonialsManager');
    zen_register_admin_page('toolsTestimonialsManager',
        'BOX_TOOLS_TESTIMONIALS_MANAGER', 'FILENAME_TESTIMONIALS_MANAGER',
        '', 'tools', 'Y',
        $admin_page_sort);