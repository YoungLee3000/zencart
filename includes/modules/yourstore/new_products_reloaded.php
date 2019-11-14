<?php
/**
 * new_products.php module
 *
 * @package modules
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: new_products.php 8730 2008-06-28 01:31:22Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
//This page displays the category products entered by user in Theme Admin Panel
// initialize vars
$categories_products_id_list = array();
$list_of_products = '';
$new_products_query = '';

$master_category_id = $featured_category_1;

$display_limit = zen_get_new_date_range();

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $new_products_query = "select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,
                                p.products_date_added, p.products_date_available, p.products_price, p.products_type, 
								p.master_categories_id, p.products_quantity, p.product_is_call 
							from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
							where p.products_id = pd.products_id
							and p.master_categories_id = " . $master_category_id. "
							and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							and   p.products_status = 1 " . $display_limit . " ORDER BY p.products_date_added DESC";
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma

    $new_products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,
                                  p.products_date_added, p.products_date_available, p.products_price, p.products_type, 
								  p.master_categories_id, p.products_quantity, p.product_is_call
                           from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                           where p.products_id = pd.products_id
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                           and p.products_status = 1
                           and p.products_id in (" . $list_of_products . ") ORDER BY p.products_date_added DESC";
  }
}
//echo $new_products_query;
if ($new_products_query != '') $new_products = $db->Execute($new_products_query, MAX_DISPLAY_NEW_PRODUCTS);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($new_products_query == '') ? 0 : $new_products->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
	if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS == 0 ) {
		$col_width = floor(100/$num_products_count);
	} else {
		$col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS);
	}

	while (!$new_products->EOF) {
		
		if (!isset($productsInCategory[$new_products->fields['products_id']])) $productsInCategory[$new_products->fields['products_id']] = zen_get_generated_category_path_rev($new_products->fields['master_categories_id']);
		
		$cPath = $productsInCategory[$new_products->fields['products_id']];
		$new_products->fields['cPath'] = $cPath;
				
		//set Infopagelink
		$zen_get_info_page = zen_get_info_page($new_products->fields['products_id']);
		$new_products->fields['zen_get_info_page'] = $zen_get_info_page;
	  
		$products_price = zen_get_products_display_price($new_products->fields['products_id']);
	
		$products_name = $new_products->fields['products_name'];
	
		$product_content = pzen_get_product_content($new_products);
		

		$list_box_contents[$row][$col] = array('params' => 'class="col-lg-3 centerBoxContentsNewReloaded centerBoxContentsNew product-item back"' . ' ', 'text' => (($new_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : 
		'<div class="product '.$product_content['product_class'].'">
			<div class="product__inside">
				<div class="product__inside__image">
					'.$product_content['products_image'].'
					'.$product_content['hover_label_prod'].'
					'.$product_content['hover_label'].'
				</div>
				'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
				<div class="product__inside__name">
					<h2 class="product_title"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $new_products->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
					</h2>
				</div>
				<div class="product__inside__price price-box">'
					. $products_price .
				'</div>
				<div class="product__inside__review row-mode-visible">
					<div class="rating row-mode-visible">
						'.$product_content['products_review'].'
					</div>
				</div>
				<div class="product__inside__hover">
					<div class="product__inside__info">
						<div class="product__inside__info__btns">
							'.$product_content['buy_now'].$product_content['wishlist_link_alt'].$product_content['compare_link_alt'].'
						</div>
						<ul class="product__inside__info__link hidden-xs">
							<li class="text-right">'.$product_content['wishlist_link'].'</li>
							<li class="text-left">'.$product_content['compare_link'].'</li>
						</ul>
					</div>
					<div class="rating row-mode-hide">
						'.$product_content['products_review'].'
					</div>
				</div>') .  
			'</div>
		 </div>');
	
		$col ++;
		if ($col > (SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS - 1)) {
			$col = 0;
			$row ++;
		}
		$new_products->MoveNext();
	}

	$category_title = zen_get_categories_name((int)$master_category_id);
	if ($new_products->RecordCount() > 0) {
		if($display_category_style == "display_style_1"){
			if (isset($new_products_category_id) && $new_products_category_id != 0 ) {
				$title = '<div class="title-with-button"><div class="carousel-products__button pull-right"> <span class="btn-prev"></span> <span class="btn-next"></span> </div><h2 class="'.$category_title_class.'">'.$category_title. '</h2></div>';
			} else {
				$title = '<div class="title-with-button"><div class="carousel-products__button pull-right"> <span class="btn-prev"></span> <span class="btn-next"></span> </div><h2 class="'.$category_title_class.'">'.$category_title. '</h2></div>';
			}
		}
		$zc_show_new_products = true;
	}
}
?>