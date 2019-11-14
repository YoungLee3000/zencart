<?php
/**
 * Common Template - tpl_main_page.php
 *
 * Governs the overall layout of an entire page<br />
 * Normally consisting of a header, left side column. center column. right side column and footer<br />
 * For customizing, this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * - make a directory /templates/my_template/privacy<br />
 * - copy /templates/templates_defaults/common/tpl_main_page.php to /templates/my_template/privacy/tpl_main_page.php<br />
 * <br />
 * to override the global settings and turn off columns un-comment the lines below for the correct column to turn off<br />
 * to turn off the header and/or footer uncomment the lines below<br />
 * Note: header can be disabled in the tpl_header.php<br />
 * Note: footer can be disabled in the tpl_footer.php<br />
 * <br />
 * $flag_disable_header = true;<br />
 * $flag_disable_left = true;<br />
 * $flag_disable_right = true;<br />
 * $flag_disable_footer = true;<br />
 * <br />
 * // example to not display right column on main page when Always Show Categories is OFF<br />
 * <br />
 * if ($current_page_base == 'index' and $cPath == '') {<br />
 *  $flag_disable_right = true;<br />
 * }<br />
 * <br />
 * example to not display right column on main page when Always Show Categories is ON and set to categories_id 3<br />
 * <br />
 * if ($current_page_base == 'index' and $cPath == '' or $cPath == '3') {<br />
 *  $flag_disable_right = true;<br />
 * }<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Fri Jan 8 14:09:25 2016 -0500 Modified in v1.5.5 $
 */

/** bof DESIGNER TESTING ONLY: */
// $messageStack->add('header', 'this is a sample error message', 'error');
// $messageStack->add('header', 'this is a sample caution message', 'caution');
// $messageStack->add('header', 'this is a sample success message', 'success');
// $messageStack->add('main', 'this is a sample error message', 'error');
// $messageStack->add('main', 'this is a sample caution message', 'caution');
// $messageStack->add('main', 'this is a sample success message', 'success');
/** eof DESIGNER TESTING ONLY */

  if (in_array($current_page_base,explode(",",'products_new,products_all,specials,featured_products,checkout_shipping_address,checkout_payment,checkout_shipping,checkout_payment_address,checkout_confirmation,advanced_search_result,password_forgotten,account,account_history,account_history_info,account_edit,address_book,address_book_process,account_password,account_newsletters,account_notifications,gv_faq,gv_redeem,discount_coupon,advanced_search,checkout_success,time_out,page_not_found,product_reviews_write,reviews,product_reviews,product_reviews_info,logoff,create_account_success,wishlist,wishlist_email,wishlist_find,wishlists,wishlist_edit,wishlist_move,news_archive,more_news,testimonials_manager,display_all_testimonials,testimonials_add'))) {
	if($homepage_layout==1){
		$flag_disable_left = true;
	}else if($homepage_layout==2){
		$flag_disable_right = true;
	}
  }

	if (in_array($current_page_base,explode(",",'product_info,product_music_info,login,create_account,shopping_cart,contact_us,compare,down_for_maintenance,product_free_shipping_info,document_general_info,document_product_info'))){
		if($homepage_layout==2){
			$flag_disable_left = false;
			$flag_disable_right = true;
		}
		else {
			$flag_disable_left = true;
			$flag_disable_right = true;
		}
	}
	if(in_array($current_page_base,explode(",",'manufacturers_all')) && $homepage_layout==1 ) {
		$flag_disable_left = true;
	}else if(in_array($current_page_base,explode(",",'manufacturers_all')) && $homepage_layout==2 ) {
		$flag_disable_right = true;
	}
	if(($current_page_base == 'index' and $_GET['cPath'] != '') && $homepage_layout==1 ){
		$flag_disable_left = true;
	}else if(($current_page_base == 'index' and $_GET['cPath'] != '') && $homepage_layout==2 ){
		$flag_disable_right = true;
	}
	
	if (($current_page_base == 'index' and $_GET['manufacturers_id'] != '') && $homepage_layout==1 ) {
		$flag_disable_left = true;
	}else if (($current_page_base == 'index' and $_GET['manufacturers_id'] != '') && $homepage_layout==2 ) {
		$flag_disable_right = true;
	}
	
	if ($this_is_home_page) { 
		if($homepage_layout==2){
			$flag_disable_left = false;
		}else{
			$flag_disable_left = true;
		}
		$flag_disable_right = true;
	}
	$header_template_v1 = 'tpl_header_v1.php';
	$header_template_v2 = 'tpl_header_v2.php';
	$header_template_v3 = 'tpl_header_v3.php';
	$header_template_v4 = 'tpl_header_v4.php';
	$header_template_v5 = 'tpl_header_v5.php';
	$header_template_v6 = 'tpl_header_v6.php';
	$header_template_v7 = 'tpl_header_v7.php';
	$header_template_v8 = 'tpl_header_v8.php';
	$header_template_v9 = 'tpl_header_v9.php';
	$header_template_v10 = 'tpl_header_v10.php';
	$header_template_v11 = 'tpl_header_v11.php';
  
	$footer_template = 'tpl_footer.php';
	$left_column_file = 'column_left.php';
	$right_column_file = 'column_right.php';
	$body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
	$body_class='';
	if($homepage_layout==2){ $body_class='two-columns-home';}else if($homepage_layout==1 && $this_is_home_page){ $body_class='full-width-home';};
	if($theme_font_size==1){ $body_class.=' fnt-small'; }else if($theme_font_size==2){ $body_class.=' fnt-medium';}
	
?>
<body id="<?php echo $body_id . 'Body'; ?>"<?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?> class="<?php echo $body_class; ?>">
	<?php if($page_loader!='none'){?>
		<?php if(($page_loader=="default") || ($page_loader=='custom' && $page_loader_custom=='')){ ?>
		<div id="loader-wrapper">
			<div id="loader">
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
			</div>
		</div>
		<?php } else{ ?>
		<div id="loader-wrapper">
			<div id="loader">
				<img src="<?php echo $uploads_path.$page_loader_custom; ?>" width="" height="" />
			</div>
		</div>
		<?php } ?>
	<?php } ?>
	<div id="fb-root"></div>
	<script type="text/javascript">(function(d, s, id){var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
	<?php
	/**
	* prepares and displays header output
	*
	*/
	if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
	  $flag_disable_header = true;
	}
	if (in_array($current_page_base,explode(",",'down_for_maintenance'))){
		require($template->get_template_dir('tpl_header_maintenance.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_header_maintenance.php');
	}else if($header_style=="header_style_1") {
		require($template->get_template_dir($header_template_v1,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v1);
	}elseif($header_style=="header_style_2" ){
		require($template->get_template_dir($header_template_v2,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v2);
	}elseif($header_style=="header_style_3"){
		require($template->get_template_dir($header_template_v3,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v3);
 	}elseif($header_style=="header_style_4"){
		require($template->get_template_dir($header_template_v4,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v4);
 	}elseif($header_style=="header_style_5"){
		require($template->get_template_dir($header_template_v5,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v5);
	}elseif($header_style=="header_style_6"){
		require($template->get_template_dir($header_template_v6,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v6);
	}elseif($header_style=="header_style_7"){
		require($template->get_template_dir($header_template_v7,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v7);
	}elseif($header_style=="header_style_8"){
		require($template->get_template_dir($header_template_v8,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v8);
	}elseif($header_style=="header_style_9"){
		require($template->get_template_dir($header_template_v9,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v9);
	}elseif($header_style=="header_style_10"){
		require($template->get_template_dir($header_template_v10,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v10);
	}elseif($header_style=="header_style_11"){
		require($template->get_template_dir($header_template_v11,DIR_WS_TEMPLATE, $current_page_base,'common'). '/' . $header_template_v11);
	}
	?>
	<?php /*=========================================Main Slideshow for full width ==================================================*/ ?>
	<?php if ($this_is_home_page && $homepage_layout!=2) { 
		include($template->get_template_dir('define_main_slideshow.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_main_slideshow.php');
	} ?>
	<?php /*=========================================EOF Main Slideshow for full width ==================================================*/ ?>
	<?php /*=========================================Random Products for full width ==================================================*/ ?>
	<?php if ($this_is_home_page && $homepage_layout!=2 && $home_randproslider==1) { require($template->get_template_dir('tpl_modules_pzen_random_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_pzen_random_products.php');  } ?>
	<?php /*=========================================EOF Random Products for full width ==================================================*/ ?>
    <div id="pageContent">
    <!--Top Categories Banner-->
	<?php if ($this_is_home_page) { ?>
		<?php /*========================================= Top Banner for Full width ==================================================*/ ?>
		<?php if ($display_top_banners==1 && $homepage_layout==1) { ?>
			<?php if($top_banners_style=='1') { ?>
			<section class="<?php if($top_banners_layout==2 && $home_randproslider==0){ echo 'content offset-top-0 fullwidth indent-col-none';} else if($top_banners_layout==2 && $home_randproslider==1){echo 'content fullwidth indent-col-none'; }else{ echo 'content'; } ?>">
			<?php echo '<div class="container">'; ?>
				<div class="row">
					<div class="category-carousel box-baners">
						<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
					</div>
				</div>
			<?php echo '</div>'; ?>
		</section>
		<?php }elseif($top_banners_style=="2") { ?>
        <section class="container-fluid box-baners">
			<?php echo ($top_banners_layout==1)? '<div class="container">' : ''; ?>
				<div class="row">
					<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
				</div>
			<?php echo ($top_banners_layout==1)? '</div>' : ''; ?>
		</section>
		<?php } elseif($top_banners_style=="3") { ?>
		<section class="container-fluid box-baners">
			<?php echo ($top_banners_layout==1)? '<div class="container">' : ''; ?>
				<div class="row">
					<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
				</div>
			<?php echo ($top_banners_layout==1)? '</div>' : ''; ?>
		</section>
		<?php } elseif($top_banners_style=="4") { ?>
		<section class="<?php echo ($top_banners_layout==2) ? 'content offset-top-0 fullwidth indent-col-none' : 'content-md'; ?>">
			<?php echo ($top_banners_layout==1)? '<div class="container">' : ''; ?>
				<div class="row">
					<?php require($template->get_template_dir('define_top_banner.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_top_banner.php'); ?>
				</div>
			<?php echo ($top_banners_layout==1)? '</div>' : ''; ?>
		</section>
		<?php } ?>
		<?php } ?>
		<?php /*========================================= EOF Top Banner for Full width ==================================================*/ ?>
    <?php } ?>
	<!--Top Categories Banner Ends-->
    <?php if(!$this_is_home_page) { ?>
	<section class="content" style="margin:0">
	<?php /*========================================= Breadcrumb ==================================================*/ ?>
	<?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page) ) { ?>
	<!-- Breadcrumb Container -->
		<section class="breadcrumbs <?php echo (in_array($header_style,array('header_style_2','header_style_3','header_style_6','header_style_7','header_style_9')))? "no-border" : ''; ?>">
			<div class="<?php echo $container_class; ?>">
				<div class="breadcrumb-inner">
					<ol class="breadcrumb breadcrumb--ys pull-left"><?php echo str_replace('<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . HEADER_TITLE_CATALOG . '</a>','<li class="home-link"><a href="' . HTTPS_SERVER . DIR_WS_CATALOG . '">' . HEADER_TITLE_CATALOG . '</a></li>',$breadcrumb->trail("<li>")); ?></ol>
				</div>
            </div>
		</section>
	<!-- Breadcrumb Container Ends -->
	<?php } ?>
	<?php /*=========================================EOF Breadcrumb ==================================================*/ ?>
    <?php } ?>
	<?php /*========================================= Contact Us ==================================================*/ ?>
	<?php if (in_array($current_page_base,explode(",",',contact_us')) && $store_map!='') { ?>
		<section class="content-bottom">
			<div class="contact-map" id="map">
				<?php echo $store_map; ?>
			</div>
		</section>
	<?php } ?>
	<?php /*========================================= EOF Contact Us ==================================================*/ ?>
	<?php	if (COLUMN_LEFT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
	// global disable of column_left
	$flag_disable_left = true;
	}?>
	<?php if (COLUMN_RIGHT_STATUS == 0 || (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_RIGHT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))) {
	// global disable of column_right
	$flag_disable_right = true;
	}?>
	<?php 
		$main_wrapper_class='';
		if($flag_disable_right==false && $flag_disable_left==false){
			$main_wrapper_class='three-columns';
		}else if($flag_disable_left==true && $flag_disable_right==false){
			$main_wrapper_class='two-columns-left';
		}else if($flag_disable_left==false && $flag_disable_right==true){
			$main_wrapper_class='two-columns-right';
		}else if($flag_disable_left==true && $flag_disable_right==true){
			$main_wrapper_class='single-column';
		}
	?>
	<!-- Main Content Wrapper -->
		<div class="<?php echo $container_class; ?> <?php echo $main_wrapper_class; ?>">
			<div class="row">
				<div id="contentarea-wrapper">
					<?php if($flag_disable_left == true && $flag_disable_right == true ) { ?>
					<div id="centercontent-wrapper" class="col-lg-12 single-column">
					<?php } elseif($flag_disable_left == true) { ?> 
					<div id="centercontent-wrapper" class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-10 columnwith-right centerColumn pull-left"> 
					<?php } elseif($flag_disable_right == true) { ?> 
					<div id="centercontent-wrapper" class="col-xs-12 col-sm-12 col-md-8 col-lg-9 col-xl-10 columnwith-left centerColumn pull-right">
					<?php }else { $class_name = 'three-columns'; ?> 
					<div id="centercontent-wrapper" class="col-md-8 col-lg-6 col-xl-8 noleft-margin two-column centerColumn">
					<?php } ?>
					<?php if (SHOW_BANNERS_GROUP_SET1 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET1)){
						if ($banner->RecordCount() > 0) {?>
						<div id="bannerOne" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
						<?php }
					} ?>	
					<?php if ($messageStack->size('upload') > 0) echo $messageStack->output('upload'); ?>
					<?php /*=========================================Body Code ==================================================*/ ?>
							<?php require($body_code); ?>
					<?php /*=========================================EOF Body Code ==================================================*/ ?>
					<?php if (SHOW_BANNERS_GROUP_SET4 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET4)) {
						if ($banner->RecordCount() > 0) { ?>
							<div id="bannerFour" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
						<?php }
						} ?> 
					</div>
					<?php /*========================================= Left Column ==================================================*/ ?>
					<?php if (!isset($flag_disable_left) || !$flag_disable_left) {
							if($flag_disable_right == true) { ?>
							<aside id="left-column" class="col-xs-12 col-sm-12 col-md-4 col-lg-3 col-xl-2 pull-left leftColumn <?php echo $class_name; ?>">	
							<?php } else { ?>
							<aside id="left-column" class="col-md-4 col-lg-3 col-xl-2 pull-left leftColumn <?php echo $class_name; ?>">	
							<?php } ?>
							<?php /**
								* prepares and displays left column sideboxes
								*
								*/
							?>
							<?php if($homepage_layout==2 && $sidebar_catmenu_status!=0 ){ require($template->get_template_dir('tpl_drop_menu_sidebar.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_drop_menu_sidebar.php'); } ?>
							<?php require(DIR_WS_MODULES . zen_get_module_directory('column_left.php')); ?>
							</aside>
					<?php }	?>	
					<?php /*=========================================EOF Left Column ==================================================*/ ?>
					<?php /*=========================================Right Column ==================================================*/ ?>
					<?php if (!isset($flag_disable_right) || !$flag_disable_right) {
							if($flag_disable_left == true) { ?>
							<aside id="right-column" class="col-md-4 col-lg-3 col-xl-2 hidden-xs hidden-sm pull-right rightColumn">
							<?php } else { ?>
							<aside id="right-column" class="col-md-4 col-lg-3 col-xl-2 hidden-xs hidden-sm hidden-md pull-right rightcolumnwl rightColumn">
							<?php } /**
								  * prepares and displays right column sideboxes
								  *
								  */
								?>
							<?php require(DIR_WS_MODULES . zen_get_module_directory('column_right.php')); ?>
							</aside>
					<?php } ?>
					<?php /*=========================================EOF Right Column ==================================================*/ ?>
				</div>
			</div>
		</div>
   <?php  /**
	  * prepares and displays footer output
	  *
	  */
	  if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_FOOTER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
		$flag_disable_footer = true;
	  }
		if (in_array($current_page_base,explode(",",'down_for_maintenance'))){
			require($template->get_template_dir('tpl_footer_maintenance.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer_maintenance.php');
		}else{
			require($template->get_template_dir('tpl_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer.php');
		}
	?>
	<?php if (DISPLAY_PAGE_PARSE_TIME == 'true') {?>
	<!--bof- parse time display -->
	<div class="smallText center">Parse Time: <?php echo $parse_time; ?> - Number of Queries: <?php echo $db->queryCount(); ?> - Query Time: <?php echo $db->queryTime(); ?></div>
	<!--eof- parse time display -->
	<?php } ?>
	<!--bof- banner #6 display -->
	<?php
	  if (SHOW_BANNERS_GROUP_SET6 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET6)) {
		if ($banner->RecordCount() > 0) {
	?>
	<div id="bannerSix" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
	<?php } ?>
	<!--eof- banner #6 display -->
	<?php } ?>
	<?php /* add any end-of-page code via an observer class */
		$zco_notifier->notify('NOTIFY_FOOTER_END', $current_page);
	?>
	<?php
	/**                                                                                                                                                                                                       
	* load the loader JS files
	*/
	//print_r($RC_loader_files['jscript'] );exit;
	if(!empty($RC_loader_files)){
	  foreach($RC_loader_files['jscript'] as $file)
		if($file['include']) {
		  include($file['src']);
		} else if(!$RI_CJLoader->get('minify_js') || $file['external']) {
		  echo '<script type="text/javascript" src="'.$file['src'].'"></script>'."\n";
		} else {
		  echo '<script type="text/javascript" src="min/?f='.$file['src'].'&'.$RI_CJLoader->get('minify_time').'"></script>'."\n";
		}
	}
	//DEBUG: echo '';
	?>
</body>