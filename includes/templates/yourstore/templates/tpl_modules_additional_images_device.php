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
		for($row=0;$row<sizeof($list_box_contents);$row++)
		{
			$params = "";
			//if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
			for($col=0;$col<sizeof($list_box_contents[$row]);$col++) 
			{
					$r_params = "";
				if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
				if (isset($list_box_contents[$row][$col]['text']['large'])) 
				{ 
					echo '<li' . $r_params . '>' . $list_box_contents[$row][$col]['text']['large'] .  '</li>';
				}
			}
		}
  }else{
	echo '<li class="additionalImages centeredContent back">'.zen_image($products_image_large, $products_name, MEDIUM_IMAGE_WIDTH, MEDIUM_IMAGE_HEIGHT)."</li>";
  }
?>