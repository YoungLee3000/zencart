<?php
$current_page = $_GET['main_page'];
$this_is_home_page = ($current_page=='index' && (!isset($_GET['cPath']) || $_GET['cPath'] == '') && (!isset($_GET['manufacturers_id']) || $_GET['manufacturers_id'] == '') && (!isset($_GET['typefilter']) || $_GET['typefilter'] == '') );
$theme_layout = (get_pzen_options('theme_layout'))? get_pzen_options('theme_layout') : '0';
$theme_mode = (get_pzen_options('theme_mode'))? get_pzen_options('theme_mode') : '0';



 
//external files
$t_array = array();
$t_array = array(
	'conditions' => array('pages' => array('*')),
	'external_css_files' => array(
		'slick/slick.css' => -1000,
		'font/style.css' => -996,
		'rs-plugin/css/settings.css' => -995,
	),
	'css_files' => array(
		'templatecss.css' => -998,
		'devicecss.css' => -995,
	),
	'external_jscript_files' => array(
		'slick/slick.min.js' => 2501,
		'colorbox/jquery.colorbox-min.js' => 2502,
		'imagesloaded/imagesloaded.pkgd.min.js' => 2540,
		'bootstrap/bootstrap.min.js' => 2550,
	),
	'jscript_files' => array(
		'modernizr.js' => 2510,
		'pzen_instantSearch.js' => 2511,
		'template_custom.js' => 2560,
		'pzen_jscript_custom.php' => 3000,
	),
);

//set theme layout
if($theme_layout==1){
	$t_array['css_files']['custom_style.css'] = -997;
}else if($theme_layout==2){
	$t_array['css_files']['custom_style_dark.css'] = -997;
}

//set is rtl 
if(get_pzen_options('theme_mode')!='' && get_pzen_options('theme_mode')!=0 ){
	$t_array['css_files']['custom-style-rtl.css'] = 1000;
}

//set accordian js
if(!$this_is_home_page){
	$t_array['jscript_files']['jquery.dcjqaccordion.2.7.js'] = 2520;
}

//set grid layout
$products_grid_layouts = (get_pzen_options('products_grid_layouts'))? get_pzen_options('products_grid_layouts') : 'grid';
if($products_grid_layouts == 'masonary'){
	$t_array['jscript_files']['masonry.pkgd.min.js'] = 2530;
}

$loaders[] = $t_array;


//home page
$loaders[] = array(
		'conditions' => array('pages' => array('index_home')),
		'jscript_files' => array(
			'jquery.easing.1.3.js' => 2500,
		),
);


//home page main slideshow
$display_main_slideshow = (get_pzen_options('display_main_slideshow'))? get_pzen_options('display_main_slideshow') : '0';
if($display_main_slideshow==1){
	$loaders[] = array(
			'conditions' => array('pages' => array('index_home')),
			'external_css_files' => array(
				'rs-plugin/css/settings.css' => -999
			),
			'external_jscript_files' => array(
				'rs-plugin/js/jquery.themepunch.tools.min.js' => 2503,
				'rs-plugin/js/jquery.themepunch.revolution.min.js' => 2504,
			),
			'jscript_files' => array(
				'revolution_slider_custom.php' => 2505,
			),
	);
}

//product info page
$prodinfo_image_effects = (get_pzen_options('prodinfo_image_effects')) ? get_pzen_options('prodinfo_image_effects') : '1';
if($prodinfo_image_effects==1){
	$loaders[] = array(
			'conditions' => array('pages' => array('product_info')),
			'external_jscript_files' => array(
				'elevatezoom/jquery.elevatezoom.js' => 2016,
			),
	);
}