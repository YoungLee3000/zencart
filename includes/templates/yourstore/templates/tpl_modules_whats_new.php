<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_whats_new.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  $zc_show_new_products = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_NEW_PRODUCTS));
?>

<!-- bof: whats_new -->
<?php if ($zc_show_new_products == true) { ?>
<div class="centerBoxWrapper <?php echo $nproducts_display_style.'-view'; ?>" id="whatsNew" <?php echo ($nproducts_display_style=='tabs' && $this_is_home_page)? 'style="display:none;"' : ''; ?>>
<?php
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
<!-- eof: whats_new -->
