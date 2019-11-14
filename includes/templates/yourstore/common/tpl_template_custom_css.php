<?php
/**PZENTEMPLATE_BRAND**/
?>
<?php 
$pzen_menu = pzen_categories_list();
$uploads_path=$template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/';
$homepage_layout=(get_pzen_options('homepage_layout')) ? get_pzen_options('homepage_layout') : '1' ;
$header_style = (get_pzen_options('header_style')) ? get_pzen_options('header_style') : 'header_style_1' ;
$footer_style = (get_pzen_options('footer_style')) ? get_pzen_options('footer_style') : 'footer_style_1' ;
$theme_btn_size = (get_pzen_options('theme_btn_size')) ? get_pzen_options('theme_btn_size') : '3' ;
$theme_font_size = (get_pzen_options('theme_font_size')) ? get_pzen_options('theme_font_size') : '3' ;
$general_font_family = (get_pzen_options('general_font_family')) ? get_pzen_options('general_font_family') : 'Ubuntu' ;
$bannercap_font_family = (get_pzen_options('bannercap_font_family')) ? get_pzen_options('bannercap_font_family') : 'Georgia' ;
$font_latin_charset_extended = (get_pzen_options('font_latin_charset_extended')) ? get_pzen_options('font_latin_charset_extended') : 0;
$font_custom_charset = get_pzen_options('font_custom_charset');
$sticky_header_menu=get_pzen_options('stiky_menu_type');
$page_loader=(get_pzen_options('page_loader')) ? get_pzen_options('page_loader') : 'default';
$page_loader_custom=get_pzen_options('page_loader_custom');
$products_grid_layouts = (get_pzen_options('products_grid_layouts'))? get_pzen_options('products_grid_layouts') : 'grid';

$main_categories_style = get_pzen_options('main_categories_style');
$full_width_slideshow = get_pzen_options('full_width_slideshow');
$slideshow_delay = get_pzen_options('slideshow_delay');
$container_class="container";
$paginateAsUL=true;
$slider_layout_class='';
$slideshow_container_class='';
if($header_style=='header_style_1') {
	$header_class = 'header-layout-01';
	$header_class.=($theme_layout==2) ? ' header-dark-custom' : '';
	$nav_container_class = "container offset-top-5";
	$navbar_class = "navbar";
	$slider_layout_class='content offset-top-0';
}
elseif($header_style=='header_style_2') {
	$header_class = 'header-layout-03';
	$nav_container_class = "container";
	$navbar_class = "navbar navbar-color-white";
}
elseif($header_style=='header_style_3') {
	$header_class = 'header-layout-04';
	$header_class.=($theme_layout==2 && !$this_is_home_page ) ? ' header-dark-custom' : '';
	$nav_container_class = "container";
	$navbar_class = "navbar";
	$slider_layout_class='content offset-top-0';
}
elseif($header_style=='header_style_4') {
	$header_class = 'header-layout-05';
	$header_class.=($theme_layout==2) ? ' header-dark-custom' : '';
	$nav_container_class = "container";
	$navbar_class = "navbar";
	$slider_layout_class='content offset-top-0 tp-banner-button1 slider-layout-3';
}
elseif($header_style=='header_style_5') {
	$header_class = 'header-layout-06';
	$header_class.=($theme_layout==2) ? ' header-dark-custom' : '';
	$nav_container_class = "container";
	$navbar_class = "navbar";
	$slider_layout_class='content offset-top-0 tp-banner-button1 slider-layout-5';
}elseif($header_style=='header_style_6') {
	$header_class = ($this_is_home_page)? 'header-layout-02 homepage ' : 'header-layout-03';
	$header_class.=($theme_layout==2) ? ' header-dark-custom' : '';
	$nav_container_class = "container";
	$navbar_class = ($this_is_home_page)? "navbar" : "navbar navbar-color-white";
	$slider_layout_class='offset-top-0';
}elseif($header_style=='header_style_7') {
	$header_class = 'header-layout-07';
	$nav_container_class = "container";
	$navbar_class = "navbar";
	$slideshow_container_class="container";
	$slider_layout_class='content offset-top-0';
}elseif($header_style=='header_style_8') {
	$header_class = 'header-layout-08';
	$header_class.=($theme_layout==2) ? ' header-dark-custom' : '';
	$nav_container_class = "container";
	$navbar_class = "navbar";
}elseif($header_style=='header_style_9') {
	$header_class = 'header-layout-03 fill-bg-dark';
	$nav_container_class = "container";
	$navbar_class = "navbar navbar-color-white";
}elseif($header_style=='header_style_10') {
	$header_class = 'header-layout-06';
	$header_class.=($theme_layout==2) ? ' header-dark-custom' : '';
	$nav_container_class = "container";
	$navbar_class = "navbar";
}

$footer_other_class='';
if(($theme_layout==2 && $header_style!='header_style_3') || ($header_style=='header_style_3' && (!$this_is_home_page)) ){
	$header_class.=' fill-bg-dark';
	$footer_other_class.='fill-bg';
}

$navbar_sidebar_class="navbar navbar-vertical mobile-menu-off";

$theme_color = get_pzen_options("theme_color");
$sidebar_catmenu_status=(get_pzen_options("sidebar_catmenu_status")!='') ? get_pzen_options("sidebar_catmenu_status") : 0 ;
$sidebarcat_menu_layout=(get_pzen_options("sidebarcat_menu_layout")!='') ? get_pzen_options("sidebarcat_menu_layout") : 1 ;
if($sidebarcat_menu_layout==2){
	$navbar_sidebar_class.=' fill-bg';
}


$logo_image = get_pzen_options('file_logo');
$flag_is_grid = $flag_products_grid_layouts = true;
if(((isset($_GET['view'])) && ($_GET['view']=='rows')) || (PRODUCT_LISTING_LAYOUT_STYLE=='rows' && (!isset($_GET['view'])))){
	$flag_is_grid = false;
}
/*=======================================
 * PRODUCTS LISTING
 *=======================================*/
if(($current_page_base == 'index' && ($_GET['cPath'] != '')) || ($current_page_base == 'index' and ($_GET['manufacturers_id'] != '')) || ($current_page_base == 'index' and ($_GET['typefilter'] != '') and ($_GET['music_genre_id'] != '')) || in_array($current_page_base, array('specials','featured_products','products_new','products_all','advanced_search_result' ))){
	$pzengrid_class=$pzengrid_data=$pzenitem_param='';
	
	if($products_grid_layouts=='grid'){
		$pzen_data_xl = (get_pzen_options('prodgrid_nums_cols_xl'))? get_pzen_options('prodgrid_nums_cols_xl') : 5;
		$pzen_data_lg = (get_pzen_options('prodgrid_nums_cols_lg'))? get_pzen_options('prodgrid_nums_cols_lg') : 3;
		$pzen_data_md = (get_pzen_options('prodgrid_nums_cols_md'))? get_pzen_options('prodgrid_nums_cols_md') : 2;
		$pzen_data_sm = (get_pzen_options('prodgrid_nums_cols_sm'))? get_pzen_options('prodgrid_nums_cols_sm') : 3;
		$pzen_data_xs = (get_pzen_options('prodgrid_nums_cols_xs'))? get_pzen_options('prodgrid_nums_cols_xs') : 2;
		$pzen_data_xxs = (get_pzen_options('prodgrid_nums_cols_xxs'))? get_pzen_options('prodgrid_nums_cols_xxs') : 1;
		
		$pzengrid_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
		//$pzengrid_class='pzen-xxs-'.$pzen_data_xxs.' pzen-xs-'.$pzen_data_xs.' pzen-sm-'.$pzen_data_sm.' pzen-md-'.$pzen_data_md.' pzen-lg-'.$pzen_data_lg.' pzen-xl-'.$pzen_data_xl;
		$pzenitem_param = 'class="pzen-item"';
	}
	if($products_grid_layouts=='masonary'){
		$pzenitem_param = 'class="mix mix_all grid-list" style="display: gblock;  opacity: 1;"';
	}
}
//EOF products listing----------------------------------------------------

/*=======================================
 * SPECIALS PAGE
 *=======================================*/
if($current_page_base == 'specials'){
	$specials_page_class = $spepage_container_data = '';
	if($products_grid_layouts=='grid'){
		$specials_page_class = 'pzen-item';
		$spepage_container_data = 'class="product-listing carousel-products-mobile product-grid pzen-prod-list '.$pzengrid_class.'" '.$pzengrid_data;
	}else{
		$spepage_container_data = 'class="carousel-products product-grid"';
	}
	
}

/*=======================================
 * FEATURED PAGE
 *=======================================*/
if($current_page_base == 'featured_products'){
	$feapage_item_class = $feapage_container_data = '';
	if($flag_is_grid==true){
		if($products_grid_layouts=='grid'){
			$feapage_item_class = 'pzen-item';
			$feapage_container_class = 'product-listing carousel-products-mobile product-grid pzen-prod-list';
			$feapage_container_data_data = $pzengrid_data;
		}else{
			$feapage_container_class = 'product-grid';
			$feapage_item_class = 'mix mix_all grid-list';
		}
		$feapage_container_data = 'class="section offer products-container portrait '.$feapage_container_class.'" data-layout="grid" '.$feapage_container_data_data;
	}else{
		$feapage_item_class = 'pzen-item';
		$feapage_container_data = 'class="section offer products-container portrait product-list" data-layout="list"';
	}
	
}
/*=======================================
 * NEW PRODUCTS PAGE
 *=======================================*/
if($current_page_base == 'products_new'){
	$newprodpage_item_class = $newprodpage_container_data = '';
	if($flag_is_grid==true){
		if($products_grid_layouts=='grid'){
			$newprodpage_item_class = 'pzen-item';
			$newprodpage_container_class = 'product-listing carousel-products-mobile product-grid pzen-prod-list';
			$newprodpage_container_data_data = $pzengrid_data;
		}else{
			$newprodpage_container_class = 'product-grid';
			$newprodpage_item_class = 'mix mix_all grid-list';
		}
		$newprodpage_container_data = 'class="section offer products-container portrait '.$newprodpage_container_class.'" data-layout="grid" '.$newprodpage_container_data_data;
	}else{
		$newprodpage_item_class = 'pzen-item';
		$newprodpage_container_data = 'class="section offer products-container portrait product-list" data-layout="list"';
	}
	
}
/*=======================================
 * PRODUCTS ALL PAGE
 *=======================================*/
if($current_page_base == 'products_all'){
	$allprodpage_item_class = $allprodpage_container_data = '';
	if($flag_is_grid==true){
		if($products_grid_layouts=='grid'){
			$allprodpage_item_class = 'pzen-item';
			$allprodpage_container_class = 'product-listing carousel-products-mobile product-grid pzen-prod-list';
			$allprodpage_container_data_data = $pzengrid_data;
		}else{
			$allprodpage_container_class = 'product-grid';
			$allprodpage_item_class = 'mix mix_all grid-list';
		}
		$allprodpage_container_data = 'class="section offer products-container portrait '.$allprodpage_container_class.'" data-layout="grid" '.$allprodpage_container_data_data;
	}else{
		$allprodpage_item_class = 'pzen-item';
		$allprodpage_container_data = 'class="section offer products-container portrait product-list" data-layout="list"';
	}
	
}
/*=======================================
 * RANDOM PRODUCTS
 *=======================================*/
$home_randproslider = (get_pzen_options('home_randproslider')) ? get_pzen_options('home_randproslider') : '0';
$randprod_style=(get_pzen_options('rand_products_display_style')) ? get_pzen_options('rand_products_display_style') : 'slider';
if($randprod_style=='default') {
	$parent_randtitle_class = 'text-center text-uppercase title-under';
	$randproduct_container_class = 'product-listing pzen-prod-list carousel-products-mobile row';
	$randproduct_container_id = '';
}
elseif($randprod_style=='slider') {
	$parent_randtitle_class = 'title-with-button';
	$randproduct_container_class = 'row';
	$randproduct_container_id = 'carouselHeader';
	if($homepage_layout==1){
		$parent_randtitle_h2_class='text-center text-uppercase title-under';
	}else{
		$parent_randtitle_h2_class='text-left text-uppercase title-default pull-left';
	}
}

//random products listing----------------------------------------------------
$pzen_randprod_index_class='';
$pzen_randprod_index_data='';
$pzen_data_xxs=12;
$pzen_data_xs=6;
if(SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS==2){
	$pzen_data_sm=6;
	$pzen_data_md=6;
	$pzen_data_lg=4;
	$pzen_data_xl=3;
}else if(SHOW_PRODUCT_INFO_COLUMNS_RANDOM_PRODUCTS==3){
	$pzen_data_sm=4;
	$pzen_data_md=4;
	$pzen_data_lg=4;
	$pzen_data_xl=3;
}else{
	$pzen_data_sm=4;
	$pzen_data_md=4;
	if(!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' )))){
		$pzen_data_lg=($theme_font_size==1) ? 3 : 4;
		$pzen_data_xl=($theme_font_size==1) ? 2 : 3;
	}else{
		$pzen_data_lg=3;
		$pzen_data_xl=2;
	}
}
if($randprod_style=='default') {
	$pzen_randprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	$pzen_randprod_index_class='col-xs-'.$pzen_data_xs.' col-sm-'.$pzen_data_sm.' col-md-'.$pzen_data_md.' col-lg-'.$pzen_data_lg.' col-xl-'.$pzen_data_xl;

}

/*=======================================
 * NEW PRODUCTS
 *=======================================*/
$nproducts_display_style = get_pzen_options('nproducts_display_style');
//if Tab view display slider in inner Product Listing
if($nproducts_display_style=='tabs' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ) || $current_page_base == 'shopping_cart')))){
	$nproducts_display_style = 'slider';
}

if(!$this_is_home_page) {
	$nproducts_display_style = 'slider';
}

if($nproducts_display_style=='default') {
	$parent_ntitle_class= ($homepage_layout==2)? 'title-box offset-top-30' : 'title-box';
	$parent_ntitle_h2_class = 'text-center text-uppercase title-under';
	$nproduct_container_class = 'product-listing carousel-products-mobile product-grid pzen-prod-list';
	$nproduct_container_id = '';
}
elseif($nproducts_display_style=='slider') {
	$parent_ntitle_class = 'title-with-button';
	$nproduct_container_class = 'carousel-products row';
	$nproduct_container_id = 'carouselNew';
	if($homepage_layout==1){
		$parent_ntitle_h2_class='text-center text-uppercase title-under';
	}else{
		$parent_ntitle_h2_class='text-left text-uppercase title-default pull-left';
	}
}
elseif($nproducts_display_style=='tabs') {
	$parent_ntitle_class='title-box';
	$parent_ntitle_h2_class = 'text-center text-uppercase title-under';
	$nproducttab_id='whatsNewTab';
	$nproduct_container_id = $nproducttab_id.'-content';
	$nproduct_container_class='carousel-products carouselTab slick-arrow-top  row';
}

//new products listing----------------------------------------------------
$pzen_newprod_index_class='';
$pzen_newprod_index_data='';
$pzen_data_xxs=1;
$pzen_data_xs=2;
if(SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS==2){
	$pzen_data_sm=2;
	$pzen_data_md=2;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else if(SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS==3){
	$pzen_data_sm=3;
	$pzen_data_md=3;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else{
	$pzen_data_sm=3;
	$pzen_data_md=3;
	if(!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' )))){
		$pzen_data_lg=($theme_font_size==1) ? 4 : 3;
		$pzen_data_xl=($theme_font_size==1) ? 6 : 5;
	}else{
		$pzen_data_lg=4;
		$pzen_data_xl=6;
	}
}

if($nproducts_display_style=='default' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ))))){
	if($products_grid_layouts=='masonary'){
		$pzen_newprod_index_class='mix mix_all grid-list';
	}else if($products_grid_layouts=='grid'){
		$pzen_newprod_index_class='pzen-item';
		$pzen_newprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}
}else{
	if($nproducts_display_style=='default') {
		$pzen_newprod_index_class='pzen-item';
		$pzen_newprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}else{
		$pzen_newprod_index_class='col-xs-'.$pzen_data_xs.' col-sm-'.$pzen_data_sm.' col-md-'.$pzen_data_md.' col-lg-'.$pzen_data_lg.' col-xl-'.$pzen_data_xl;
	}
	
}


/*=======================================
 * FEATURED PRODUCTS
 *=======================================*/
$fproducts_display_style = get_pzen_options('fproducts_display_style');
//if Tab view display slider in inner Product Listing
if($fproducts_display_style=='tabs' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ) || $current_page_base == 'shopping_cart')))){
	$fproducts_display_style = 'slider';
}

if($fproducts_display_style=='default') {
	$parent_ftitle_class='title-box';
	$parent_ftitle_h2_class = 'text-center text-uppercase title-under';
	$fproduct_container_class = 'product-listing carousel-products-mobile product-grid pzen-prod-list';
	$fproduct_container_id = '';
}
elseif($fproducts_display_style=='slider') {
	$parent_ftitle_class = 'title-with-button';
	$fproduct_container_class = 'carousel-products row';
	$fproduct_container_id = 'carouselFeatured';
	if($homepage_layout==1){
		$parent_ftitle_h2_class='text-center text-uppercase title-under';
	}else{
		$parent_ftitle_h2_class='text-left text-uppercase title-default pull-left';
	}
}
elseif($fproducts_display_style=='tabs') {
	$parent_ftitle_class='title-box';
	$parent_ftitle_h2_class = 'text-center text-uppercase title-under';
	$fproducttab_id='FeaturedTab';
	$fproduct_container_id = $fproducttab_id.'-content';
	$fproduct_container_class='carousel-products carouselTab slick-arrow-top  row';
}
//featured products listing----------------------------------------------------
$pzen_featuredprod_index_class='';
$pzen_featuredprod_index_data='';
$pzen_data_xxs=1;
$pzen_data_xs=2;
if(SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS==2){
	$pzen_data_sm=2;
	$pzen_data_md=2;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else if(SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS==3){
	$pzen_data_sm=3;
	$pzen_data_md=3;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else{
	$pzen_data_sm=3;
	$pzen_data_md=3;
	if(!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' )))){
		$pzen_data_lg=($theme_font_size==1) ? 4 : 3;
		$pzen_data_xl=($theme_font_size==1) ? 6 : 5;
	}else{
		$pzen_data_lg=4;
		$pzen_data_xl=6;
	}
}
if($fproducts_display_style=='default' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ))))){
	if($products_grid_layouts=='masonary'){
		$pzen_featuredprod_index_class='mix mix_all grid-list';
	}else if($products_grid_layouts=='grid'){
		$pzen_featuredprod_index_class='pzen-item';
		$pzen_featuredprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}
}else{
	if($fproducts_display_style=='default') {
		$pzen_featuredprod_index_class='pzen-item';
		$pzen_featuredprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}else{
		$pzen_featuredprod_index_class='col-xs-'.$pzen_data_xs.' col-sm-'.$pzen_data_sm.' col-md-'.$pzen_data_md.' col-lg-'.$pzen_data_lg.' col-xl-'.$pzen_data_xl;
	}
	
}
//EOF featured products listing----------------------------------------------------

/*=======================================
 * SPECIALS PRODUCTS
 *=======================================*/

 $sproducts_display_style = get_pzen_options('sproducts_display_style');
//if Tab view display slider in inner Product Listing
if($sproducts_display_style=='tabs' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ) || $current_page_base == 'shopping_cart')))){
	$sproducts_display_style = 'slider';
}
if($sproducts_display_style=='default') {
	$parent_stitle_class='title-box';
	$parent_stitle_h2_class = 'text-center text-uppercase title-under';
	$sproduct_container_class = 'product-listing carousel-products-mobile product-grid pzen-prod-list';
	$sproduct_container_id = '';
}
elseif($sproducts_display_style=='slider') {
	$parent_stitle_class = 'title-with-button';
	$sproduct_container_class = 'carousel-products row';
	$sproduct_container_id = 'carouselSpecials';
	if($homepage_layout==1){
		$parent_stitle_h2_class='text-center text-uppercase title-under';
	}else{
		$parent_stitle_h2_class='text-left text-uppercase title-default pull-left';
	}
}elseif($sproducts_display_style=='tabs') {
	$parent_stitle_class = 'text-center text-uppercase title-under';
	$sproducttab_id='SpecialsTab';
	$sproduct_container_id = $sproducttab_id.'-content';
	$sproduct_container_class='carousel-products carouselTab slick-arrow-top  row';
}
//specials products listing----------------------------------------------------
$pzen_speprod_index_class='';
$pzen_speprod_index_data='';
$pzen_data_xxs=1;
$pzen_data_xs=2;
if(SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS==2){
	$pzen_data_sm=2;
	$pzen_data_md=2;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else if(SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS==3){
	$pzen_data_sm=3;
	$pzen_data_md=3;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else{
	$pzen_data_sm=3;
	$pzen_data_md=3;
	if(!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' )))){
		$pzen_data_lg=($theme_font_size==1) ? 4 : 3;
		$pzen_data_xl=($theme_font_size==1) ? 6 : 5;
	}else{
		$pzen_data_lg=4;
		$pzen_data_xl=6;
	}
}
if($sproducts_display_style=='default' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ))))){
	if($products_grid_layouts=='masonary'){
		$pzen_speprod_index_class='mix mix_all grid-list';
	}else if($products_grid_layouts=='grid'){
		$pzen_speprod_index_class='pzen-item';
		$pzen_speprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}
	
}else{
	if($sproducts_display_style=='default') {
		$pzen_speprod_index_class='pzen-item';
		$pzen_speprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}else{
		$pzen_speprod_index_class='col-xs-'.$pzen_data_xs.' col-sm-'.$pzen_data_sm.' col-md-'.$pzen_data_md.' col-lg-'.$pzen_data_lg.' col-xl-'.$pzen_data_xl;
	}
	
}
//EOF specials products listing----------------------------------------------------

/*=======================================
 * BEST SELLERS
 *=======================================*/
$bproducts_display_style = get_pzen_options('bproducts_display_style');
//if Tab view display slider in inner Product Listing
if($bproducts_display_style=='tabs' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ) || $current_page_base == 'shopping_cart')))){
	$bproducts_display_style = 'slider';
}
if($bproducts_display_style=='default') {
	$parent_btitle_class='title-box';
	$parent_btitle_h2_class = 'text-center text-uppercase title-under';
	$bproduct_container_class = 'product-listing carousel-products-mobile product-grid pzen-prod-list';
	$bproduct_container_id = '';
}
elseif($bproducts_display_style=='slider') {
	$parent_btitle_class = 'title-with-button';
	$bproduct_container_class = 'carousel-products row';
	$bproduct_container_id = 'carouselBestSeller';
	if($homepage_layout==1){
		$parent_btitle_h2_class='text-center text-uppercase title-under';
	}else{
		$parent_btitle_h2_class='text-left text-uppercase title-default';
	}
}elseif($bproducts_display_style=='tabs') {
	$parent_btitle_class='title-box';
	$parent_btitle_h2_class = 'text-center text-uppercase title-under';
	$bproducttab_id='BestsellerTab';
	$bproduct_container_id = $bproducttab_id.'-content';
	$bproduct_container_class='carousel-products carouselTab slick-arrow-top  row';
}

//bestseller products listing----------------------------------------------------
$pzen_bestsellerprod_index_class='';
$pzen_bestsellerprod_index_data='';
$pzen_data_xxs=1;
$pzen_data_xs=2;
if(SHOW_PRODUCT_INFO_COLUMNS_BEST_SELLERS==2){
	$pzen_data_sm=2;
	$pzen_data_md=2;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else if(SHOW_PRODUCT_INFO_COLUMNS_BEST_SELLERS==3){
	$pzen_data_sm=3;
	$pzen_data_md=2;
	$pzen_data_lg=3;
	$pzen_data_xl=4;
}else{
	$pzen_data_sm=3;
	$pzen_data_md=3;
	if(!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' )))){
		$pzen_data_lg=($theme_font_size==1) ? 4 : 3;
		$pzen_data_xl=($theme_font_size==1) ? 6 : 5;
	}else{
		$pzen_data_lg=4;
		$pzen_data_xl=6;
	}
}
if($bproducts_display_style=='default' && (!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' ))))){
	if($products_grid_layouts=='masonary'){
		$pzen_bestsellerprod_index_class='mix mix_all grid-list';
	}else if($products_grid_layouts=='grid'){
		$pzen_bestsellerprod_index_class='pzen-item';
		$pzen_bestsellerprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}
}else{
	if($bproducts_display_style=='default') {
		$pzen_bestsellerprod_index_class='pzen-item';
		$pzen_bestsellerprod_index_data='data-xxs="'.$pzen_data_xxs.'" data-xs="'.$pzen_data_xs.'" data-sm="'.$pzen_data_sm.'" data-md="'.$pzen_data_md.'" data-lg="'.$pzen_data_lg.'" data-xl="'.$pzen_data_xl.'"';
	}else{
		$pzen_bestsellerprod_index_class='col-xs-'.$pzen_data_xs.' col-sm-'.$pzen_data_sm.' col-md-'.$pzen_data_md.' col-lg-'.$pzen_data_lg.' col-xl-'.$pzen_data_xl;
	}
	
}
//EOF bestseller products listing----------------------------------------------------


if($homepage_layout==2){
	$category_title_class="text-left text-uppercase title-default";
	$news_title_class="title-default text-uppercase text-left";
}else{
	$category_title_class="text-left text-uppercase title-under";
	$news_title_class="title-under text-uppercase text-center";
}

$latest_newsbox_style = (get_pzen_options('newsbox_style')!='')? get_pzen_options('newsbox_style') : '1' ;
$latest_newsbox_perallax_image = get_pzen_options('newscont_perallax_image');
$newscont_perallax_image_status= (get_pzen_options('newscont_perallax_image_status')) ? get_pzen_options('newscont_perallax_image_status') : '0';

$saf_display_style = get_pzen_options('saf_display_style');

$border_width = get_pzen_options('border_width');
$border_color = get_pzen_options('border_color');

$display_middle_banner = get_pzen_options('display_middle_banner');
$middle_banner_image = get_pzen_options('middle_banner_image');
$middle_banner_caption = htmlspecialchars_decode(stripslashes(get_pzen_options('middle_banner_caption',$_SESSION['languages_id'])));

$display_brands_slider = get_pzen_options('display_brands_slider');
$brands_slider_style = get_pzen_options('brands_slider_style');

$display_info_boxes = get_pzen_options('display_info_boxes');
$infoboxes_style = get_pzen_options('infoboxes_style');

$brands_slider_class=($homepage_layout==1)? "content" : "content-sm offset-top-20";
if($brands_slider_style=="1") {
	$brands_slider_class .= " section-indent-bottom";
}else if($brands_slider_style=="2") {
	$brands_slider_class .= " container-fluid fill-bg-custom";
}else if($brands_slider_style=="3") {
	$brands_slider_class .= " container-fluid fill-bg";
}

if ($full_width_slideshow=='intro') {
	$slideshow_section_class="intro tp-banner-button1";
}
else {
    $slideshow_section_class="";
}

$display_top_banners = get_pzen_options('display_top_banners');
$top_banners_layout = (get_pzen_options('top_banners_layout')!='')? get_pzen_options('top_banners_layout') : '1';
$top_banners_style = get_pzen_options('top_banners_style');

$display_bottom_banners = get_pzen_options('display_bottom_banners');
$bottom_banners_style = get_pzen_options('bottom_banners_style');

$display_category = get_pzen_options('display_category');
$display_category_style = get_pzen_options('display_category_style');
$category_banner_1 = get_pzen_options('category_banner_1');
$category_banner_2 = get_pzen_options('category_banner_2');
$category_caption_1 = htmlspecialchars_decode(stripslashes(get_pzen_options('category_caption_1',$_SESSION['languages_id'])));
$category_caption_2 = htmlspecialchars_decode(stripslashes(get_pzen_options('category_caption_2',$_SESSION['languages_id'])));
if($display_category_style=="display_style_1"){
	$category_id = 'carouselCategoryOne';
	$category_id_two = 'carouselCategoryTwo';
	$category_class = 'row carousel-products slider';
}
else {
	$category_id = 'carouselСategoriesOne';
	$category_id_two = 'carouselСategoriesTwo';
	$category_class = 'carousel-products row slick-arrow-top';
}

$store_address =  htmlspecialchars_decode(stripslashes(get_pzen_options('store_address')));
$store_contact = get_pzen_options('store_contact');
$store_email = get_pzen_options('store_email');
$store_copyright = htmlspecialchars_decode(stripslashes(get_pzen_options('store_copyright')));
$store_fax = get_pzen_options('store_fax');
$store_skype = get_pzen_options('store_skype');
$store_timings = get_pzen_options('store_timings');
$store_map = htmlspecialchars_decode(stripslashes(get_pzen_options('google_map')));
$newsletter_details = htmlspecialchars_decode(stripslashes(get_pzen_options('newsletter_details')));

$facebook_link = get_pzen_options('facebook_link');
$twitter_link = get_pzen_options('twitter_link');
$pinterest_link = get_pzen_options('pinterest_link');
$google_link = get_pzen_options('google_link');
$tumblr_link = get_pzen_options('tumblr_link');
$linkedin_link = get_pzen_options('linkedin_link');
$youtube_link = get_pzen_options('youtube_link');
$display_instagram_feed = get_pzen_options('display_instagram_feed');

$featured_category_1 = (get_pzen_options('featured_category_1')) ? get_pzen_options('featured_category_1') : '118'; 
$featured_category_2 = (get_pzen_options('featured_category_2')) ? get_pzen_options('featured_category_2') : '120' ; 

$featured_category = get_pzen_options('featured_category'); 
$featured_category_id = (explode(",",$featured_category));

$payment_image = get_pzen_options('payment_image');

$testimonial_style = get_pzen_options('testimonial_style');
$test_background_image = get_pzen_options('test_background_image');

$display_newsletter = get_pzen_options('display_newsletter');
$display_popup_sec = get_pzen_options('display_popup_sec');

/*===========================PROD INFO=============================*/

$prodinfo_image_effects = (get_pzen_options('prodinfo_image_effects')) ? get_pzen_options('prodinfo_image_effects') : '1';
$prodinfo_image_layout=(get_pzen_options('prodinfo_image_layout')) ? get_pzen_options('prodinfo_image_layout') : '1';
/*===========================EOF PROD INFO=============================*/
/*===========================PROD LISTPAGE=============================*/
$prodlist_image_effects = (get_pzen_options('prodlist_image_effects')!='') ? get_pzen_options('prodlist_image_effects') : '1';
$prodlistview_image_layout=(get_pzen_options('prodlistview_image_layout')!='') ? get_pzen_options('prodlistview_image_layout') : '1';
/*===========================EOF PROD LISTPAGE=============================*/
/*===========================MAINTENANCE=============================*/
if (in_array($current_page_base,explode(",",'down_for_maintenance'))){
	$container_class='';
}
/*===========================EOF MAINTENANCE=============================*/

/*=========================== Carousel display slide settings ==================================*/
$carouselFeatured_slides=$carouselSpecials_slides=$carouselNew_slides=$carouselHeader_slides=$carouselBestSeller_slides=$carouselCategoryOne_slides=$carouselCategoryTwo_slides=$carouselСategoriesOne_slides=$carouselСategoriesTwo_slides=$postsCarousel_slides=$slider_blog_slides=$slider_blog_layout1_slides='';
if($saf_display_style=='split' && $this_is_home_page && $homepage_layout==1 && $fproducts_display_style=='slider' && $sproducts_display_style=='slider' ){
	// Home Page, Slider View, Single Column, Split View==============================================================
	$carouselFeatured_slides='3,2,2,3,2,1';
	$carouselSpecials_slides='3,2,2,3,2,1';
	$carouselNew_slides=($theme_font_size==1) ? '7,5,4,3,2,1' : '6,4,3,3,2,1';
}elseif($saf_display_style=='split' && $this_is_home_page && $homepage_layout==2 && $fproducts_display_style=='slider' && $sproducts_display_style=='slider') {
	// Home Page, Slider View, Two Column, Split View==============================================================
	$carouselFeatured_slides='3,2,2,3,2,1';
	$carouselSpecials_slides='2,1,1,3,2,1';
	$carouselNew_slides=($theme_font_size==1)? '6,4,3,3,2,1' : '5,3,2,3,2,1';
}elseif(!$this_is_home_page && (($current_page_base == 'index' && ($_GET['cPath'] != '' || $_GET['manufacturers_id'] != '' )))) {
	// Manufactures Pages && Product List Page ==============================================================
	$carouselFeatured_slides=$carouselSpecials_slides=$carouselNew_slides=($theme_font_size==1)? '6,4,3,3,2,1' : '5,3,2,3,2,1';
}else{
	if(($sproducts_display_style=='slider' || $nproducts_display_style=='slider' || $fproducts_display_style=='slider' ) && $homepage_layout==1 ){
		// Home Page, Slider View, Single Column==============================================================
		$carouselSpecials_slides=$carouselNew_slides=$carouselFeatured_slides=($theme_font_size==1) ? '7,5,4,3,2,1' : '6,4,3,3,2,1';
	}elseif(($sproducts_display_style=='slider' || $nproducts_display_style=='slider' || $fproducts_display_style=='slider' ) && $homepage_layout==2 ){
		// Home Page, Slider View, Two Column==============================================================
		$carouselSpecials_slides=$carouselNew_slides=$carouselFeatured_slides=($theme_font_size==1)? '6,4,3,3,2,1' : '5,3,2,3,2,1';
	}
}

// Home Page, Single Column, Best Seller Slider==============================================================
if($bproducts_display_style=='slider' && $homepage_layout==1 ){
	$carouselBestSeller_slides='6,4,3,3,2,1';
}else if($bproducts_display_style=='slider' && $homepage_layout==2 ){
	// Home Page, Two Column, Best Seller Slider==============================================================
	$carouselBestSeller_slides=($theme_font_size==1)? '6,4,3,3,2,1' : '5,3,2,3,2,1';
}

// Home Page, Single Column, Random Slider==============================================================
if($randprod_style=='slider' && $homepage_layout==2 ) {
	$carouselHeader_slides=($theme_font_size==1)? '6,4,3,3,2,1' : '5,3,2,3,2,1' ;
}else{
	$carouselHeader_slides=($theme_font_size==1)? '7,6,5,4,3,1' : '5,4,4,3,2,1' ;
}

if($display_category_style == "display_style_1" && $homepage_layout==1){
	// Home Page, Single Column, Categories Style 1==============================================================
	$carouselCategoryOne_slides=$carouselCategoryTwo_slides='2,2,2,3,2,1' ;
}else if($display_category_style == "display_style_1" && $homepage_layout==2){
	// Home Page, Two Column, Categories Style 1==============================================================
	$carouselCategoryOne_slides=$carouselCategoryTwo_slides=($theme_font_size==1)? '6,4,3,3,2,1' : '5,3,2,3,2,1';
}else if($display_category_style == "display_style_2" && $homepage_layout==1){
	// Home Page, Single Column, Categories Style 2==============================================================
	$carouselСategoriesOne_slides=$carouselСategoriesTwo_slides='4,2,1,1,2,1';
}else if($display_category_style == "display_style_2" && $homepage_layout==2){
	// Home Page, Two Column, Categories Style 2==============================================================
	$carouselСategoriesOne_slides=$carouselСategoriesTwo_slides=($theme_font_size==1)? '4,2,1,1,2,1' : '3,2,1,1,2,1';
}

// Home Page, Two Column, Testimonials==============================================================
if($testimonial_style=="1") {
	$slider_blog_slides='1,1,1,1,1,1';
}else if($testimonial_style=="2"){
	$slider_blog_layout1_slides='3,2,1,1,1,1';
}

// Home Page, Two Column, Post Carousel==============================================================
if($homepage_layout==1) {
	$postsCarousel_slides='2,3,3,2,2,1';
}else{
	$postsCarousel_slides=($theme_font_size==1)? '3,3,2,2,2,1' : '2,3,2,2,2,1';
}

// Product List Page, Listing Space==============================================================
$gutter_space=30;
$gutter_space=($theme_font_size==1)? 20 : 30;
/*===========================EOF Carousel display slide settings ==================================*/
?>

<?php if($this_is_home_page){
	
	//main slideshow
	if($display_main_slideshow == 1) {
		$slideshow_query = "SELECT * FROM ".TABLE_PZEN_SLIDER." where slide_status='1' group by sort_order order by sort_order";
		$slideshow_query_result = $db->Execute($slideshow_query);
	}
	
	//top banner
	if($display_top_banners == 1){
		$top_banner_query = "SELECT * FROM ".TABLE_PZEN_TOPBANNER." where item_status='1' and item_type='2' group by sort_order order by sort_order";
		$top_banner_query_result = $db->Execute($top_banner_query);
		
		$banner_slider_query = "SELECT * FROM ".TABLE_PZEN_TOPBANNER." where item_status='1' and item_type='1' group by sort_order order by sort_order";
		$banner_slider_query_result = $db->Execute($banner_slider_query);
	}
	
	//bottom banner
	$bt_banner_mn_class = $bottom_banner_class ='';
	if(get_pzen_options('display_bottom_banners')==1){
		$bottom_banner_query = "SELECT * FROM ".TABLE_PZEN_BOTTOMBANNER." where item_status='1' and item_type='2' group by sort_order order by sort_order";
		$bottom_banner_query_result = $db->Execute($bottom_banner_query);
		
		//$rows = $top_banner_query_result->RecordCount();
		
		if($bottom_banners_style=="1") {
			$bt_banner_mn_class = ($homepage_layout==1)? "content fullwidth indent-col-none" : "container-fluid box-baners content-sm";
			$bottom_banner_class = "col-md-4 col-sm-4 col-xs-12";
		}
		elseif($bottom_banners_style=="2") {
			$bottom_banner_class = "col-md-6 col-sm-6 col-xs-12";
			$bt_banner_mn_class = ($homepage_layout==1)? "container-fluid box-baners" : "container-fluid box-baners content-sm";
		}
	}
	
	if($testimonial_style == 1) {
		$test_main_class = ($homepage_layout==1)? "content content-bg-1 fixed-bg" : "content-sm content-bg-1 fixed-bg";
		$test_slider_class= "slider-blog slick-arrow-bottom";
	}
	else {
		$test_main_class = "content";
		$test_slider_class= "slider-blog-layout1";
	}
}
?>
<!--Query Ends-->
<?php //BOF Define Font Family============================================================================================= ?>
<?php 
$font_sizes = "%3A300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic"; 
$charSubset='';
if($font_latin_charset_extended==1){$charSubset .= ',latin-ext';}
if($font_custom_charset !=''){$charSubset .= ','.$font_custom_charset;}
?>
<?php if(!in_array($general_font_family,array('Georgia'))){ ?>
<link rel='stylesheet' href="https://fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $general_font_family).$font_sizes; echo $charSubset;  ?>" type="text/css" />
<?php } ?>
<?php if(!in_array($bannercap_font_family,array('Georgia'))){ ?>
<link rel='stylesheet' href="https://fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $bannercap_font_family).$font_sizes; echo $charSubset;  ?>" type="text/css" />
<?php } ?>
<style type="text/css">
<?php if(!in_array($general_font_family,array('Ubuntu'))){ ?>
body, .tooltip, .custom-font, .product__label, .price-box, .slider-blog-layout1 .slider-blog__item h6, .recent-post-box h4, .banner .figcaption .size40, .input-counter input, .input-counter span, .tp-caption1--wd-2, .tp-caption2--wd-2, .tp-caption2--wd-3, .tp-caption3--wd-2, .tp-caption3--wd-3, .tp-caption4--wd-1, .tp-caption4--wd-2, .slider-layout-2 .tp-caption1--wd-2, .promos__label, .vertical-carousel .label, .post__title_block time span, .countdown-transparent .countdown-amount{font-family: <?php echo $general_font_family; ?>, sans-serif;}
<?php } ?>
<?php if(!in_array($bannercap_font_family,array('Georgia'))){ ?>
.main-font, blockquote.quote-left, blockquote.quote-left:before, .lead, .delivery-banner__text h5, .slider-blog .box-foto:after, .slider-blog .box-data h6 em, .testimonialsAsid .slick-slide p span:before, .recent-post-box .figure .figcaption em, .banner .figcaption .text.size1, .banner .figcaption .text.size4, .banner .figcaption .text.size5, .tp-caption1--wd-1, .tp-caption2--wd-1, .tp-caption3--wd-1, .slider-layout-2 .tp-caption1--wd-1, .post__title_block time, .post__meta .autor, .recent-comments dt, .slogan, .comments .media-body .media-title .username, .slider-blog-layout1 .slider-blog__item .box-data:before, .slider-blog-layout1 .slider-blog__item h6 em, .recent-post-box .author {font-family: <?php echo $bannercap_font_family; ?>, sans-serif;}
@media (min-width: 767px){
	.slider-blog .box-foto:after{font-family: <?php echo $bannercap_font_family; ?>, sans-serif;}
}
@media (min-width: 510px){
	.slider-blog-layout1 .slider-blog__item .box-foto:before{font-family: <?php echo $bannercap_font_family; ?>, sans-serif;}
}
<?php } ?>

<?php //EOF Define Font Family============================================================================================= ?>
<?php if($theme_btn_size==1){ ?>
.product .btn.btn--ys.btn--xl, #RandomProducts .btn.btn--ys.btn--xl, .lst_comb_sec .btn.btn--ys.btn--xl{font-size: 14px;padding: 8px 10px 6px;}
.product .quick-view b{font-size:14px;padding:10px;}
@media (min-width: 1200px){.product .quick-view{margin-top: -18px;}}
@media (max-width:1300px){
	.product .btn.btn--ys.btn--xl{font-size: 14px;padding: 8px 1px;}
	.product .product__inside__info .btn--xl:not(.row-mode-visible) .icon {width: 35px;}
	.product .product__inside__info .btn--xl:not(.row-mode-visible){height: 35px;line-height: 18px;width: 35px;}
}
<?php }else if($theme_btn_size==2){ ?>
.product .btn.btn--ys.btn--xl, #RandomProducts .btn.btn--ys.btn--xl, .lst_comb_sec .btn.btn--ys.btn--xl{font-size: 17px;padding: 12px 13px 10px;line-height: 1.2em;}
.product .quick-view b{font-size:17px;padding:15px;}
@media (max-width:1300px){
	.product .btn.btn--ys.btn--xl{font-size: 14px;padding: 8px 1px;}
	.product .product__inside__info .btn--xl:not(.row-mode-visible) .icon {width: 45px;}
	.product .product__inside__info .btn--xl:not(.row-mode-visible){height: 45px;line-height: 28px;width: 45px;}
}
<?php } ?>

.content-bg-1{background: url("<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$test_background_image; ?>") center center repeat;}
.tooltip-inner{background-color: <?php echo $theme_color; ?>;}
.tooltip.top .tooltip-arrow{border-top:5px solid <?php echo $theme_color; ?>;}
.tooltip.left .tooltip-arrow{border-left:5px solid <?php echo $theme_color; ?>;}
.tooltip.bottom .tooltip-arrow{border-bottom:5px solid <?php echo $theme_color; ?>;}
.tooltip.right .tooltip-arrow{border-right:5px solid <?php echo $theme_color; ?>;}
#product_name a:hover, #loginForm .buttonRow.back.important > a:hover, .buttonRow.back.important > a:hover, #checkoutSuccessOrderLink > a:hover, #checkoutSuccessContactLink > a:hover, #checkoutSuccess a.cssButton.button_logoff:hover, #subproduct_name > a, a.table_edit_button span.cssButton.small_edit:hover, #productReviewLink > a:hover, .buttonRow.product_price > a:hover, #searchContent a:hover, #siteMapList a:hover, .box_heading_style h1 a:hover, .info-links > li:hover a, #navBreadCrumb li a:hover, .footer-toplinks a:hover, .banner:hover .link:hover, #cartContentsDisplay a.table_edit_button:hover, #timeoutDefaultContent a:hover, #logoffDefaultMainContent > a span.pseudolink:hover, #createAcctDefaultLoginLink > a:hover, #unsubDefault a .pseudolink:hover, .review_content > p i.fa, .gv_faq a:hover, .alert > a:hover, .readmore,button, #shoppingCartDefault .buttonRow, #pageThree .buttonRow.back > a, #pageFour .buttonRow.back > a, #pageTwo .buttonRow.back > a, #discountcouponInfo .content .buttonRow.forward > a, .header-container .header .greeting a:hover, .header-container .header .cart-info .shopping_cart_link, .content.caption h2, .content.caption a, #reviewsContent > a:hover, .product-name-desc .product_name a:hover, .add_title, .btn.dropdown-toggle.btn-setting, .centerBoxContentsAlsoPurch .product-actions a, #specialsListing .item .product-actions a, #whatsNew .centerBoxContentsNew.centeredContent .product_price, #featuredProducts .centerBoxContentsFeatured.centeredContent .product_price, .item .product_price, #specialsDefault .centerBoxContentsSpecials.centeredContent .product_price, #specialsListing .specialsListBoxContents .product_price, #alsopurchased_products .product_price, #upcomingProducts .product_price, .productListing-data .product_name > a:hover, .newproductlisting .product_name > a:hover, .brands-wrapper h2, .category-slideshow-wrapper h2, .box_heading h2, .custom-newsletter-left header > h2, .alsoPurchased header > h2, .product_price.total span.total_price, .breadcrumb-current, .cartTableHeading, #cartSubTotal, table#cartContentsDisplay tr th, #prevOrders .tableHeading th, #accountHistInfo .tableHeading th, #cartSubTotal, .remodal h1, .remodal-close:after, .remodal-confirm, .about-us-details header > h2, .cart_table .fa-times-circle:hover, .basketcol span.cartTitle, #viewCart a, .product-list .item:hover .info-right .product-title a, .extra-links li a:hover, .contact-us li.aboutus_mail a:hover, .prodinfo-actions .wish_link a, .prodinfo-actions .compare_link a, .about-us-details h3, #timeoutDefault .timeoutbuttons a:hover, .product-info-ratings .rating-links a.lnk:hover, .product-listview .product-info .name a:hover, .pseudolink:hover, .notfound_title {color: <?php echo $theme_color; ?>;}
#checkoutSuccess a:hover, #siteMapMainContent a:hover, .login-buttons > a:hover, .alert > a:hover, #navBreadCrumb li:last-child a:hover, #cartImage > a:hover, .product_wishlist_name > a:hover, #compareDefaultMainContent a:hover, .index-ratings > a:hover, .link-list.inline a:hover, .copyright a:hover, .more_info_text, .body-container .product-container .product-top .product-info .quantity-container .lnk:hover, #description .product-tab p#productInfoLink a {color: <?php echo $theme_color; ?> !important;}
/*Pagination*/
.pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus{ color: <?php echo $theme_color; ?>;background-color: #f5f5f5;border-color: transparent;}
/*Heading*/
h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover{color: <?php echo $theme_color; ?>;text-decoration: none;}
.title-decimal:before, .recent-post-box .figure{background: <?php echo $theme_color; ?>;}
.link-banner1:hover{text-decoration: none;color: <?php echo $theme_color; ?>;}
.hor-line{background-color: <?php echo $theme_color; ?>;}
.color-custom, .color-custom:hover, .color, .color:hover, a.color, a.color:hover {color: <?php echo $theme_color; ?>;}
.color-green-dark, .color-green-dark:hover {color: <?php echo $theme_color; ?>;}
.bg-custom, .bg-green-dark{background-color: <?php echo $theme_color; ?>;}
.simple-list li:before, .simple-list li.active > a, .simple-list-underline li:after, .simple-list-underline li.active > a {color: <?php echo $theme_color; ?>;}
.simple-list li a:hover, .simple-list-underline li a:hover {color: <?php echo $theme_color; ?>;text-decoration: none;}
.marker-list li, .marker-list-circle li:after{color: <?php echo $theme_color; ?>;}
.marker-list li a {color: <?php echo $theme_color; ?>;-webkit-transition:  all 300ms linear 0s;-moz-transition:  all 300ms linear 0s;-ms-transition:  all 300ms linear 0s;-o-transition:  all 300ms linear 0s;transition:  all 300ms linear 0s;}
.decimal-list li:before{color: <?php echo $theme_color; ?>;}
.decimal-list a:hover{color: <?php echo $theme_color; ?> !important;}
.categories-list li a:hover{color: <?php echo $theme_color; ?>;}
.without-declaration-list li a:hover{color: <?php echo $theme_color; ?>;}
.list-icon span{background-color: <?php echo $theme_color; ?>;}
.list-arrow-right li:after, .list-arrow-right li a:hover {color: <?php echo $theme_color; ?>;}
.icon-enable {color: <?php echo $theme_color; ?>;}
blockquote.quote-left, blockquote.quote-left:before {color: <?php echo $theme_color; ?>;}
.fill-bg-custom {background-color: <?php echo $theme_color; ?>;}
.table-bordered-01 tbody tr td:first-child {color: <?php echo $theme_color; ?>;}
dl dd a {color: <?php echo $theme_color; ?>;text-decoration: underline;}
.link-icon, .link-color, .link-color:hover, .link-underline, .link-underline:hover {color: <?php echo $theme_color; ?>;}
.media-box-link {background-color: <?php echo $theme_color; ?>;}
.media-box-link:hover .icon {color: <?php echo $theme_color; ?>;}
.bull-line {background: <?php echo $theme_color; ?>;}
/* The dot */
#loader .dot {background-color: <?php echo $theme_color; ?>;}
@keyframes dot1{ 0% { transform: rotateY(0) rotateZ(0) rotateX(0); background-color: <?php echo $theme_color; ?>;} 45% { transform: rotateZ(180deg) rotateY(360deg) rotateX(90deg); background-color: #000000; animation-timing-function: cubic-bezier(0.15, 0.62, 0.72, 0.98);}
  90%, 100% {transform: rotateY(0) rotateZ(360deg) rotateX(180deg); background-color: <?php echo $theme_color; ?>;}}
.toggle-menu .li-col-full .close:hover, .toggle-menu:hover {color: <?php echo $theme_color; ?>;}
#header.header-layout-02 .account-row-list ul li a, #header.header-layout-03 .account-row-list ul li a {color: <?php echo $theme_color; ?>;text-decoration: none;-webkit-transition:  all 0.3s 0s ease;-moz-transition:  all 0.3s 0s ease;-ms-transition:  all 0.3s 0s ease;-o-transition:  all 0.3s 0s ease;transition:  all 0.3s 0s ease;}
#header.header-layout-02 .h-address .icon, #header.header-layout-03 .h-address .icon{color: <?php echo $theme_color; ?>;}
#header.header-layout-03 .stuck-nav .badge--color:after{border-top: 5px solid <?php echo $theme_color; ?>;}
.footer-copyright a, footer .box-address .icon, footer.layout-5 .telephone-box address .icon {color: <?php echo $theme_color; ?>;}
.v-links-list a {color: <?php echo $theme_color; ?>;-webkit-transition:  all 200ms linear 0s;-moz-transition:  all 200ms linear 0s;-ms-transition:  all 200ms linear 0s;-o-transition:  all 200ms linear 0s;transition:  all 200ms linear 0s;}
.v-links-list a:active {color: <?php echo $theme_color; ?>;}
.product__inside__name h2, .product__inside__name h2 a, .product .quick-view, .product .product__inside__info__link li a:hover, .product__inside__info__link li a:hover, .product .product__inside__info__link li:hover, .product .product__inside__info__link li:hover a, .product__inside__info__link li:hover, .product__inside__info__link li:hover span.text, .product-link li a:hover, .product-link li:hover, .product-link li:hover span.text, .product-listing.row-view > div .product__inside__review > a:hover, .product-info-outer #productPrevNext .product-prev:hover:before, .product-info-outer #productPrevNext .product-next:hover:before, .product-info__price, .product-info__review > a:last-child, .product-info__review > a:hover {color: <?php echo $theme_color; ?>;}
.video-link {color: <?php echo $theme_color; ?>;}
.delivery-banner__icon, .delivery-banner__text h3 {color: <?php echo $theme_color; ?>;}
.slickArrowHover, .slick-prev:hover, .slick-next:hover, .carousel-products__button span:hover, .carousel-products__button span:focus {outline: none;background: <?php echo $theme_color; ?>;}
.carousel-products__button .slick-arrow:hover,.product .quick-view:hover b {background-color: <?php echo $theme_color; ?>;}
.nav-dot .slick-dots li.slick-active button:before, .banner-slider-button .slick-prev:hover:before, .banner-slider-button .slick-next:hover:before, .banner-slider-button .slick-prev:hover:before, .banner-slider-button .slick-next:hover:before{color: <?php echo $theme_color; ?>;opacity: 1;}
/*==== banner-slider-button====*/
.banner-slider-button .slick-prev,.banner-slider-button .slick-next {background-color: transparent;}
.banner-slider-button .slick-prev:before, .banner-slider-button .slick-next:before {color: #fff;}
.slider-blog .box-foto:after{color: <?php echo $theme_color; ?>;}
.link-hover-block:hover h6, .link-hover-block:hover h6 em {color: <?php echo $theme_color; ?> !important;}
.slider-blog-layout1 .slider-blog__item .box-data:before, .slider-blog-layout1 .slider-blog__item h6 {color: <?php echo $theme_color; ?>;}
.recent-post-box .figure{background: <?php echo $theme_color; ?>;}
.recent-post-box .figure .figcaption{background-color: <?php echo $theme_color; ?>;}
.recent-post-box h4, .recent-post-box h4 a, .recent-post-box .link-commet, .recent-post-box:hover .figcaption span{color: <?php echo $theme_color; ?>;}
.fill-bg .slick-prev:hover:before, .fill-bg .slick-next:hover:before {color: <?php echo $theme_color; ?>;}
.dropdown-link .icon {color: <?php echo $theme_color; ?>;}
.image-link:hover .figcaption, .image-links-prototypes .image-link:hover .figcaption, .image-links-listing .image-link:hover .figcaption {color: <?php echo $theme_color; ?>;}
.navbar-color-white .badge--color {background-color: <?php echo $theme_color; ?>;}
.search a:hover .icon, #search-dropdown .input-outer button:hover {color: <?php echo $theme_color; ?>;}
.cart .dropdown > a .icon, .cart .dropdown-menu .cart__item__control a:hover {color: <?php echo $theme_color; ?> !important;}
.cart .dropdown-menu .cart__close:hover, .cart .dropdown-menu .cart__total span {color: <?php echo $theme_color; ?>;}
.cart .dropdown-menu .cart__item__image:hover {outline: 2px solid <?php echo $theme_color; ?>;}
.banner .figure, .banner-layout-1 .figure {background-color: <?php echo $theme_color; ?>;}
.banner .figcaption .text.color, .box-baners .banner .figcaption .icon.color, .box-baners .banner .figcaption span.color, .box-baners .banner .figcaption span.color span, .box-baners .banner .figcaption em.color, .box-baners .banner .figcaption em.color span, .box-baners .banner .figcaption .text-custom, .box-baners .banner .figcaption .link-btn-20:hover, .box-baners .banner .figcaption .link-btn-20:hover span, .banner-icon__text h3 {color: <?php echo $theme_color; ?>;}
.banner-icon:hover .banner-icon__icon {background: <?php echo $theme_color; ?>;}
.banner-one-product .product-content .title a:hover, .banner-one-product .product-content .price{color: <?php echo $theme_color; ?>;}
.input-counter span:hover{color: <?php echo $theme_color; ?>;}
.link-img-hover:hover, .link-img-hover1:hover{background: <?php echo $theme_color; ?>;}
.tp-caption1--wd-2, .tp-caption3--wd-2, .slider-layout-3 .tp-caption2--wd-2{color: <?php echo $theme_color; ?>;}
.link-button{background-color: <?php echo $theme_color; ?>;}
.link-button:hover{color: <?php echo $theme_color; ?> !important;}
.button--border-thick{border: 2px solid <?php echo $theme_color; ?>;}
.tp-leftarrow.default:hover, .tp-rightarrow.default:hover{background-color: <?php echo $theme_color; ?> !important;}
.tp-caption--product-1 .title a, .tp-caption--product-1 .title, .tp-caption--product-1 .title a:focus, .tp-caption--product-1 .btn--ys:hover, .tp-caption--product-1 [data-btn="btn btn--ys"]:hover {color: <?php echo $theme_color; ?>;}
.tp-banner-button1 .tp-leftarrow.default:hover, .tp-banner-button1 .tp-rightarrow.default:hover{color: <?php echo $theme_color; ?> !important;}
.instafeed a, .instafeed a:after{background-color: <?php echo $theme_color; ?>;}
.promos h2, .promos h2 a{color: <?php echo $theme_color; ?>;}
.breadcrumbs .breadcrumb.breadcrumb--ys > li.home-link a {color: <?php echo $theme_color; ?>;}
.collapse-block__title:after{color: <?php echo $theme_color; ?>;}
.expander-list > li a:hover, .expander-list li > a.active, .expander-list .expander:before {color: <?php echo $theme_color; ?>;}
#nav-cat li.submenu > a:before{color: <?php echo $theme_color; ?>;}
.filter-list li span, .filter-list li a.icon:hover{color: <?php echo $theme_color; ?>;}
.price-input input[type=text]{color: <?php echo $theme_color; ?>;}
.compare__item__delete a, .compare__item__title h2 a:hover, #compareSlide .compareSlide__close:hover, #compareSlide .compareSlide__bot .clear-all, #compareSlide .compareSlide__bot .clear-all:hover, #compareSlide .compared-product__delete, #compareSlide .compared-product__name, .compare-table .link-close:hover{color: <?php echo $theme_color; ?>;}
.vertical-carousel__item .price-box, .vertical-carousel__item__title h2 a:hover{color: <?php echo $theme_color; ?>;}
.vertical-carousel .slick-prev:hover, .vertical-carousel .slick-next:hover{background: <?php echo $theme_color; ?>;}
.subcategory-item a:hover .subcategory-item__title, .subcategory-item__title a:hover{color: <?php echo $theme_color; ?>;}
.filters-row__view:hover, .filters-row__view.active, .filters-row__select .icon{color: <?php echo $theme_color; ?>;}
.without-left-col#left-column .slide-column-close{color: <?php echo $theme_color; ?>;}
.back-to-top{background-color: <?php echo $theme_color; ?>;}
.post__title_block figure{background: <?php echo $theme_color; ?>;}
.post__title_block time{ background-color: <?php echo $theme_color; ?>;}
.post__meta a, .post__meta .icon {color: <?php echo $theme_color; ?>;}
.recent-comments dt{ color: <?php echo $theme_color; ?>;}
.gallery__item a:before{background-color: <?php echo $theme_color; ?>;}
.shopping-cart-table__product-price, .shopping-cart-table__input input, .shopping-cart-table a, .shopping-cart-table__product-name a{color: <?php echo $theme_color; ?>;}
.btn.updateall_btn:hover .btn--ys, .btn.updateall_btn:hover [data-btn="btn btn--ys"] {background: <?php echo $theme_color; ?>;}
.table-total td{color: <?php echo $theme_color; ?>;}
.block-underline-top .link-functional{color: <?php echo $theme_color; ?>;}
.order-review-table__product-price, .order-review-table__input input, .order-review-table a, .order-review-table__product-name a {color: <?php echo $theme_color; ?>;}
.table-total-checkout td, .table-wishlist__product-name, .table-wishlist__product-price, .table-wishlist__delete, .table-wishlist-1__product-price, .table-wishlist-1__product-name, .table-wishlist-1__product-name a { color: <?php echo $theme_color; ?>;}
.nav-select-item li a .icon-clothes {color: <?php echo $theme_color; ?>;}
.bigGallery .slick-prev:hover, .bigGallery .slick-next:hover { background: <?php echo $theme_color; ?>;}
.lookbook .hint, .lookbook-layout2 .hint:before{background: <?php echo $theme_color; ?>;}
.lookbook .hint-title, .lookbook-layout1 .hint-title, .lookbook-layout2 .hint-title, .lookbook-layout2 .hint .icon { color: <?php echo $theme_color; ?>;}
.lookbook .hint__dot {border-color: <?php echo $theme_color; ?>;}
.countdown-transparent .countdown-section{color: <?php echo $theme_color; ?>;}
.title-aside-wrapper {background-color: <?php echo $theme_color; ?>;}
.title-under:after {background: <?php echo $theme_color; ?>;}
.slogan {color: <?php echo $theme_color; ?>;}
.badge--color {background-color: <?php echo $theme_color; ?>;}
.badge--color:after {border-top-color: <?php echo $theme_color; ?>;}
.cartbox_overlay button.close.btn--ys.btn--sm, .btn--ys,[data-btn="btn btn--ys"] {background-color: <?php echo $theme_color; ?>;}
.btn--ys:hover, .btn--ys:active, .btn--ys.focus, .btn--ys:focus,[data-btn="btn btn--ys"]:hover, [data-btn="btn btn--ys"]:active, [data-btn="btn btn--ys"]:focus {background: <?php echo $theme_color; ?>;}
.cartbox_overlay button.close.btn--ys.btn--sm:hover, .btn--ys:hover, [data-btn="btn btn--ys"]:hover {color: <?php echo $theme_color; ?>;background-color: #f5f5f5;}
.btn--ys.btn--light span, [data-btn="btn btn--ys"].btn--light span, [data-btn="btn btn--ys"].btn--invert, .btn--ys.btn--invert {color: <?php echo $theme_color; ?>;}
.btn--ys.btn--light:hover, [data-btn="btn btn--ys"].btn--light:hover, [data-btn="btn btn--ys"].btn--invert:hover, .btn--ys.btn--invert:hover {background-color: <?php echo $theme_color; ?>;}
.btn--border:hover, .btn--border:active, .btn--border.focus, .btn--border:focus {background: <?php echo $theme_color; ?>;}
.btn--border:hover { color: <?php echo $theme_color; ?>}
.btn--border:hover {background-color: #f5f5f5;}
.button--tamaya::before, .button--tamaya::after {background: <?php echo $theme_color; ?>;}
.btn-img.active, .btn-img:hover {background-color: <?php echo $theme_color; ?>;}
.select-basket .dropdown-toggle {background-color: <?php echo $theme_color; ?>;}
.select-basket__table tfoot td {color: <?php echo $theme_color; ?>;}
.radio input:focus + .outer .inner, .radio .inner { background-color: <?php echo $theme_color; ?>;}
.checkbox-group label .check:before {color: <?php echo $theme_color; ?>;}
input[type=checkbox]:checked ~ label .box {border-color: <?php echo $theme_color; ?>;}
.form-control:focus, input.visibleField:focus {border-color: <?php echo $theme_color; ?>;}
.input-group-addon {color: <?php echo $theme_color; ?>;}
.tag:hover, .tags-list li a:hover {background-color: <?php echo $theme_color; ?>; border-color: <?php echo $theme_color; ?>;}
.pagination li a .icon {color: <?php echo $theme_color; ?>;}
.white-modal .modal-header .close {color: <?php echo $theme_color; ?>;}
.comments .media-body .media-title {color: <?php echo $theme_color; ?>;}
.panel .panel-heading .panel-title:after {color: <?php echo $theme_color; ?>;}
.panel .panel-heading.active .panel-heading__number { background-color: <?php echo $theme_color; ?>;}
.link-functional .icon, .link-functional .fa, .link-functional:hover {color: <?php echo $theme_color; ?>;}
.buttonRow.btn.btn--ys:hover > a, [data-btn="btn btn--ys"].buttonRow:hover > a {color: <?php echo $theme_color; ?>;}
.sidebox_content a:hover, .sidebox_content .price-box { color: <?php echo $theme_color; ?>;}
@media (max-width: 479px){.carousel-products__button span.btn-prev:hover, .carousel-products__button span.btn-next:hover {outline: none;background: <?php echo $theme_color; ?>;}
}
@media (max-width: 510px){.slider-blog-layout1 .slider-blog__item .box-foto:before{color: <?php echo $theme_color; ?>;}}
@media (min-width: 768px){
.product .carousel-control:hover,.product .carousel-control:focus {outline: none;background: <?php echo $theme_color; ?>;}
.slick-arrow-bottom .slick-prev:hover:before, .slick-arrow-bottom .slick-next:hover:before {color: <?php echo $theme_color; ?>;}
.slick-arrow-top .slick-prev:hover, .slick-arrow-top .slick-next:hover {background-color: <?php echo $theme_color; ?>;}
.nav-tabs--ys > li.active > a:before {background-color: <?php echo $theme_color; ?>;}
.nav-tabs--ys-center li.active > a{border-bottom: 5px solid <?php echo $theme_color; ?> !important;}
.nav-tabs--ys-center1 li.active > a{border-bottom: 3px solid <?php echo $theme_color; ?> !important;}
}
@media (max-width: 767px){
.product-listing:not(.carousel-products-mobile) .product .product__inside__info .btn--xl:not(.row-mode-visible):hover .icon {color: <?php echo $theme_color; ?>;}
.slider-blog .box-foto:after {color: <?php echo $theme_color; ?>;}
.nav-tabs li a:hover {color: <?php echo $theme_color; ?>;}
.nav-tabs li.active a {background: <?php echo $theme_color; ?> !important;}
.mobile-collapse__title:before {color: <?php echo $theme_color; ?>;}
}
@media (max-width: 768px){
.subscribe-box #mc_embed_signup input:focus{border-color: <?php echo $theme_color; ?>;}
footer .mobile-collapse .mobile-collapse__title:hover{color: <?php echo $theme_color; ?>;}
footer .mobile-collapse.open .mobile-collapse__title{color: <?php echo $theme_color; ?>;}
}
@media (max-width: 991px){
#left-column .slide-column-close {color: <?php echo $theme_color; ?>;}
.table-wishlist .visible-icon .icon {color: <?php echo $theme_color; ?>;}
}
@media (min-width: 1025px) {
.dropdown .dropdown-menu > li > a .icon, .dropdown > a:hover .icon { color: <?php echo $theme_color; ?>;}
header #mainMenu .navbar-nav > li > a .act-underline:before{background-color: <?php echo $theme_color; ?>;}
.navbar-vertical #mainMenu .navbar-nav > li > a:before {background-color: <?php echo $theme_color; ?>;}
.megamenu > li li > a:not(:only-child):after, .megamenu__submenu li a .icon, .megamenu .megamenu__submenu--marked li > a:before {color: <?php echo $theme_color; ?>;}
/*.megamenu__subtitle span:first-child,#mainMenu .mn1 li > ul {border-bottom: 2px solid <?php echo $theme_color; ?> !important;}*/
.megamenu__subtitle:hover span:first-child, .megamenu > li:hover .megamenu__subtitle span {color: <?php echo $theme_color; ?>;}
.navbar.navbar-vertical #mainMenu .navbar-nav > li > a .icon, .navbar.navbar-vertical #mainMenu .navbar-nav > li > a:hover {color: <?php echo $theme_color; ?>;}
.navbar.navbar-vertical #mainMenu .navbar-nav > li:hover .dropdown-menu:before {background-color: <?php echo $theme_color; ?>;}
.cart .dropdown-menu.slide-from-top .cart__item__info__title h2 a {color: <?php echo $theme_color; ?>;}
.cart .dropdown-menu.slide-from-top .cart__item__edit .icon, .cart .dropdown-menu.slide-from-top .cart__item__delete .icon {color: <?php echo $theme_color; ?>;}
#header.header-layout-04 .account:hover .icon {color: <?php echo $theme_color; ?> !important;}
}
@media (max-width: 1024px){
.dropdown > a:hover .icon, .dropdown .dropdown-menu--xs-full a:not(.btn) .icon{color: <?php echo $theme_color; ?>;}
.dropdown .dropdown-menu__close a{color: <?php echo $theme_color; ?> !important;}
.responsive-menu > ul li a:hover, .responsive-menu > ul li.dl-back a, .responsive-menu > ul li.dl-close a, .responsive-menu li > a:not(:only-child):after {
color: <?php echo $theme_color; ?>;}
#cboxClose:hover, .canvas-menu #cboxClose:hover:before {color: <?php echo $theme_color; ?>;}
#off-canvas-menu ul li .name.open a {color: <?php echo $theme_color; ?>;}
#search-dropdown .search__close .icon:hover{color: <?php echo $theme_color; ?>;}
.cart .dropdown-menu .cart__close span, .cart .dropdown-menu .cart__item__info__title h2 a, .cart .dropdown-menu .cart__item__info__details a, .cart .dropdown-menu .btn.btn--ys:hover .icon, .cart .dropdown-menu [data-btn="btn btn--ys"]:hover .icon, .cart .dropdown-menu [data-btn="btn btn--ys"]:focus .icon, .cart .dropdown-menu .btn.btn--ys:focus .icon {color: <?php echo $theme_color; ?>;}
.cart .dropdown-menu .cart__item__control a { max-width: 30px !important;color: <?php echo $theme_color; ?> !important;}
#header .navbar {background-color: <?php echo $theme_color; ?>;}
}
/* Theme Color Ends*/
<?php if($this_is_home_page) { ?>
#indexCategories .category-info{display:none}
#subcategory_names{margin: 30px 0 0}
<?php } ?>
<?php if($border_width != NULL) { ?>
.separator-section hr, .content hr, hr.hr-md {border-width: <?php echo $border_width; ?> 0 0;border-color : <?php echo $border_color; ?>;}
<?php } ?>
<?php if($homepage_layout==2) { ?>
.separator-section hr {
    position: relative;
    top: 0;
    width: 100%;
    display: inline-block;
}
<?php } else { ?>
.separator-section hr {
    width: 100%;
    display: inline-block;
}
<?php } ?>
<?php if(!$this_is_home_page) {?>
header.header-style-1 .header-nav, header.header-style-2 .header-nav {margin-top: 0px;}
header.header-style-2, header.header-style-1 {position:relative;}
header.header-style-1 .header-nav .navbar,header.header-style-2 .header-nav .navbar {background: rgba(0, 0, 0, 0.88) none repeat scroll 0 0;}
<?php } ?>
<?php if($header_style=="header_style_2") { ?>
.breadcrumbs .container {border-top:none !important;}
<?php } ?>
<?php if($header_style=="header_style_3" && (!$this_is_home_page)) { ?>
#header.header-layout-04, footer.layout-2{position: relative;background:#333 none repeat scroll 0 0;}
footer.layout-2{padding-top: 20px;}
@media (max-width: 1024px) {#header.header-layout-04 .logo {position: relative;}
#header.header-layout-04 .search {top: 37px;}
#header.header-layout-04 .cart{top:25px;}
#header.header-layout-04 .account{top:-12px;}
}
<?php } ?>
<?php if(($display_info_boxes ==0 && $display_brands_slider == "no") || $display_info_boxes == 0) { ?>
footer .links-social{margin-top:50px;}
<?php } ?>
<?php if($theme_layout==2){  ?>
.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus, .form-control, input.visibleField{color:<?php echo $theme_color; ?>;}
<?php } ?>
<?php if($latest_newsbox_perallax_image && $newscont_perallax_image_status==1 ){ ?>
	.fixed-bg.news-parallax-bg{background: url("<?php echo $template->get_template_dir('',DIR_WS_TEMPLATE, $current_page_base,'images').'/uploads/'.$latest_newsbox_perallax_image; ?>") center center repeat;}
<?php } ?>
<?php  if (in_array($current_page_base,explode(",",'checkout_shipping_address,checkout_payment,checkout_shipping,checkout_payment_address,checkout_confirmation,checkout_success,shopping_cart'))) { echo "header .cart.link-inline{display:none;}";
} ?>
.navbar-vertical.fill-bg #mainMenu .navbar-nav > li > a::before{background-color:<?php echo $theme_color; ?>;}
.navbar.navbar-vertical.fill-bg #mainMenu .navbar-nav > li > a {background: <?php echo $theme_color; ?> none repeat scroll 0 0;border-bottom:1px solid rgba(250, 250, 250, 0.2);color: #fff;}
</style>
