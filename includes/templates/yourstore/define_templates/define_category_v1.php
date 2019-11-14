<?php /*========================================= Bottom Banner==================================================*/ ?>
<?php if($display_bottom_banners==1) {
	require($template->get_template_dir('define_bottom_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_bottom_banner.php');
} ?>
<?php /*=========================================EOF Bottom Banner==================================================*/ ?>
<?php /*========================================= Category 1 ==================================================*/ ?>
<?php if($display_category==1) { ?>
<section class="<?php echo ($homepage_layout==1)? "content" : "content-sm"; ?> cat-style-1">
	<?php echo ($homepage_layout==1)? '<div class="container">' : ''; ?>
		<div class="row">
			<div class="<?php echo ($homepage_layout==2)? "col-sm-12 col-md-12 col-xl-12" : "col-sm-12 col-md-6 col-xl-4"; ?>">
				<?php require($template->get_template_dir('tpl_modules_whats_new_reloaded.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new_reloaded.php'); ?>
			</div>
			<!-- promo -->
			<div class="<?php echo ($homepage_layout==2)? 'hide' : 'col-xl-4 visible-xl'; ?>">
				<?php include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CATEGORIES_PROMOS, 'false');?>
			</div>
			<!-- /promo -->
			<div class="<?php echo ($homepage_layout==2)? "col-sm-12 col-md-12 col-xl-12" : "col-sm-12 col-md-6 col-xl-4"; ?>">
				<?php require($template->get_template_dir('tpl_modules_specials_default_reloaded.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default_reloaded.php'); ?>
			</div>
		</div>
	<?php echo ($homepage_layout==1)? '</div>' : ''; ?>
</section>
<?php } ?>
<?php /*========================================= EOF Category 1 ==================================================*/ ?>