<?php
/**
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 3183 2006-03-14 07:58:59Z birdbrain $
 */
?>
<?php
if (!$flag_disable_footer){
	$cat_slide = "select * from ".DB_PREFIX."manufacturers ORDER BY RAND()";
	$manufactureimage = $db->Execute($cat_slide);

	if($homepage_layout=='homepage_layout_3' || $display_featured_products_style=='display_style_1') {
		$featured_class="col-lg-9 col-md-8";
	}
	else {
		$featured_class="col-lg-12 col-md-12";
	}
	
	if($homepage_layout=='homepage_layout_1' || $homepage_layout=='homepage_layout_2') {
		$strip_class="strip strip-no-bg";
	}
	elseif($bottom_banners_style=="2") {
		$strip_class="strip strip-right-left";
	}
	else {
		$strip_class="strip";
	}
?>
<?php if($display_middle_banner==1 && $this_is_home_page) { ?>
<!--=== box-baners ===-->
<section class="container-fluid box-baners content">
	<div class="row">					
		<div class="col-xs-12">
			<!-- banner -->
			<div class="banner banner-bg image-bg zoom-in" data-image="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$middle_banner_image;?>">
				<span class="figure">
					<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$middle_banner_image;?>" width="auto" height="auto" alt="<?php echo TEXT_BANNER; ?>" title="" />
					<?php echo $middle_banner_caption; ?>
				</span>
			</div>
			<!-- /banner -->						
		</div>				
	</div>
</section>
<!--=== /box-baners ===-->
<?php } ?>
<?php //echo ($homepage_layout==2) ? '<hr class="hr-md">' : ''; ?>
<?php if($saf_display_style=='split' && $this_is_home_page && (SHOW_PRODUCT_INFO_MAIN_FEATURED_PRODUCTS > 0) && (SHOW_PRODUCT_INFO_MAIN_SPECIALS_PRODUCTS > 0) && (($fproducts_display_style=='slider' && $sproducts_display_style=='slider')) ) { ?>
	<section class="<?php echo ($homepage_layout==1)? "content" : "content-sm"; ?>" >
		<?php echo ($homepage_layout==1)? '<div class="container">' : ''; ?>
            <div class="row">
            	<?php
				$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_MAIN);
				while (!$show_display_category->EOF) {
				  // //  echo 'I found ' . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS);
				?>
					<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MAIN_FEATURED_PRODUCTS') { ?>
					<?php if($homepage_layout==1){?>
					<div class="col-sm-12 col-md-6 col-xl-6">
						<div class="divider--lg visible-sm visible-xs"></div>
					<?php }else{ ?>
					<div class="col-sm-12 col-md-8 col-xl-7">
					<?php } ?>
                    <?php
                    /**
                     * display the Featured Products Center Box
                     */
                    ?>
                    <?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php'); ?>
					</div>
                    <?php } ?>
					<?php if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MAIN_SPECIALS_PRODUCTS') { ?>
					<?php if($homepage_layout==1){?>
					<div class="divider divider--lg hidden  visible-sm visible-xs"></div>	
					<div class="col-sm-12 col-md-6 col-xl-6">
					<?php }else{ ?>
					<div class="col-sm-12 col-md-4 col-xl-5">
					<?php } ?>
						<?php
						/**
						 * display the Special Products Center Box
						 */
						?>
						<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php'); ?>
					</div>
                    <?php } ?>
				
                <?php
				  $show_display_category->MoveNext();
				} // !EOF
				?>
           	</div>
            <?php if($border_width != NULL && $this_is_home_page) { ?>
			<?php if($saf_display_style == "split") { ?>
			<section class="content separator-section">
				<div class="<?php if($homepage_layout==1) { echo "container"; } else { echo "no-container"; } ?>">
					<hr>
				</div>
			</section>
			<?php } } ?>
		<?php echo ($homepage_layout==1)? '</div>' : ''; ?>
   	</section>
<?php } ?>
<?php /*========================================= Category Style 1 ==================================================*/ ?>
<?php 
if ($display_category_style == "display_style_1") { 
	require($template->get_template_dir('define_category_v1.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_category_v1.php');
} ?>
<?php /*========================================= EOF Category Style 1 ==================================================*/ ?>
<?php /*========================================= Category Style 2 ==================================================*/ ?>
<?php if ($display_category_style == "display_style_2") {
	require($template->get_template_dir('define_category_v2.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_category_v2.php');
} ?>
<?php /*========================================= EOF Category Style 2 ==================================================*/ ?>
<?php /*========================================= Latest News & Infobox & testimonials ==================================================*/ ?>
<?php if(($latest_newsbox_style==2 && ((int)NEWS_BOX_SHOW_CENTERBOX > 0)) && ($display_info_boxes==1 && $infoboxes_style=="display_style_3") && (DEFINE_TESTIMONIAL_STATUS ==1 && $testimonial_style==3) ){?>
<section class="<?php echo ($homepage_layout==1)? 'content lst_comb_sec' : 'content-sm lst_comb_sec'; ?>">
	<?php echo ($homepage_layout==1) ? '<div class="container">' : ''; ?>
		<div class="row">
			<?php if($latest_newsbox_style==2 && ((int)NEWS_BOX_SHOW_CENTERBOX > 0)){ ?>
			<div class="col-xs-12 col-sm-6 col-lg-6 col-xl-4">
				<?php require ($template->get_template_dir('tpl_modules_news_box_format.php', DIR_WS_TEMPLATE, $current_page_base, 'templates'). '/tpl_modules_news_box_format.php'); ?>
			</div>
			<?php } ?>
			<div class="divider divider--lg visible-xs"></div>
			<?php if($display_info_boxes==1 && $infoboxes_style=="display_style_3"){ ?>
			<div class="col-xs-12 col-sm-6 col-lg-6 col-xl-4">
				<?php include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CUSTOM_INFOBOXES_V7, 'false');?>
			</div>
			<?php } ?>
			<?php if(DEFINE_TESTIMONIAL_STATUS ==1 && $testimonial_style==3){ ?>
			<div class="col-xl-4 visible-xl">
				<?php echo pzen_testimonials(); ?>
			</div>
			<?php } ?>
		</div>
	<?php echo ($homepage_layout==1) ? '</div>' : ''; ?>
</section>
<?php } ?>
<?php /*========================================EOF Latest News & Infobox & testimonials ====================================*/ ?>
<?php /*========================================Testimonials Display style 1 & 2 only  ====================================*/ ?>
<?php if(DEFINE_TESTIMONIAL_STATUS ==1 && $testimonial_style!=3 ) { 
	echo pzen_testimonials();
 } ?>
<?php /*========================================EOF Testimonials Display style 1 & 2 only  ====================================*/ ?>
<?php /*================================= Latest News Display When Style 1 Selected ===============================*/ ?>
<?php 
	if($latest_newsbox_style==1){
		require ($template->get_template_dir('tpl_modules_news_box_format.php', DIR_WS_TEMPLATE, $current_page_base, 'templates'). '/tpl_modules_news_box_format.php');
	}
?>
<?php echo ($homepage_layout==2) ? '<hr class="hr-md offset-top">' : ''; ?>
<?php /*================================= EOF Latest News Display When Style 1 Selected ===============================*/ ?>
<?php /*=========================================== Brand Slider ========================================*/ ?>
<!--Brands Slider and Info Box Container -->    
<?php  include($template->get_template_dir('define_brands_slider.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_brands_slider.php'); ?>
<?php /*===========================================EOF Brand Slider ========================================*/ ?>
<?php /*================================= Infoboxes Display style 1 & 2 only ===============================*/ ?>
<?php if($display_info_boxes==1){
		if($infoboxes_style=="display_style_1"){
			include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CUSTOM_INFOBOXES_V1, 'false');
		}elseif($infoboxes_style=="display_style_2") {
			include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CUSTOM_INFOBOXES_V2, 'false');
		}
	} ?>
<?php /*================================= EOF Infoboxes Display style 1 & 2 only ===============================*/ ?>
<?php }?>