<?php
/**
 * specials_index module
 *
 * @package modules
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: specials_index.php 6424 2007-05-31 05:59:21Z ajeh $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

// initialize vars
$categories_products_id_list = array();
$list_of_products = '';
$specials_index_query = '';
$display_limit = '';

if ( (($manufacturers_id > 0 && $_GET['filter_id'] == 0) || $_GET['music_genre_id'] > 0 || $_GET['record_company_id'] > 0) || (!isset($new_products_category_id) || $new_products_category_id == '0') ) {
  $specials_index_query = "select p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added
                           from (" . TABLE_PRODUCTS . " p
                           left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                           left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                           where p.products_id = s.products_id
                           and p.products_id = pd.products_id
                           and p.products_status = '1' and s.status = 1
                           and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
} else {
  // get all products and cPaths in this subcat tree
  $productsInCategory = zen_get_categories_products_list( (($manufacturers_id > 0 && $_GET['filter_id'] > 0) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

  if (is_array($productsInCategory) && sizeof($productsInCategory) > 0) {
    // build products-list string to insert into SQL query
    foreach($productsInCategory as $key => $value) {
      $list_of_products .= $key . ', ';
    }
    $list_of_products = substr($list_of_products, 0, -2); // remove trailing comma
    $specials_index_query = "select distinct p.products_id, p.products_image, pd.products_name, p.master_categories_id, p.products_quantity, p.product_is_call, p.products_date_available, p.products_date_added
                             from (" . TABLE_PRODUCTS . " p
                             left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                             left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                             where p.products_id = s.products_id
                             and p.products_id = pd.products_id
                             and p.products_status = '1' and s.status = '1'
                             and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                             and p.products_id in (" . $list_of_products . ")";
  }
}
if ($specials_index_query != '') $specials_index = $db->ExecuteRandomMulti($specials_index_query, MAX_DISPLAY_SPECIAL_PRODUCTS_INDEX);

$row = 0;
$col = 0;
$list_box_contents = array();
$title = '';

$num_products_count = ($specials_index_query == '') ? 0 : $specials_index->RecordCount();

// show only when 1 or more
if ($num_products_count > 0) {
	if ($num_products_count < SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS || SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS == 0 ) {
		$col_width = floor(100/$num_products_count);
	} else {
		$col_width = floor(100/SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS);
	}

	$list_box_contents = array();
	while (!$specials_index->EOF) {
		if (!isset($productsInCategory[$specials_index->fields['products_id']])) $productsInCategory[$specials_index->fields['products_id']] = zen_get_generated_category_path_rev($specials_index->fields['master_categories_id']);
		
		$cPath = $productsInCategory[$specials_index->fields['products_id']];
		$specials_index->fields['cPath'] = $cPath;
				
		//set Infopagelink
		$zen_get_info_page = zen_get_info_page($specials_index->fields['products_id']);
		$specials_index->fields['zen_get_info_page'] = $zen_get_info_page;
	
		$products_price = zen_get_products_display_price($specials_index->fields['products_id']);
	
		$products_name = $specials_index->fields['products_name'];
		
		$product_content = pzen_get_product_content($specials_index);	
	
	
		$list_box_contents[$row][$col] = array('params' => 'class="back centerBoxContentsSpecials '.$pzen_speprod_index_class.'"' . ' ', 'text' => (($specials_index->fields['products_image'] == '' and PRODUCTS_IMAGE_NO_IMAGE_STATUS == 0) ? '' : 
		'<div class="product '.$product_content['products_class'].'">
			<div class="product__inside">
				<div class="product__inside__image">
					'.$product_content['products_image'].'
					'.$product_content['hover_label_prod'].'
					'.$product_content['hover_label'].'
				</div>
				'.(($product_content['products_new']==1)? '<div class="product__label product__label--right product__label--new"> <span>'.PZEN_BADGE_NEW.'</span></div>' : '').'
				<div class="product__inside__name">
					<h2 class="product_title"><a href="' . zen_href_link($zen_get_info_page, 'cPath=' . $cPath . '&products_id=' . $specials_index->fields['products_id'], 'SSL') . '">' . $products_name . '</a>
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
		if ($col > (SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS - 1)) {
			$col = 0;
			$row ++;
		}
		$specials_index->MoveNextRandom();
	}

	if($sproducts_display_style=='slider') {
		$stitle_with_button = "<div class='carousel-products__button pull-right'> <span class='btn-prev'></span> <span class='btn-next'></span> </div>";
	}

	if ($specials_index->RecordCount() > 0) {
		$title = '<div class="'.$parent_stitle_class.'">'.$stitle_with_button.'
					<h2 class="'.$parent_stitle_h2_class.'">'. sprintf(TABLE_HEADING_SPECIALS_INDEX, strftime('%B')) .'</h2></div>';
		$zc_show_specials = true;
	}
}
?>