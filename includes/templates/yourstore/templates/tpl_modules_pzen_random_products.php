<?php
/**
 * Module Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_pzen_modules_random_products.php 2935 2006-02-01 11:12:40Z birdbrain $
 */
  $zc_show_random_products = false;
  include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PZEN_RANDOM_PRODUCTS));
?>

<!-- bof: random products -->
<?php if ($zc_show_random_products == true) { ?>
<section class="<?php echo (($display_main_slideshow==0 && $display_top_banners==0 && $homepage_layout==2) || ($randprod_style=='default' && $homepage_layout==2) || ($display_main_slideshow==0 && $homepage_layout==1) )? 'offset-top-0' : 'offset-top-30'; echo ($homepage_layout==2)? ' content-sm' : ' content'; ?>">
	<div class="centerBoxWrapper <?php echo $randprod_style.'-view'; ?>" id="RandomProducts">
		<?php if($homepage_layout!=2 || ($homepage_layout==2  && $randprod_style!='default' ) ){ ?>
		<div class="<?php echo ($randprod_style=="slider")? 'container-fluid' : 'container'; ?>">
		<?php } ?>
			<?php
			  require($template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php');
			?>
		<?php if($homepage_layout!=2 || ($homepage_layout==2  && $randprod_style!='default' ) ){ ?>
		</div>
		<?php } ?>
	</div>
</section>
<?php } ?>
<!-- eof: random products -->
