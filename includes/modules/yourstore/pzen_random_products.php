<?php
/**
 * random_products.php module
 *
 * @package modules
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: random_products.php 8730 2008-06-28 01:31:22Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = array();
$list_of_products = '';
$random_products_query = '';

$random_products_query = "select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name,
                                p.products_date_added, p.products_date_available, p.products_price, p.products_type, 
								p.master_categories_id, p.products_quantity, p.product_is_call
							from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
							where p.products_id = pd.products_id
							and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							and   p.products_status = 1";

//echo $random_products_query;
if ($random_products_query != '') $random_products = $db->ExecuteRandomMulti($random_products_query, MAX_DISPLAY_RANDOM_PRODUCTS);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($random_products_query == '') ? 0 : $random_products->RecordCount();
// show only when 1 or more
if ($num_products_count > 0) {
  if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_RANDOM_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_RANDOM_PRODUCTS == 0 ) {
    $col_width = floor(100/$num_products_count);
  } else {
    $col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_RANDOM_PRODUCTS);
  }

	while (!$random_products->EOF) {
		
		if (!isset($productsInCategory[$random_products->fields['products_id']])) $productsInCategory[$random_products->fields['products_id']] = zen_get_generated_category_path_rev($random_products->fields['master_categories_id']);
		
		$cPath = $productsInCategory[$random_products->fields['products_id']];
		$random_products->fields['cPath'] = $cPath;
				
		//set Infopagelink
		$zen_get_info_page = zen_get_info_page($random_products->fields['products_id']);
		$random_products->fields['zen_get_info_page'] = $zen_get_info_page;
	  
		$products_price = zen_get_products_display_price($random_products->fields['products_id']);
	
		$products_name = $random_products->fields['products_name'];
	
		$product_content = pzen_get_product_content($random_products, array("image_width"=>IMAGE_PRODUCT_RANDOM_WIDTH, "image_height"=>IMAGE_PRODUCT_RANDOM_HEIGHT));	
	
		$list_box_contents[$row][$col] = array('params' => 'class="back centerBoxContentsRandom '.$pzen_randprod_index_class.'"' . ' ', 'text' => (($random_products->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : 
		'<div>
			<div class="carousel-product-popup">
				<div class="product__inside__image '.$product_content['products_class'].'">
					'.$product_content['products_image'].'
					'.$product_content['hover_label_prod'].'
					<div class="product__inside__price price-box">'
						. $products_price .
					'</div>
				</div>
				'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
				<div class="product-hover-popup">
					<div class="product__inside__name">
						<h2 class="product_title"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $random_products->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
						</h2>
					</div>
					<div class="product__inside__price price-box">'
						. $products_price .
					'</div>
					'.$product_content['buy_now'].'
				</div>
			</div>
		</div>')
		);
	
		$col ++;
		if ($col > (SHOW_PRODUCT_INFO_COLUMNS_RANDOM_PRODUCTS - 1)) {
			$col = 0;
			$row ++;
		}
		$random_products->MoveNextRandom();
	}
	if ($random_products->RecordCount() > 0) {
		if($randprod_style=='default') { 
			$title = '<div class="'.$parent_randtitle_class.'">
				<h2 class="'.$parent_randtitle_h2_class.'">'.TABLE_HEADING_RANDOM_PRODUCTS.'</h2>
			</div>';
		}
		$zc_show_random_products = true;
	}
}
?>