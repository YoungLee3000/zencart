<?php /*========================================= Category 1 ==================================================*/ ?>
<?php if($display_category==1) { ?>
<section class="<?php echo ($homepage_layout==1)? "content" : "content-sm"; ?> cat-style-2">
	<?php echo ($homepage_layout==1)? '<div class="container">' : ''; ?>
		<?php $category_title = zen_get_categories_name((int)$featured_category_1); ?>
		<h2 class="text-left text-uppercase title-under"><?php echo $category_title; ?></h2>
		<div class="row">						
			<div class="<?php echo ($homepage_layout==2)? "col-xl-4 col-lg-5 col-md-5 col-sm-8 col-xs-12" : "col-xl-4 col-lg-6 col-md-6 col-sm-8 col-xs-12"; ?>">
				<a href="javascript:void(0);" class="banner zoom-in">
					<span class="figure">
						<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$category_banner_1;?>" width="auto" height="auto" alt="" title="" />
						<span class="figcaption">
							<span class="block-table">
								<span class="block-table-cell">
									<?php echo $category_caption_1; ?>
								</span>
							</span>
						</span>
					</span>
				</a>
			</div>
			<div class="divider divider--lg visible-xs"></div>
			<div class="<?php echo ($homepage_layout==2)? "col-xl-8 col-lg-7 col-md-7 col-sm-4 col-xs-12" : "col-xl-8 col-lg-6 col-md-6 col-sm-4 col-xs-12"; ?>">
				<?php require($template->get_template_dir('tpl_modules_whats_new_reloaded.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new_reloaded.php'); ?>
			</div>
		</div>
	<?php echo ($homepage_layout==1)? '</div>' : ''; ?>
</section>
<section class="<?php echo ($homepage_layout==1)? "content" : "content-sm"; ?> cat-style-2">
	<?php echo ($homepage_layout==1)? '<div class="container">' : ''; ?>
		<?php $category_title = zen_get_categories_name((int)$featured_category_2); ?>
		<h2 class="text-left text-uppercase title-under">
			<?php echo $category_title; ?>
		</h2>
		<div class="row">
			<div class="<?php echo ($homepage_layout==2)? "col-xl-4 col-lg-5 col-md-5 col-sm-8 col-xs-12" : "col-xl-4 col-lg-6 col-md-6 col-sm-8 col-xs-12"; ?>">
				<a href="javascript:void(0);" class="banner zoom-in">
					<span class="figure">
						<img src="<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$category_banner_2;?>" width="auto" height="auto" alt="" title="" />
						<span class="figcaption">
							<span class="block-table">
								<span class="block-table-cell">
									<?php echo $category_caption_2; ?>
								</span>
							</span>
						</span>
					</span>
				</a>
			</div>
			<div class="divider divider--lg visible-xs"></div>
			<div class="<?php echo ($homepage_layout==2)? "col-xl-8 col-lg-7 col-md-7 col-sm-4 col-xs-12" : "col-xl-8 col-lg-6 col-md-6 col-sm-4 col-xs-12"; ?>">
				<?php require($template->get_template_dir('tpl_modules_specials_default_reloaded.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default_reloaded.php'); ?>
			</div>
		</div>
	<?php echo ($homepage_layout==1)? '</div>' : ''; ?>
</section>
<?php } ?>
<?php /*========================================= EOF Category 1 ==================================================*/ ?>
<?php /*========================================= Bottom Banner ==================================================*/ ?>
<?php if($display_bottom_banners==1) {
	require($template->get_template_dir('define_bottom_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_bottom_banner.php');
} ?>
<?php /*=========================================EOF Bottom Banner ==================================================*/ ?>