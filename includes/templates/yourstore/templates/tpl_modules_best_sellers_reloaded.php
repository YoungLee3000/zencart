<?php
/**
 * Best Sellers Reloaded v1.1
 *
 * Module Template
 *
 * @package templateSystem
 * @author Alex Clarke (aclarke@ansellandclarke.co.uk)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_best_sellers_reloaded.php 2007-07-22 aclarke $
 */
  $zc_show_best_sellers = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_BEST_SELLERS_RELOADED_MODULE));
?>

<!-- bof - Best Sellers Reloaded v1.1 - aclarke - 2007-07-22 -->
<?php if ($zc_show_best_sellers == true) { ?>
<div class="centerBoxWrapper <?php echo $bproducts_display_style.'-view'; ?>" id="bestSellers" <?php echo ($bproducts_display_style=='tabs' && $this_is_home_page)? 'style="display:none;"' : ''; ?>>
<?php
/**
 * require the list_box_content template to display the product
 */
  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
?>
<?php if($border_width != NULL && $this_is_home_page) { ?>
<section class="content separator-section">
	<div class="<?php if($homepage_layout==1) { echo "container"; } else { echo "no-container"; } ?>">
		<hr>
	</div>
</section>
<?php } ?>
</div>
<?php } ?>
<!-- eof - Best Sellers Reloaded v1.1 - aclarke - 2007-07-22  -->
