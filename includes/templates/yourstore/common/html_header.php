<?php
/**
 * Common Template
 *
 * outputs the html header. i,e, everything that comes before the \</head\> tag <br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: rbarbour zcadditions.com Fri Feb 12 17:13:56 2016 -0500 New in v1.5.5 $
 */
/**PZENTEMPLATE_BRAND**/

$zco_notifier->notify('NOTIFY_HTML_HEAD_START', $current_page_base, $template_dir);

// Prevent clickjacking risks by setting X-Frame-Options:SAMEORIGIN
header('X-Frame-Options:SAMEORIGIN');

/**
 * load the module for generating page meta-tags
 */
require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
/**
 * output main page HEAD tag and related headers/meta-tags, etc
 */
 
$theme_layout=(get_pzen_options('theme_layout')) ? get_pzen_options('theme_layout') : '1' ;
$display_main_slideshow = get_pzen_options('display_main_slideshow');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo META_TAG_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
<meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
<meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="author" content="<?php echo STORE_NAME ?>" />
<meta name="generator" content="shopping cart program by Zen Cart&reg;, http://www.zen-cart.com eCommerce" />
<?php if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base,explode(",",constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base=='down_for_maintenance' || $robotsNoIndex === true) { ?>
<meta name="robots" content="noindex, nofollow" />
<?php } ?>
<?php if(get_pzen_options('file_favicon')){ ?>
<link rel="icon" href="<?php echo $template->get_template_dir(get_pzen_options('file_favicon'),DIR_WS_TEMPLATE, $current_page_base,'images/uploads').'/'.get_pzen_options('file_favicon'); ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $template->get_template_dir(get_pzen_options('file_favicon'),DIR_WS_TEMPLATE, $current_page_base,'images/uploads').'/'.get_pzen_options('file_favicon'); ?>" type="image/x-icon" />
<?php }else{ ?>
	<?php if (defined('FAVICON')){?>
<link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
	<?php }?>
<?php } ?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>" />
<?php if (isset($canonicalLink) && $canonicalLink != '') { ?>
<link rel="canonical" href="<?php echo $canonicalLink; ?>" />
<?php } ?>
<?php
// BOF hreflang for multilingual sites
if (!isset($lng) || (isset($lng) && !is_object($lng))) {
  $lng = new language;
}
reset($lng->catalog_languages);
if (sizeof($lng->catalog_languages) > 1) {
  while (list($key, $value) = each($lng->catalog_languages)) {
    echo '<link rel="alternate" href="' . ($this_is_home_page ? zen_href_link(FILENAME_DEFAULT, 'language=' . $key, $request_type, false) : $canonicalLink . (strpos($canonicalLink, '?') ? '&amp;' : '?') . 'language=' . $key) . '" hreflang="' . $key . '" />' . "\n";
  }
}
// EOF hreflang for multilingual sites
?>
<!-- Theme File for Color -->
<!--CSS files Ends-->
<?php
/**
* load the loader files
*/
$RC_loader_files = array();
if($RI_CJLoader->get('status') && (!isset($Ajax) || !$Ajax->status())){
    $RI_CJLoader->autoloadLoaders();
    $RI_CJLoader->loadCssJsFiles();
    $RC_loader_files = $RI_CJLoader->header();

    if (!empty($RC_loader_files['meta']))
    foreach($RC_loader_files['meta'] as $file) {
        include($file['src']);
        echo "\n";
    }
	//print_r($RC_loader_files['css']);exit;
    if (!empty($RC_loader_files['css']))
    foreach($RC_loader_files['css'] as $file){
        if($file['include']) {
            include($file['src']);
        } else if (!$RI_CJLoader->get('minify_css') || $file['external']) {
            //$link = $file['src'];
            echo '<link rel="stylesheet" type="text/css" href="'.$file['src'] .'" />'."\n";
        } else {
            //$link = 'min/?f='.$file['src'].'&amp;'.$RI_CJLoader->get('minify_time');
            echo '<link rel="stylesheet" type="text/css" href="min/?f='.$file['src'].'&amp;'.$RI_CJLoader->get('minify_time').'" />'."\n";
        }
    } 
}
//DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';
?>
<?php require($template->get_template_dir('tpl_template_custom_css.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_template_custom_css.php'); ?>
<!-- Google Jquery -->
<script src="<?php  echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'external/jquery').'/jquery-2.1.4.min.js'?>" type="text/javascript"></script>
<?php 
  $zco_notifier->notify('NOTIFY_HTML_HEAD_END', $current_page_base);
?>
</head>
<?php // NOTE: Blank line following is intended: ?>

