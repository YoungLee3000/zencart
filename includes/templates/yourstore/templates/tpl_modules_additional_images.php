<?php
/**
 * Module Template:
 * Loaded by product-type template to display additional product images.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_additional_images.php 3215 2006-03-20 06:05:55Z birdbrain $
 */

  require(DIR_WS_MODULES . zen_get_module_directory('additional_images.php'));
 ?>
 <?php
 if ($flag_show_product_info_additional_images != 0 && $num_images > 0) {
		
		if($prodinfo_image_effects==2 && ZEN_LIGHTBOX_GALLERY_MAIN_IMAGE != 'true') {
			unset($list_box_contents[0][0]);
			$list_box_contents[0] = array_values($list_box_contents[0]);
		}
		for($row=0;$row<sizeof($list_box_contents);$row++)
		{
			$params = "";
			//if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
			for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
			{
					$r_params = "";
				if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
				if (isset($list_box_contents[$row][$col]['text']['thumb'])) 
				{ 
					echo '<li' . $r_params . '>' . $list_box_contents[$row][$col]['text']['thumb'] .  '</li>';
				}
			}
		}
  }
?>