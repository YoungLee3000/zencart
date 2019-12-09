<?php
/**
 * Page Template
 *
 * Main index page<br />
 * Displays greetings, welcome text (define-page content), and various centerboxes depending on switch settings in Admin<br />
 * Centerboxes are called as necessary
 *
 * @package templateSystem
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_index_default.php 3464 2006-04-19 00:07:26Z ajeh $
 */
?>
<?php $show_cat_mainpage=false; ?>
<?php /*============================================ Topbanner for two columns =====================================================*/?>
<div class="centerColumn" id="indexDefault">
 <?php if ($this_is_home_page && $homepage_layout==2){ 
		include($template->get_template_dir('define_main_slideshow.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_main_slideshow.php');
	?>
	<?php if ($display_top_banners==1) { ?>
	<div class="<?php echo ($top_banners_layout==2) ? 'content-sm offset-top-0 indent-col-none col-md-12 col-lg-12 col-xl-12' : 'content-md'; echo ($display_main_slideshow==0)? ' offset-top-0' : ''; ?> ">
		<?php if($top_banners_style=='1') { ?>
		<div class="row">
			<div class="bannerCarousel box-baners">
				<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
			</div>
		</div>
		<?php }elseif($top_banners_style=="2") { ?>
		<div class="container-fluid box-baners">
			<div class="row">
				<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
			</div>
		</div>
		<?php } elseif($top_banners_style=="3") { ?>
		<div class="container-fluid box-baners">
			<div class="row">
				<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
			</div>
		</div>
		<?php } elseif($top_banners_style=="4") { ?>
		<div class="row">
			<div class="category-carousel">
				<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
<?php } ?>
<?php /*============================================ EOF Topbanner for two columns =====================================================*/?>
<?php /*============================================BOF Display Categories in main page =====================================================*/?>
<?php
if (SHOW_CATEGORIES_ALWAYS == 1)
{
  $show_cat_mainpage=true;
  if (PRODUCT_LIST_CATEGORY_ROW_STATUS == 0) {
    // do nothing
  } 
  elseif($main_categories_style=='custom' && $this_is_home_page) {
  	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CUSTOM_MAIN_CATEGORIES, 'false');
  }
  else { ?>
	<div class="divider"></div>
  <?php
  // display subcategories
	/**
	 * require the code to display the sub-categories-grid, if any exist
	 */
  require($template->get_template_dir('tpl_modules_category_row.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_category_row.php');
  }
}
?>
<?php /*============================================EOF Display Categories in main page =====================================================*/?>
<?php /*============================================ Random products display for homepage 2 coumns =====================================================*/?>
	<?php if ($this_is_home_page && $home_randproslider==1) {require_once($template->get_template_dir('tpl_modules_pzen_random_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_pzen_random_products.php');  } ?>
	<?php /*============================================EOF Random products display for homepage 2 coumns =====================================================*/?>

<?php if($this_is_home_page) { ?>
	<?php /*=========================================Top Main Define Page ==================================================*/ ?>
		<?php if(DEFINE_MAIN_PAGE_STATUS >= 1 and DEFINE_MAIN_PAGE_STATUS <= 2) { ?>
		<section class="content">
			<div id="indexDefaultMainContent" class="content">
				<div class="body-container">
					<?php require($define_page); ?>
				</div>
			</div>
		</section>
        <?php }  ?>
	<?php /*=========================================EOF Top Main Define Page ==================================================*/ ?>
	<?php } ?>


<?php /*============================================ Tabs Content =====================================================*/?>
<?php
$show_product_type='';
if($show_cat_mainpage==1){
	$show_product_type='SHOW_PRODUCT_INFO_CATEGORY';
}else{
	$show_product_type='SHOW_PRODUCT_INFO_MAIN';
}
$sql_show_products=constant("SQL_".$show_product_type);
$tabs_sec_ar=array();
$show_display_category = $db->Execute($sql_show_products);
while(!$show_display_category->EOF) {
	if ($show_display_category->fields['configuration_key'] == $show_product_type.'_BEST_SELLERS') {
		if($bproducts_display_style=='tabs'){$tabs_sec_ar['BestsellerTab']=TABLE_HEADING_BEST_SELLERS;}
	} 
	if($saf_display_style!='split' || ($fproducts_display_style!='slider' || $sproducts_display_style!='slider')  ) { 
		if ($show_display_category->fields['configuration_key'] == $show_product_type.'_FEATURED_PRODUCTS') { 
			if($fproducts_display_style=='tabs'){$tabs_sec_ar['FeaturedTab']=TABLE_HEADING_FEATURED_PRODUCTS;}
		} 
		if ($show_display_category->fields['configuration_key'] == $show_product_type.'_SPECIALS_PRODUCTS') { 
			if($sproducts_display_style=='tabs'){$tabs_sec_ar['SpecialsTab']=TABLE_HEADING_SPECIALS_INDEX; } 
		} 
	} 
	if ($show_display_category->fields['configuration_key'] == $show_product_type.'_NEW_PRODUCTS') { 
		if($nproducts_display_style=='tabs'){$tabs_sec_ar['whatsNewTab']=TABLE_HEADING_NEW_PRODUCTS;}
	}

	$show_display_category->MoveNext();
} 
?>
<?php if(!empty($tabs_sec_ar)){?>
<!--=== filter-carusel ===-->
<div class="<?php echo ($homepage_layout==2)? 'content two-cols-tabs' : 'content container'; ?>">
	<div class="row">
		<div class="col-xs-12">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-tabs--ys-center text-center" role="tablist">
				<?php 
				$i=0; 
				foreach($tabs_sec_ar as $k=>$v){
					echo '<li class="'.(($i==0)? 'active': '').'"><a href="#'.$k.'"  role="tab" data-toggle="tab" class="text-uppercase">'.$v.'</a></li>';
					$i++;
				}
				?>					
			</ul>
			<!-- Tab panes -->
			<div class="tab-content tab-content--ys-center">
				<?php 
				$i=0; 
				foreach($tabs_sec_ar as $k=>$v){
					echo '<div role="tabpanel" class="tab-pane '.(($i==0)? 'active': '').'" id="'.$k.'"></div>';
					$i++;
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php /*============================================ EOF Tabs Content =====================================================*/?>
<?php /*============================================ Products Listing =====================================================*/?>
<?php
  $show_display_category = $db->Execute($sql_show_products);
	while(!$show_display_category->EOF) {
  // //  echo 'I found ' . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS);
?>
<?php // bof - Best Sellers Reloaded v1.1 - aclarke - 2007-07-22 ?>
<?php if ($show_display_category->fields['configuration_key'] == $show_product_type.'_BEST_SELLERS') { ?>
	<?php //require($template->get_template_dir('tpl_modules_best_sellers_reloaded.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_best_sellers_reloaded.php'); ?>
<?php } ?>
<?php // eof - Best Sellers Reloaded v1.1 - aclarke - 2007-07-22 ?>
<?php if($saf_display_style!='split' || ($fproducts_display_style!='slider' || $sproducts_display_style!='slider')  ) {  ?>
	<?php if ($show_display_category->fields['configuration_key'] == $show_product_type.'_FEATURED_PRODUCTS') { ?>
	<?php
	/**
	 * display the Featured Products Center Box
	 */
	?>
	<?php //require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
	<?php } ?>
	<?php if ($show_display_category->fields['configuration_key'] == $show_product_type.'_SPECIALS_PRODUCTS') { ?>
	<?php
	/**
	 * display the Special Products Center Box
	 */
	?>
	<?php //require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
	<?php } ?>
<?php } ?>
<?php if ($show_display_category->fields['configuration_key'] == $show_product_type.'_NEW_PRODUCTS') { ?>
<?php
/**
 * display the New Products Center Box
 */
?>
<?php //require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php //if ($show_display_category->fields['configuration_key'] == $show_product_type.'_UPCOMING') { ?>
<?php //include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS)); ?><?php //} ?>
<?php
  $show_display_category->MoveNext();
} // !EOF
?>
<?php /*============================================ EOF Products Listing =====================================================*/?>
<?php /*============================================ Two Columns Footer Content =====================================================*/?>
<?php 
if ($this_is_home_page && $homepage_layout==2){
	require($template->get_template_dir('tpl_footer_top.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer_top.php'); 
}?>
<?php /*============================================ EOF Two Columns Footer Content =====================================================*/?>
</div>