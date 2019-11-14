<?php
/**
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 3183 2006-03-14 07:58:59Z birdbrain $
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
?>
<?php
if (!$flag_disable_footer) { ?>
<?php 
if ($this_is_home_page && $homepage_layout==1){ 
	require($template->get_template_dir('tpl_footer_top.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer_top.php'); 
}?>
<?php echo ($homepage_layout==2) ? '<hr class="hr-md">' : ''; ?>
<?php if($display_instagram_feed==1) {
			include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_INSTAGRAM_FEED, 'false');
	} ?>
</div>
<!-- Footer Wrapper -->
<?php if($footer_style=='footer_style_4') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_4, 'false');
} elseif($footer_style=='footer_style_3') { 
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_3, 'false');
} elseif($footer_style=='footer_style_2') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_2, 'false');
}elseif($footer_style=='footer_style_1') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_1, 'false');
}elseif($footer_style=='footer_style_5') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_5, 'false');
}elseif($footer_style=='footer_style_6') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_6, 'false');
}elseif($footer_style=='footer_style_7') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_7, 'false');
}elseif($footer_style=='footer_style_8') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_8, 'false');
}elseif($footer_style=='footer_style_9') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_9, 'false');
}elseif($footer_style=='footer_style_10') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_10, 'false');
}elseif($footer_style=='footer_style_11') {
	include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_FOOTER_VERSION_11, 'false');
} ?>
<!-- Footer Wrapper -->
<?php } // flag_disable_footer ?>
<?php if($this_is_home_page && $display_popup_sec==1){ ?>
<?php  include zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/',FILENAME_DEFINE_NEWSLETTER_POPUP, 'false');?>
<?php } ?>
<?php if(file_exists($template->get_template_dir('define_demo_config.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_demo_config.php')){
	require($template->get_template_dir('define_demo_config.php',DIR_WS_TEMPLATE, $current_page_base,'define_templates'). '/define_demo_config.php');
} ?>