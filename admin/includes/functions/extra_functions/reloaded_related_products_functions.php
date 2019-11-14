<?php
  /**
     * functions/extra_functions/reloaded_related_products_functions
     * 
     * Add products_family field to the products table
     * 
     * @package ZenCart
     * @author Joe McFrederick
     * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
     */
if( !class_exists('messageStack') )
{
	include('../../classes/message_stack.php');
}
if( !is_object($reloadedStack) )
{
	$reloadedStack = new messageStack();
}
     
    
     //Auto install check
     $reloadedRelatedCheck = $db->Execute("SHOW COLUMNS FROM " . TABLE_PRODUCTS . " LIKE 'products_family'");
     if(($reloadedRelatedCheck->RecordCount() < 1 OR !defined('SHOW_PRODUCT_INFO_COLUMNS_RELATED_PRODUCTS')) AND basename($_SERVER['PHP_SELF']) == 'index.php')
     {
        $reloadedStack->add('Related Products <b>not installed</b><a href="index.php?install_related_products=yes">[Click to Install]</a>');		
     }
     
    
  /**
      * Install configuration into database
      * @param none
      */
      function reloaded_related_install() {
        global $db, $reloadedStack;
        
        // Maintenance to remove old configuration values
        $keys = reloaded_related_keys();        
        $db->Execute("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key IN ('" . implode("', '", $keys) . "')");
		unset($keys);        
        
		// Get Configuration Group ID for Configuration->Product Info
        $configuration_group = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title='Product Info'");
        
        if ($configuration_group->RecordCount() > 0)
        {
            //Insert configuration value for Product Info Group
           
			$db->Execute("INSERT INTO " . TABLE_CONFIGURATION . "(configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('Related Products Columns per Row', 'SHOW_PRODUCT_INFO_COLUMNS_RELATED_PRODUCTS', '3', 'Related Products Columns per Row<br />0= off or set the sort order', '" . $configuration_group->fields['configuration_group_id'] . "', '100', NULL, now(), NULL, 'zen_cfg_select_option(array(\'0\', \'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\', \'10\', \'11\', \'12\'),')");
        }		
        
        //Make sure we really need to add the column in case user was upgrading
        $reloadedRelatedCheck = $db->Execute("SHOW COLUMNS FROM " . TABLE_PRODUCTS . " LIKE 'products_family'");
        if ($reloadedRelatedCheck->RecordCount() < 1)
        {
            $db->Execute("ALTER TABLE " . TABLE_PRODUCTS ." ADD COLUMN products_family VARCHAR(50)");
        }
        $reloadedStack->add_session('Related Products Successfully Installed', 'success');
        zen_redirect(zen_href_link('index.php'));
      }
      
  /**
       * Uninstall configuration into database
       * @param none
       */
       function reloaded_related_remove() {
        global $db, $reloadedStack;
        
        //Auto install check
        $reloadedRelatedCheck = $db->Execute("SHOW COLUMNS FROM " . TABLE_PRODUCTS . " LIKE 'products_family'");
        if($reloadedRelatedCheck->RecordCount() > 0 )
        {
            $db->Execute("ALTER TABLE " . TABLE_PRODUCTS . " DROP products_family");
        }
        
        //Get configuration keys for mod
        $keys = reloaded_related_keys();
        
        $db->Execute("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key IN ('" . implode("', '", $keys) . "')");
		
        unset($keys);
		
        $reloadedStack->add_session('Related Products successfully removed', 'success');
		
        zen_redirect(zen_href_link('index.php'));
        
       }
       
       function reloaded_related_keys()
       {
            return array('SHOW_PRODUCT_INFO_COLUMNS_RELATED_PRODUCTS');
       }
     
  /**
      * Manual install/uninstall
      */
      if($_GET['install_related_products']=="yes" AND  basename($_SERVER['PHP_SELF']) == 'index.php') reloaded_related_install();
      if($_GET['remove_reloaded_related_products']=="yes" AND basename($_SERVER['PHP_SELF']) == 'index.php') reloaded_related_remove();
