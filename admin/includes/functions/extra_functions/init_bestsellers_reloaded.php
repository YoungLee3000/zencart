<?php
// -----
// Initialization script for the Best-Sellers Reloaded plugin.  Modified from the previous install.sql by lat9 (Vinos de Frutas Tropicales).
// Copyright (c) 2014-2015, Vinos de Frutas Tropicales
//

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$configurationGroupTitle = 'Best Sellers';
$configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = '$configurationGroupTitle' LIMIT 1");
if ($configuration->EOF) {
  $db->Execute("INSERT INTO " . TABLE_CONFIGURATION_GROUP . " (configuration_group_title, configuration_group_description, sort_order, visible) VALUES ('$configurationGroupTitle', 'Best-Seller Settings', '1', '1');");
  $cgi = $db->Insert_ID(); 
  $db->Execute("UPDATE " . TABLE_CONFIGURATION_GROUP . " SET sort_order = $cgi WHERE configuration_group_id = $cgi;");
  
} else {
  $cgi = $configuration->fields['configuration_group_id'];
  
}

// -----
// Set the various configuration items, if Best Sellers wasn't previously installed.
//
if (!defined ('SHOW_PRODUCT_INFO_MAIN_BEST_SELLERS')) {
  $db->Execute ("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function ) VALUES ( 'Show Best Sellers - Main Page', 'SHOW_PRODUCT_INFO_MAIN_BEST_SELLERS', '0', 'Show the <em>Best Sellers</em> on the main page? Set to <em>0</em> to disable or set the sort order for the display.', $cgi, 5, NULL , NULL)");
  
  $db->Execute ("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function ) VALUES ( 'Show Best Sellers - Main Page w/ Categories', 'SHOW_PRODUCT_INFO_CATEGORY_BEST_SELLERS', '0', 'Show the <em>Best Sellers</em> on the categories\' listings? Set to <em>0</em> to disable or set the sort order for the display.', $cgi, 10, NULL , NULL)");
    
  $db->Execute ("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function ) VALUES ( 'Maximum Display of Best Sellers', 'MAX_DISPLAY_SEARCH_RESULTS_BEST_SELLERS', '9', 'The maximum number of best sellers to list in an enabled center-box.', $cgi, 15, NULL , NULL)");
  
  $db->Execute ("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function ) VALUES ( 'Best Sellers - Columns per Row', 'SHOW_PRODUCT_INFO_COLUMNS_BEST_SELLERS', '4', 'The number of columns to display in an enabled center-box.', $cgi, 20, NULL, 'zen_cfg_select_option(array(\'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\', \'10\', \'11\', \'12\'),')");

  $db->Execute ("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function ) VALUES ( 'Best Sellers - Image Width', 'IMAGE_BEST_SELLERS_LISTING_WIDTH', '100', 'The width of the <em>Best Sellers</em> images.', $cgi, 25, NULL , NULL)");

  $db->Execute ("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function ) VALUES ( 'Best Sellers - Image Height', 'IMAGE_BEST_SELLERS_LISTING_HEIGHT', '80', 'The height of the <em>Best Sellers</em> images.', $cgi, 30, NULL, NULL)");

  $db->Execute ("INSERT INTO " . TABLE_CONFIGURATION . " ( configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function ) VALUES ( 'Best Sellers - Show Out-of-Stock?', 'BEST_SELLERS_RELOADED_SHOW_OUT_OF_STOCK', 'false', 'Show out-of-stock products in the <em>Best Sellers</em> centerbox?', $cgi, 35, NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),')");
   
}

if (function_exists ('zen_page_key_exists') && !zen_page_key_exists('configBestSellers')) {
  zen_register_admin_page('configBestSellers', 'BOX_CONFIGURATION_BEST_SELLERS_RELOADED', 'FILENAME_CONFIGURATION', "gID=$cgi", 'configuration', 'Y', $cgi);
  
}